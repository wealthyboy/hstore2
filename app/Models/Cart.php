<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\FormatPrice;
use App\Http\Helper;



class Cart extends Model
{

	protected $table = 'carts';

	public $timestamps = false;

	protected $fillable =
	[
		'product_id',
		'user_id',
		'remember_token',
		'quantity',
		'total',
		'price',
		'product_variation_id',
		'status',
		'is_sale_product',
		'is_sale_product',
		'gift_card_to_name',
		'gift_card_to_email',
		'gift_card_comment',
		'gift_card_from_name',
		'gift_card_from_email',
		'gift_card_token',
		'gift_card_amount',
	];

	public $appends = [
		'sub_total',
		'converted_price',
		'customer_price',
		'cart_total',
		'real_price'
	];



	public static function all_items_in_cart()
	{
		//SELECT ALL FROM THE USER ID && FROM THE USER COOKIE
		$cookie = \Cookie::get('cart');
		$carts = Cart::with(["product_variation", "product_variation.product", "product_variation.product_variation_values"])->where(['carts.remember_token' => $cookie])->get();
		static::sync($carts);
		return $carts;
	}

	public static function items_in_cart()
	{
		//SELECT ALL FROM THE USER ID && FROM THE USER COOKIE
		$cookie = \Cookie::get('cart');
		$carts = Cart::with(["product_variation", "product_variation.product", "product_variation.product_variation_values"])->where(['carts.remember_token' => $cookie, 'carts.quantity', '>=', 1])->get();
		static::sync($carts);
		return $carts;
	}

	public  static function sync($carts)
	{
		if (null == $carts) return null;
		foreach ($carts as $cart) {
			if (null == $cart->product_variation) {
				$cart->delete();
			}

			if (null !== $cart->product_variation && $cart->product_variation->quantity  == 0) {
				$cart->update([
					'quantity' => 0,
				]);
			}

			$cart->update([
				'user_id' => optional(auth()->user())->id,
				'price' => $cart->real_price,
				'total' => $cart->real_price * $cart->quantity
			]);
		}
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}


	public function user()
	{
		return $this->belongsTo(User::class);
	}


	public function product_variation()
	{
		return $this->belongsTo(ProductVariation::class);
	}

	public function voucher()
	{
		return $this->hasOne(Voucher::class);
	}

	public static function sum_items_in_cart()
	{
		$cookie = \Cookie::get('cart');
		$total = \DB::table('carts')->select(\DB::raw('SUM(carts.total) as items_total'))->where('remember_token', $cookie)->where('quantity', '>=', 1)->get();
		return 	static::ConvertCurrencyRate($total = $total[0]->items_total);
	}



	public static function sum_sale_items_in_cart()
	{
		$cookie = \Cookie::get('cart');
		$total = \DB::table('carts')->select(\DB::raw('SUM(carts.total) as items_total'))->where(['remember_token' => $cookie, 'is_sale_product' => true])->where('quantity', '>=', 1)->get();
		return 	static::ConvertCurrencyRate($total = $total[0]->items_total);
	}


	public static function sum_items_in_cart_that_is_not_on_sale()
	{
		$cookie = \Cookie::get('cart');
		$total = \DB::table('carts')->select(\DB::raw('SUM(carts.total) as items_total'))->where(['remember_token' => $cookie, 'is_sale_product' => false])->where('quantity', '>=', 1)->get();
		return 	static::ConvertCurrencyRate($total = $total[0]->items_total);
	}


	public static function cart_number()
	{
		$cookie = \Cookie::get('cart');
		$number_products_in_cart = \DB::table('carts')->select('carts.*')->where('remember_token', $cookie)->count();
		return $number_products_in_cart;
	}

	public static function ConvertCurrencyRate($price)
	{
		$rate = Helper::rate();
		if ($rate) {
			return round(($price * $rate->rate), 0);
		}
		return round($price, 0);
	}


	public static function delete_items_in_cart_purchased()
	{
		$cookie = \Cookie::get('cart');
		$delete_cart = \DB::table('carts')->select('carts.*')->where('remember_token', $cookie)->delete();
		return $delete_cart;
	}


	public function getCustomerPriceAttribute()
	{
		return $this->converted_price;
	}


	public function getRealPriceAttribute()
	{
		if ($this->product_variation->is_gift_card) {
			return $this->price;
		}
		return $this->product_variation->discounted_price ?  $this->product_variation->discounted_price : $this->product_variation->price;
	}


	public function getConvertedPriceAttribute()
	{
		return static::ConvertCurrencyRate($this->price);
	}



	public function getCartTotalAttribute()
	{
		return  static::ConvertCurrencyRate($this->total);
	}

	public function getSubTotalAttribute()
	{
		return  static::ConvertCurrencyRate(static::sum_items_in_cart());
	}
}
