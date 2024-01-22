<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendGiftCard extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;

    public $settings;

    public function __construct($cart, $settings)
    {
        $this->cart = $cart;
        
        $this->settings = $settings;
    }

    
    public function build()
    {   
        return $this->subject('A Gift For You')->view('emails.gift_cards.index');
    }
}
