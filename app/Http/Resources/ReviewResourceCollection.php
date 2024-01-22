<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResourceCollection extends JsonResource
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
            'title' => $this->title,
            'full_name' => optional($this->user)->name .' '.optional($this->user)->last_name,
            'description' => $this->description,
            'date' => $this->created_at->diffForHumans(),
            'rating' => $this->rating,
            'product_name' => $this->product->product_name,
            'image' => $this->image

        ];
    }
}
