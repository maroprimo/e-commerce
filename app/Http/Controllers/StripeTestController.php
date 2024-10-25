<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeTestController extends Controller
{
    public function index()
    {
        try {
            // Utilisation de la clé API définie dans le fichier .env
            Stripe::setApiKey(env('sk_test_WnAMfuQSNGVkt9dZr0L7kC3M00FuaaA5i8'));

            // Test : Récupérer les 10 premiers clients
            $customers = \Stripe\Customer::all(['limit' => 10]);

            return response()->json($customers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
