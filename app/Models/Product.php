<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Carbon\Carbon;
use App\Traits\HasChildren;
use App\Traits\FormatPrice;
use App\Traits\ImageFiles;
use App\Filters\ProductsFilter\ProductFilters;


class Product extends Model
{
	//

	use HasChildren, FormatPrice, ImageFiles; //,SoftDeletes,CascadeSoftDeletes;

	public $folder = 'products';

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at', 'sale_price_expires', 'sale_price_starts'];
	//#c28562

	public $appends = [
		'discounted_price',
		'default_discounted_price',
		'link',
		'currency',
		'converted_price',
		'brand_name',
		'image_to_show',
		'default_variation_id',
		'percentage_off',
		'default_percentage_off',
		'add_images',
		'customer_price',
		'qty',
		'is_wishlist',
		'image_m',
		'image_tn',
		'image_to_show_m',
		'image_to_show_tn',
		'colours',

	];

	protected $cascadeDeletes = ['meta_fields', 'attributes', 'variants', 'categories'];

	protected $fillable = ['featured'];

	protected $setting;

	public function __construct()
	{
		$this->setting = SystemSetting::first();
	}


	public function variants()
	{
		return  $this->hasMany(ProductVariation::class)
			->where(['default' => false])->whereNotNull('name')
			->orderBy('created_at', 'asc');
	}


	public function featuredVariant()
	{
		return  $this->hasOne(ProductVariation::class)
			->where(['default' => false, 'featured' => true])->whereNotNull('name');
	}


	public function product_variations()
	{
		return  $this->hasMany(ProductVariation::class)
			->where(['default' => false])
			->orderBy('created_at', 'asc');
	}



	public function variant()
	{
		return $this->hasOne(ProductVariation::class)->whereDefault(false);
	}


	public function default_variation()
	{
		return $this->hasOne(ProductVariation::class)->whereDefault(true);
	}


	public function colors()
	{
		return $this->belongsToMany(Attribute::class)
			->groupBy('attribute_id')
			->whereNotNull(['color_code']);
	}


	public function getColoursAttribute()
	{
		return $this->colors;
	}


	public function product_variation_values()
	{
		return $this->hasMany(ProductVariationValue::class);
	}


	public function getIsWishlistAttribute()
	{
		return null !== Favorite::where('product_variation_id', $this->default_variation_id)->first() ? true : false;
	}

	public function stock()
	{
		return  $this->quantity == 0 ? 'Out of stock' : '₦' . number_format($this->price) . ' ' . $this->quantity . ' Left';
	}

	public function favorites()
	{
		return $this->hasOne('App\Favorite');
	}

	public function link()
	{
		$slug = $this->categories->count() ? $this->categories->first()->slug : null;
		$pv_slug =  $this->slug;
		$link  = '/product/';
		$link .=  optional(optional($this->category)->category)->slug ?
			optional(optional($this->category)->category)->slug . '/' :
			$slug . '/';
		$link .= $pv_slug;
		return $link;
	}

	public function scopeFilter(Builder $builder, $request)
	{
		return (new ProductFilters($request))->filter($builder);
	}

	public function category()
	{
		return $this->hasOne(CategoryProduct::class)->where('category_id', optional($this->pivot)->category_id);
	}

	public function attribute()
	{
		return $this->hasOne(AttributeProduct::class)->where('parent_id', optional($this->pivot)->parent_id);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class)->withPivot('category_id');
	}


	public function related_products()
	{
		return $this->hasMany(RelatedProduct::class);
	}


	public function attributes()
	{
		return  $this->belongsToMany(Attribute::class)
			->groupBy('attribute_id')
			->withPivot('attribute_id')
			->withPivot('parent_id')
			->withPivot('id');
	}


	public function product_variation_attributes()
	{
		return $this->hasMany(ProductVariationAttribute::class);
	}


	public function product_variation_attribute()
	{
		return $this->hasOne(ProductVariationAttribute::class);
	}


	public function parent_attributes()
	{
		return $this->belongsToMany(Attribute::class)
			->groupBy('attribute_id')
			->wherePivot('parent_id', null)
			->withPivot('id')
			->withPivot('product_id');
	}


	public function meta_fields()
	{
		return  $this->belongsToMany(Attribute::class, 'meta_field')
			->groupBy('attribute_id')
			->withPivot([
				'attribute_id',
				'image',
			])
			->withPivot('id');
	}


	public function images()
	{
		return $this->morphMany(Image::class, 'imageable')->orderBy('id', 'asc')->where('image', '!=', 'No Image');
	}


	public function newProducts()
	{
		return $this->created_at->diffInDays(Carbon::now(), 7);
	}


	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}


	public function reviews()
	{
		return $this->hasMany(Review::class);
	}


	public function ordered_product()
	{
		return $this->hasOne(OrderedProduct::class);
	}


	public function getRouteKeyName()
	{
		return 'slug';
	}


	public function getLinkAttribute()
	{
		return $this->link();
	}


	public function getDefaultVariationIdAttribute()
	{
		return $this->product_type == 'variable'
			? optional($this->variant)->id
			: optional($this->default_variation)->id;
	}


	public function getQtyAttribute()
	{
		return $this->product_type == 'variable'
			? optional($this->variant)->quantity
			: $this->quantity;
	}


	public function getItemIsWishlistAttribute()
	{
		if (auth()->check()) {
			return auth()->user()->favorites()->where("product_variation_id", $this->default_variation_id)->count();
		}
		return null;
	}


	public function getBrandNameAttribute()
	{
		return optional($this->brand)->brand_name;
	}


	public function getDefaultDiscountedPriceAttribute()
	{
		return $this->formatted_discount_price();
	}
}
