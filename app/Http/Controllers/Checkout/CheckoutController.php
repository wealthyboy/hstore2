<?php

namespace App\Http\Controllers\Checkout;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Cart;
use App\Models\SystemSetting;
use App\Http\Controllers\Controller;
use App\Mail\OrderReceipt;
use App\Models\Location;
use App\Http\Helper;
use App\Models\Shipping;
use App\Models\Address;
use App\Models\Live;
use App\Mail\SendGiftCard;




class CheckoutController extends Controller
{
	/**
	 * object to authenticate the call.
	 * @param object $_apiContext
	 */
	// private $_apiContext;


	/**
	 * Set the ClientId and the ClientSecret.
	 * @param 
	 *string $_ClientId
	 *string $_ClientSecret
	 */

	public  $cart;

	public  $settings;

	public function __construct()
	{
		$this->middleware('auth');
		//dd("We on a break");


		$this->settings =  SystemSetting::first();
	}


	public function  index()
	{
		$carts =  Cart::all_items_in_cart();
		if (!$carts->count()) {
			return redirect()->to('/cart');
		}
		$csrf = json_encode(['csrf' => csrf_token()]);
		return view('checkout.index', ['csrf' => $csrf]);
	}


	public function confirm(Request $request, OrderedProduct $ordered_product, Order $order)
	{

		$rate  = Helper::rate();
		$user  = \Auth::user();
		$carts = Cart::all_items_in_cart();
		$cart  = new Cart();
		$order->user_id = $user->id;
		$order->address_id  = $user->active_address->id;
		$code   = trim(session('coupon'));
		$coupon =  Voucher::where('code', $code)->first();
		$order->coupon = null !== $coupon && $coupon->is_gift_card ? null :  session('coupon');
		$order->status = 'Processing';
		$order->shipping_id = $request->shipping_id;
		$order->shipping_price = optional(Shipping::find($request->shipping_id))->converted_price;
		$order->currency = Helper::getCurrency();
		$order->invoice = "INV-" . date('Y') . "-" . rand(10000, 39999);
		$order->payment_type    =  $request->payment_method;
		$order->order_type      =  $request->admin;
		$order->total           =  $request->total;
		$order->delivery_option =  $request->delivery_option;
		$order->delivery_note = $request->delivery_note;
		$order->first_name = optional($user->active_address)->first_name;
		$order->last_name = optional($user->active_address)->last_name;
		$order->address = optional($user->active_address)->address;
		$order->email = optional($user->active_address)->email;
		$order->phone_number = optional($user->active_address)->phone_number;
		$order->city = optional($user->active_address)->city;
		$order->state = optional(optional($user->active_address)->address_state)->name;
		$order->country =  optional(optional($user->active_address)->address_country)->name;
		$order->ip =  $request->ip();
		$order->user_agent      =  $request->server('HTTP_USER_AGENT');
		$order->save();


		foreach ($carts   as $cart) {
			$insert = [
				'order_id' => $order->id,
				'product_variation_id' => $cart->product_variation_id,
				'quantity' => $cart->quantity,
				'status' => "Processing",
				'price' => $cart->ConvertCurrencyRate($cart->price),
				'total' => $cart->ConvertCurrencyRate($cart->quantity * $cart->price),
				'created_at' => \Carbon\Carbon::now()
			];
			OrderedProduct::Insert($insert);
			$product_variation = ProductVariation::find($cart->product_variation_id);
			$qty  = $product_variation->quantity - $cart->quantity;
			$product_variation->quantity =  $qty < 1 ? 0 : $qty;
			$product_variation->save();



			if ($cart->is_gift_card) {
				try {
					$when = now()->addMinutes(5);
					\Mail::to($cart->gift_card_to_email)
						->send(new SendGiftCard($cart, $this->settings));
				} catch (\Throwable $th) {
					Log::info("Mail error :" . $th);
				}
			}

			//Delete all the cart
			//$cart->status = 'paid';
			////$cart->delete();
		}


		$admin_emails = explode(',', $this->settings->alert_email);
		$symbol = Helper::getCurrency();
		$total =  \DB::table('ordered_product')->select(\DB::raw('SUM(ordered_product.price*ordered_product.quantity) as items_total'))->where('order_id', $order->id)->get();
		$sub_total = $total[0]->items_total ?? '0.00';

		try {
			$when = now()->addMinutes(5);

			//dd($order->load('ordered_products'));
			\Mail::to(optional($user->active_address)->email)
				->bcc($admin_emails[0])
				->send(new OrderReceipt($order, $this->settings, $symbol, $sub_total));
		} catch (\Throwable $th) {
			\Log::info("Mail error :" . $th);
		}

		//delete cart
		//$affectedRows = Cart::delete_items_in_cart_purchased();
		if ($request->session()->has('coupon')) {
			if (null !== $coupon && $coupon->type == 'specific') {
				$coupon->update(['valid' => false]);
			}

			if (null !== $coupon && $coupon->is_gift_card) {
				if ($coupon->amount == $order->total) {
					$coupon->update(['amount' => 0]);
				} else if ($coupon->amount > $order->total) {
					$new_total = $coupon->amount - $order->total;
					$coupon->update(['amount' => $new_total]);
				}
			}
		}
		//unset the coupon
		$request->session()->forget('coupon');
		$request->session()->forget('coupon_total');
		\Cookie::queue(\Cookie::forget('cart'));
		return response()->json([
			'status' => 'Order pLaced'
		], 200);
	}


