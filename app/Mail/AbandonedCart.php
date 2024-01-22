<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbandonedCart extends Mailable
{
    use Queueable, SerializesModels;

    public $carts;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($carts)
    {
        $this->carts = $carts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Cart')->view('emails.abandoned_cart.index');
    }
}
