<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Order;
use Session;
use PDF; // alias de Barryvdh\DomPDF\Facade

class PdfController extends Controller

{
    //
    

    public function generatePdf($id)
    {
        // Instanciation de Dompdf
        $dompdf = new Dompdf();
        $order = Order::find($id);
    
        
            $name = $order->product_name;
            $quantity = $order->quantity;
            $date = $order->created_at;
        
    /*
        $order->transform(function($order, $key){
            $order->panier = unserialize($order->panier);
            return $order;
        });*/
    
        // Génération du contenu HTML à convertir en PDF
        $html = "
            <h1>Mon titre PDF</h1>
            <p>Ceci est un test de génération de PDF avec dompdf.</p>
            <table border='1'>
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Client Address</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$name}</td>
                        <td>{$quantity}</td>
                        <td>{$date}</td>
                    </tr>
                </tbody>
            </table>";
            
        
        // Charger le HTML dans dompdf
        $dompdf->loadHtml($html);
        
        // (Optionnel) Définir le format du papier et l'orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Rendre le PDF
        $dompdf->render();
        
            // Ajouter les en-têtes HTTP pour le PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="mon_fichier.pdf"');
    header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
    header('Pragma: no-cache'); // HTTP 1.0
    header('Expires: 0'); // Proche du passé

    // Sortir le PDF au navigateur
    return $dompdf->stream("mon_fichier.pdf", ["Attachment" => false]);
        
    }

    public function voir1_pdf($id){

        Session::put('id', $id);
        try{
            $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
            $pdf->loadHTML($this->convert_orders_data_to_html());

            return $pdf->stream();
        }
        catch(\ Exception $e){
            return redirect('/commandes')->with('error', $e->getMessage());
        }
    }

    public function convert_orders_data_to_html(){

        $orders = Order::where('id',Session::get('id'))->get();

        foreach($orders as $order){
            $name = $order->product_name;
            $quantity = $order->quantity;
            $date = $order->created_at;
        }

        $orders->transform(function($order, $key){
            $order->panier = unserialize($order->panier);

            return $order;
        });

        $output = '<link rel="stylesheet" href="frontend/css/style.css">
                        <table class="table">
                            <thead class="thead">
                                <tr class="text-left">
                                    <th>Client Name : '.$name.'<br> Client Address : '.$quantity.' <br> Date : '.$date.'</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Image</th>
                                    <th>Product name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        foreach($orders as $order){
            foreach($order->panier->items as $item){

                $output .= '<tr class="text-center">
                                <td class="image-prod"><img src="storage/product_images/'.$item['product_image'].'" alt="" style = "height: 80px; width: 80px;"></td>
                                <td class="product-name">
                                    <h3>'.$item['product_name'].'</h3>
                                </td>
                                <td class="price">$ '.$item['product_price'].'</td>
                                <td class="qty">'.$item['qty'].'</td>
                                <td class="total">$ '.$item['product_price']*$item['qty'].'</td>
                            </tr><!-- END TR-->
                            </tbody>';

            }

            $totalPrice = $order->panier->totalPrice; 

        }

        $output .='</table>';

        $output .='<table class="table">
                        <thead class="thead">
                            <tr class="text-center">
                                    <th>Total</th>
                                    <th>$ '.$totalPrice.'</th>
                            </tr>
                        </thead>
                    </table>';


        return $output;
                
    

    }
}

