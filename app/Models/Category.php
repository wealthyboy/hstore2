<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasChildren;

class Category extends Model
{
    use HasChildren;

    protected $fillable = ['category_name', 'description', 'slug', 'parent_id', 'sort_order', 'allow'];


    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('sort_order', 'asc');
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->where('allow', true);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }


    public function product_variations()
    {
        return $this->belongsToMany(ProductVariation::class)->where('allow', true);
    }


    public function product_variants()
    {
        return $this->belongsToMany(ProductVariation::class)->whereNotNull('name');
    }


    public function isCategoryHaveMultipleChildren()
    {
        $names = [];
        if ($this->children->count()) {
            foreach ($this->children as $children) {
                if ($children->children->count()) {
                    foreach ($children->children as $children) {
                        $names[] = $children->name;
                    }
                }
            }
        }

        return !empty($names) ? true : false;
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->withPivot('id');
    }

    public function child_attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->where('parent_id', null);
    }


    public function attribute_parents()
    {
        return $this->hasMany(AttributeCategory::class)->whereNull('parent_id');
    }


    public function parent_attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->wherePivot('parent_id', null)
            ->withPivot('id');
    }


    public function check($collections, $id)
    {
        foreach ($collections as $collection) {
            if (null !== $collection->id && $collection->id == $id) {
                return $collection->id;
            }
        }
        return false;
    }



    public function getRouteKeyName()
    {
        return 'slug';
    }
}
