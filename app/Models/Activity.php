<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Activity extends Model
{
    //
    use softDeletes;

    public  function  Log($action, $json = null)
    {
        $this->user_id = \Auth::user()->id;
        $this->email = \Auth::user()->email;
        $this->username = \Auth::user()->name;
        $this->json = $json;
        $this->action = $action;
        $this->save();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
