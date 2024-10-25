<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\CoursEuro;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;
    public $coursEuro;
    public $totalPriceSimple;
    public $shippingCost;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $totalPriceSimple, $shippingCost)
    {
        //
        $this->order = $order;
        // Récupérer les données de CoursEuro, par exemple le dernier taux
        $this->coursEuro = CoursEuro::latest()->first(); // Récupère le dernier enregistrement via model base
        $this->totalPriceSimple = $totalPriceSimple;
        $this->shippingCost = $shippingCost;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->from('marakout@gmail.com')
                    ->subject('Votre commande sur Art Epice a été reçue')
                    ->view('mail.facture')
                    ->with([
                        'order' => $this->order,   // Passer la commande à la vue
                        'coursEuro' => $this->coursEuro, // Passer le taux récupéré à la vue
                        'shippingCost' => $this->shippingCost, // passer le tarif 
                        'totalPriceSimple' => $this->totalPriceSimple// total prix sans expedition
                    ]);
    }
}
