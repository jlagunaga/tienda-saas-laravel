<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Mail\Mailables\Address;

class NewOrderSellerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $store;
    
    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Store $store)
    {
        $this->order = $order;
        $this->store = $store;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'),config('app.name')),
            subject: '¡Nuevo pedido recibido en ' . $this->store->name . '(#'. $this->order->id .')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-order-seller',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
