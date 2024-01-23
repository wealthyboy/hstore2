<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Live;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Information;
use App\Models\Currency;
use App\Models\SystemSetting;
use App\Http\Helper;
use App\Models\Image;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $site_status = Live::first();
        $banners = Banner::banners()->get();




        $products = ProductVariation::where('featured', 1)->orderBy('updated_at', 'DESC')->take(8)->get();
        //  if ($request->debug) {
        //      dd($products);
        //  }
        // if (null !== $products){

        //     foreach ($products as $key => $product) {
        //         # code...
        //         $product->update([
        //             'featured' => 0
        //         ]);
        //     }
        // }


        $reviews = Review::where('is_verified', 1)->inRandomOrder()->orderBy('created_at', 'DESC')->take(20)->get();
        $posts = Information::orderBy('created_at', 'DESC')->where(['blog' => true, 'is_active' => true])->take(6)->get();

        return view('index', compact('banners', 'reviews', 'products', 'posts'));

        if (!$site_status->make_live) {
            return view('index', compact('banners', 'reviews', 'products', 'posts'));
        } else {
            //Show site if admin is logged in
            if (auth()->check()  && auth()->user()->isAdmin()) {
                return view('index', compact('banners', 'reviews', 'products', 'posts'));
            }
            return view('underconstruction.index');
        }
    }
}
