<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OutOfStockMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product_variation;

    public function __construct($pd)
    {
        $this->product_variation = $pd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->subject('Product now available')->view('emails.out_of_stock.index');
    }
}
