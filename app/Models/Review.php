<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected  $fillable = ['title', 'user_id', 'description', 'image', 'rating', 'product_id', 'product_variation_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function number_of_occurencies($id)
    {
        $result = \DB::table('reviews')->select(\DB::raw('COUNT(rating) AS occurrences'))
            ->groupBy('rating')
            ->orderBy('occurrences', 'DESC')
            ->where(['reviews.product_variation_id' => $id, 'is_verified' => true])
            ->first();
        return $result  !== null ? $result->occurrences : 0;
    }

    public function reviewPercent($number, $total)
    {
        return ($number * 100) / $total;
    }

    public function highest_rating($id)
    {
        $result = static::select('rating')
            ->groupBy('rating')
            ->orderByRaw('COUNT(*) DESC')
            ->where(['reviews.product_variation_id' => $id, 'is_verified' => true])
            ->first();
        return $result !== null ?  $result->rating : 0;
    }


    public function img()
    {
        return $this->image ? $this->image : '/image/utilities/profile.png';
    }
}
