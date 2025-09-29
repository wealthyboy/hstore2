<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;


class Banner extends Model
{
    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('banners');
            Cache::forget('sliders');
        });

        static::deleted(function () {
            Cache::forget('banners');
            Cache::forget('sliders');
        });
    }


    public function scopeSliders(Builder $builder)
    {
        return $builder->where('is_slider', true)->orderBy('sort_order', 'asc');
    }

    public function scopeBanners(Builder $builder)
    {
        return $builder->where('is_slider', false)->orderBy('sort_order', 'asc');
    }

    public function image_path()
    {
        return asset('image/banners/' . $this->image);
    }
}
