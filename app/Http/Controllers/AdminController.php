<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderArticle;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderUpdateMail;
use App\Mail\OrderProcessedMail;

class AdminController extends Controller
{
    //
    public function dashboard(){
        
        return view('admin.dashboard');
    }

    public function commandes(){
        $orders = Order::with('items')->get();
        return view('admin.commandes', compact('orders'));
    }  
    
    
    
    public function deleteOrder($id) {
        // Suppression des articles liés
        OrderArticle::where('order_id', $id)->delete();
        
        // Suppression de la commande elle-même
        Order::where('id', $id)->delete();
    
        return redirect()->back()->with('success', 'Commande supprimée avec succès.');
    }

    public function sendOrderUpdateEmail($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            Mail::to($order->email)->send(new OrderUpdateMail($order));
            return redirect()->back()->with('success', 'Email envoyé au client.');
        }
        return redirect()->back()->with('error', 'Commande non trouvée.');
    }

    public function sendOrderProcessedEmail($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            Mail::to($order->email)->send(new OrderProcessedMail($order)); // OrderProcessedMail est une autre classe de mail que vous allez créer
            return redirect()->back()->with('success', 'Email de commande traitée envoyé au client.');
        }
        return redirect()->back()->with('error', 'Commande non trouvée.');
    }



}



