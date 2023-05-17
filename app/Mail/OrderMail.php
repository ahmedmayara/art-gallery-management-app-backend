<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $customerFirstName;
    protected $customerLastName;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $customerFirstName, $customerLastName)
    {
        $this->order = $order;
        $this->customerFirstName = $customerFirstName;
        $this->customerLastName = $customerLastName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('ahmedmayara789@gmail.com')->view('approved')->with([
            'order' => $this->order,
            'customer' => $this->customerFirstName . ' ' . $this->customerLastName,
        ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'approved',
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
