<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $fillable = ['name', 'use_users'];

    public function news_letters()
    {
        return $this->hasMany(Newsletter::class);
    }
}