	protected function coupon(Request $request)
	{

		$cart_total = Cart::sum_items_in_cart();
		$items_on_sale_in_cart_total  = Cart::sum_sale_items_in_cart();
		$items_not_on_sale_in_cart_total   = Cart::sum_items_in_cart_that_is_not_on_sale();
		if (!$cart_total) {
			$error['error'] = 'We cannot process your voucher';
			return response()->json($error, 422);
		}

		if (!$items_not_on_sale_in_cart_total && $items_on_sale_in_cart_total) {
			$error['error'] = 'Coupon deos not apply on sale items';
			return response()->json($error, 422);
		}

		$user  =  \Auth::user();
		// Build the input for validation
		$coupon = array('coupon' => $request->coupon);
		// Tell the validator that this file should be an image
		$rules = array(
			'coupon' => 'required'
		);

		// Now pass the input and rules into the validator
		$validator = \Validator::make($coupon, $rules);

		if ($validator->fails()) {
			return response()->json($validator->messages(), 422);
		}

		$coupon =  Voucher::where('code', $request->coupon)
			->where('status', 1)
			->first();

		$error = array();


		if (empty($coupon)) {
			$error['error'] = 'Your code  is invalid ';
			return response()->json($error, 422);
		}


		if ($coupon->is_gift_card) {
			if ($coupon->amount  < 1) {
				$error['error'] = 'Your gift card balance is 0.';
				return response()->json($error, 422);
			}

			$request->session()->put(['coupon' => $request->coupon]);
			return response()->json($coupon, 200);
		}


		if ($coupon->is_coupon_expired()) {
			$error['error'] = 'Coupon has expired  ';
			return response()->json($error, 422);
		}


		if ($cart_total < $coupon->from_value) {
			$error['error'] = 'You can only use this coupon when your purchase is above  ' . $this->settings->currency->symbol . $coupon->from_value;
			return response()->json($error, 422);
		}


		if (!$coupon->is_valid()) {
			$error['error'] = 'Coupon is invalid ';
			return response()->json($error, 422);
		}
		//get all the infomation 
		$total = [];
		$total['currency'] = $this->settings->currency->symbol;
		$total['message'] = $items_on_sale_in_cart_total ? 'Coupon will not apply on already discounted products.' : null;
		if (!empty($coupon->from_value) && $cart_total >= $coupon->from_value) {
			$new_total = ($coupon->amount * $items_not_on_sale_in_cart_total) / 100;
			$new_total = $items_not_on_sale_in_cart_total - $new_total;
			$items_total = $items_on_sale_in_cart_total ? $items_on_sale_in_cart_total : 0;
			$new_total = $new_total + $items_total;
			$total['sub_total'] = round($new_total, 0);
			$request->session()->put(['new_total' => $new_total]);
			$request->session()->put(['coupon_total' => $new_total]);
			$request->session()->put(['coupon' => $request->coupon]);
			$total['percent'] = $coupon->amount . '%  percent off';
			return response()->json($total, 200);
		} else if (!empty($coupon->from_value) && $cart_total < $coupon->from_value) {
			$error['error'] = 'Coupon is invalid ';
			return response()->json($error, 422);
		} else {
			$new_total = ($coupon->amount * $items_not_on_sale_in_cart_total) / 100;
			$new_total = $items_not_on_sale_in_cart_total - $new_total;
			$items_total = $items_on_sale_in_cart_total ? $items_on_sale_in_cart_total : 0;
			$new_total = $new_total + $items_total;
			$total['sub_total'] =   $new_total;
			$request->session()->put(['new_total' => $new_total]);
			$request->session()->put(['coupon_total' => $new_total]);
			$request->session()->put(['coupon' => $request->coupon]);
			$total['percent'] = $coupon->amount . '%  percent off';
			return response()->json($total, 200);
		}
	}
}
