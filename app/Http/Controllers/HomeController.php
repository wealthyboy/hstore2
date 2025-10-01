<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

use App\Models\Live;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Information;
use App\Models\User;
use App\Models\SystemSetting;
use App\Http\Helper;
use App\Models\Image;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Cookie;



class HomeController extends Controller
{
    

    public function index(Request $request)
    {
        $site_status = Cache::remember('site_status', 60*30, function () {
            return Live::first();
        });

        $banners = Cache::remember('banners', 60*30, function () {
            return Banner::banners()->get();
        });

        $sliders = Cache::remember('sliders', 60*30, function () {
            return Banner::sliders()->get();
        });

        $products = Cache::remember('latest_products', 60*30, function () {
            return ProductVariation::whereNotNull('price')
                ->where('price', '>', 0)
                ->whereNotNull('name')
                ->where('name', '!=', '')
                 ->where('featured',  true)
                ->orderBy('updated_at', 'DESC')
                ->take(8)
                ->get();
        });


        $reviews = Cache::remember('recent_reviews', 60*30, function () {
            return Review::where('is_verified', 1)
                ->inRandomOrder()
                ->orderBy('created_at', 'DESC')
                ->take(20)
                ->get();
        });

        $posts = Cache::remember('recent_posts', 60*30, function () {
            return Information::orderBy('created_at', 'DESC')
                ->where(['blog' => true, 'is_active' => true])
                ->take(6)
                ->get();
        });

        // under construction logic
        if (!$site_status->make_live) {
            return view('index', compact('sliders', 'banners', 'reviews', 'products', 'posts'));
        } else {
            if (auth()->check() && auth()->user()->isAdmin()) {
                return view('index', compact('sliders', 'banners', 'reviews', 'products', 'posts'));
            }
            return view('underconstruction.index');
        }
    }

}
