<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasChildren;
use App\Traits\ImageFiles;




class Information extends Model
{
    use HasChildren, ImageFiles; //,SoftDeletes,CascadeSoftDeletes;


    protected $fillable = ['user_id', 'title', 'description'];

    public $folder = 'blog';

    public $appends = [
        'link',
        'image_m',
    ];

    protected $table = 'information';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_information')
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


    public function children()
    {
        return $this->hasMany(Information::class, 'parent_id', 'id')->orderBy('sort_order', 'asc');
    }

    public function getLinkAttribute()
    {
        return $this->custom_link !== null ? $this->custom_link : '/pages/' . $this->slug;
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
