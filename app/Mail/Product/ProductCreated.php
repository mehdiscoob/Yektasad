<?php

namespace App\Mail\Product;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The product instance.
     *
     * @var Product
     */
    public Product $product;

    /**
     * Create a new message instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->subject('New Product Created')
            ->view('emails.product_created');
    }
}
