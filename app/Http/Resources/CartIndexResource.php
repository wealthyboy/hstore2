<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Cart;

class CartIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_variation_id' => $this->product_variation_id,
            'product_variation' => $this->product_variation,
            'image' => optional($this->product_variation)->image_tn,
            'quantity' => $this->quantity,
            'is_gift_card' => $this->is_gift_card,
            'name'     => optional($this->product_variation)->name,
            'price' => Cart::ConvertCurrencyRate($this->real_price),
            'currency' => optional($this->product_variation)->currency,
            'product_name' => optional(optional($this->product_variation)->product)->product_name,
            'variations' => optional(optional($this->product_variation)->product_variation_values)->pluck('name')->toArray(),
            'gift_card_to_email' => $this->gift_card_to_email,
            'gift_card_to_name' =>  $this->gift_card_to_name
        ];
    }
}
