<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderArticle;
use Session;

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
}
