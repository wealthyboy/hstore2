<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\SystemSetting;
use Illuminate\Database\Eloquent\Builder;


class Address extends Model
{
    public $appends = [
        'country',
        'state'
    ];
    //
    //brings out the info in the addreses table that belongs to the customer

    protected $table = 'addresses';

    protected $fillable = [
        'first_name', 'last_name', 'customer_id', 'address', 'address_2', 'city', 'state', 'state_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address_state()
    {
        return $this->belongsTo(Location::class, 'state_id');
    }


    public function parent_shippings()
    {
        return $this->hasMany(Shipping::class, 'location_id');
    }

    public function getStateAttribute()
    {
        return $this->address_state->name;
    }

    public function getCountryAttribute()
    {
        return $this->address_country->name;
    }

    public function address_country()
    {
        return $this->belongsTo(Location::class, 'country_id');
    }

    public function fullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    public function shipping()
    {
        return $this->hasManyThrough(Shipping::class, Location::class, 'id', 'location_id')->where('parent_id', null);
    }
}
