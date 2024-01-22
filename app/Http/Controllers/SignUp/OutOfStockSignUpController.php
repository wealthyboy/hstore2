<?php

namespace App\Http\Controllers\SignUp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MailForOutOfStock;

class OutOfStockSignUpController extends Controller
{
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $signup = MailForOutOfStock::where([
               'product_variation_id'=>$request->product_variation_id, 
               'email' => $request->email
            ])->first();
        if (null !== $signup){
            $signup->product_variation_id = $request->product_variation_id;
            $signup->email = $request->email;
            $signup->save();
        } else { 
            $signup = new MailForOutOfStock;
            $signup->product_variation_id = $request->product_variation_id;
            $signup->email = $request->email;
            $signup->save();
        }

        return response(null,200);
    }

    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    
}
