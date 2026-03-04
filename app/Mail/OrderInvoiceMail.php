<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $emailType;

    public function __construct(Order $order, string $emailType)
    {
        $this->order = $order;
        $this->emailType = $emailType;
    }

    // public function getVar(Order $order, string $emailType): void
    // {
    //     $this->order = $order;
    //     $this->emailType = $emailType;
    // }

public function build()
{
    $subject = $this->emailType === 'customer'
        ? 'Thank you for your order! #' . $this->order->id
        : 'New Order Received! #' . $this->order->id;

    return $this->subject($subject)
                ->view('emails.order-invoice')
                ->with([
                    'order'     => $this->order,
                    'emailType' => $this->emailType,
                ]);
}
}
