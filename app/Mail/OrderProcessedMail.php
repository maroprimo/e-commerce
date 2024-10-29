<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;

class OrderProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->order->status = 'Traitée'; // ou le statut approprié
        $this->order->save(); // Sauvegarder les modifications dans la base de données
    }

    public function build()
    {
        return $this->view('mail.order_processed')
                    ->with(['order' => $this->order])
                    ->subject('Votre commande a été traitée');
    }
}
