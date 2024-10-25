<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order; // Assurez-vous d'importer votre modèle
Use Session;
class OrderController extends Controller
{


    public function storeOrder()
    {
        if(Session::has('cart')) {
            foreach(Session::get('cart')->items as $item) {
                // Créer une nouvelle commande
                Order::create([
                    'product_name' => $item['product_name'],
                    'quantity' => $item['qty'],
                    'price' => $item['product_price'], // Assurez-vous d'avoir cette clé
                ]);
            }
    
            // Optionnel : Vider le panier après l'enregistrement
            Session::forget('cart');
    
            return redirect()->route('checkout.success')->with('success', 'Commande passée avec succès !');
        }
    
        return redirect()->route('checkout')->with('error', 'Votre panier est vide.');
    }
    
}
