<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Order;
use App\OrderArticle;
use Session;
use PDF; 
use Barryvdh\DomPDF\Facade;

class PdfController extends Controller
{
    //
    

    public function generatePdf($id)
    {
        // Instanciation de Dompdf
        $dompdf = new Dompdf();
        $order = Order::with('items')->findOrFail($id);
    
        // Variables à utiliser dans le HTML
        $clientName = $order->nom;
        $clientAddress = $order->adresse;
        $clientCountry = $order->pays;
        $clientEmail = $order->email;
        $totalPrice = number_format($order->total_price, 2);
        $itemsHtml = "";
    
        // Boucle pour générer les lignes d'articles dans la table
        foreach ($order->items as $item) {
            $productName = $item->product_name;
            $quantity = $item->quantity;
            $unitPrice = number_format($item->price, 2);
            $itemTotal = number_format($quantity * $item->price, 2);
    
            $itemsHtml .= "
                <tr>
                    <td>{$productName}</td>
                    <td>{$quantity}</td>
                    <td>{$unitPrice} €</td>
                    <td>{$itemTotal} €</td>
                </tr>";
        }
    
        // Contenu HTML à convertir en PDF
        $html = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .invoice-header, .invoice-footer { text-align: center; }
            .invoice-title { font-size: 24px; font-weight: bold; }
            .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .table th, .table td { border: 1px solid #ddd; padding: 8px; }
            .table th { background-color: #f2f2f2; text-align: left; }
            .total { font-weight: bold; }
        </style>
    </head>
    <body>
        <div class=\"invoice-header\">
            <h1 class=\"invoice-title\">Facture</h1>
        </div>
        
        <div>
            <p><strong>Nom client:</strong> {$clientName}</p>
            <p><strong>Adresse:</strong> {$clientAddress}</p>
            <p><strong>Pays:</strong> {$clientCountry}</p>
            <p><strong>Email:</strong> {$clientEmail}</p>
        </div>
    
        <table class=\"table\">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {$itemsHtml}
                <tr>
                    <td colspan=\"3\" class=\"total\">Total</td>
                    <td class=\"total\">{$totalPrice} €</td>
                </tr>
            </tbody>
        </table>
    
        <div class=\"invoice-footer\">
            <p>Merci pour votre achat !</p>
        </div>
    </body>
    </html>";
    
        // Charger le HTML dans dompdf
        $dompdf->loadHtml($html);
        
        // (Optionnel) Définir le format du papier et l'orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Rendre le PDF
        $dompdf->render();
        
        // Télécharger le PDF
        return $dompdf->stream("facture_{$order->id}.pdf", ["Attachment" => true]);
        
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


