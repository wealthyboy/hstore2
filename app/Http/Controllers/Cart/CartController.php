<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\PendingCart;

class CartController  extends Controller
{

	public function index()
	{
		$page_title = "Your Cart  ";
		return view('carts.index', compact('page_title'));
	}

	public function meta(Request $request)
	{

		$pending_cart = PendingCart::firstOrNew(
			['user_id' => $request->user_id]
		);
		$pending_cart->cart_ids = $request->cartId;
		$pending_cart->coupon = $request->coupon;
		$pending_cart->delivery_note = $request->delivery_note;
		$pending_cart->delivery_option = $request->delivery_option;
		$pending_cart->shipping_id = $request->shipping_id;
		$pending_cart->uuid = $request->uuid;
		$pending_cart->total = $request->total;
		$pending_cart->save();
		return $pending_cart;
	}
}
