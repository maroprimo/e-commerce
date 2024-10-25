<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Product;
use App\Category;
use App\Cart;
use Session;
use App\Order;
use App\OrderArticle;
use Stripe\Charge;
use Stripe\Stripe;
use App\Client;
use App\Country;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\ShippingRate;
use App\Article;
use App\CategoryArticle;

class ClientController extends Controller
{
    //
    public function home(){
        $sliders = Slider::where('status', 1)->get();
        $produits = Product::where('status', 1)->get();
        $categories = Category::get();
        return view('client.home')->with('sliders', $sliders)
                                    ->with('produits', $produits)
                                    ->with('categories', $categories);
    }

    public function shop(){ 
        $produits = Product::where('status', 1)->get();
        $categories = Category::get();
        return view('client.shop')->with('produits', $produits)
                                    ->with('categories', $categories);
    }

    public function detail($id){

        $produit = Product::where('status', 1)->find($id);
        // Récupérer la catégorie du produit (en supposant que 'product_category' correspond au champ 'category_name' dans la table 'categories')
        $categoryName = $produit->product_category;

        // Récupérer les produits similaires qui ont la même catégorie, excluant le produit actuel
        $produitsSimilaires = Product::where('product_category', $categoryName)
                                    ->where('id', '!=', $id) // Exclure le produit actuel
                                    ->get();
        return view ('client.detail')->with('produit', $produit)
                                        ->with('produitsSimilaires', $produitsSimilaires);
        
    }


    public function select_par_cat($name){
        $categories = Category::get();
        // product_category_id = dans la base est égal à $name dans le paramettre
        $produits = Product::where('product_category', $name)->where('status', 1)->get();

        return view('client.shop')->with('produits', $produits)
                                    ->with('categories', $categories);
    }

    public function ajouter_au_panier($id){
        $produit = Product::find($id);

        // est ce qu'il y qlq chose dans le panier? si oui on prend, sinon c'est null

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        // on crée un nouveau objet de notre panier et on passe oldcart en parametre le panier qui est déjà existant
        $cart = new Cart($oldCart);
        //on prend l'objet et on me la methode add , on va dans le fichier cart.php
        $cart->add($produit, $id);
        // ici on a maintenant quelque chose dans le panier et on met dans session
        Session::put('cart', $cart);

        (Session::get('cart'));
        return redirect('/shop');
        
    }

    public function panier() {
        if (!Session::has('cart')) {
            return view('client.carte', [
                'products' => null,
                'shippingCost' => 0,
                'totalPriceWithShipping' => 0,
                'countries' => Country::all() // Récupérer les pays ici
            ]);
        }
    
        // Est-ce qu'il y a quelque chose dans le panier ? Si oui, get(), sinon mettre null
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // Créer une nouvelle instance de Cart avec l'ancien panier
        $cart = new Cart($oldCart);
    
        // Récupérer la liste des pays depuis la base de données
        $countries = Country::all();
    
        // Récupérer le pays sélectionné dans la session ou une valeur par défaut
        $countryId = Session::has('country_id') ? Session::get('country_id') : null;

        $shippingCost = 0;
        if ($countryId) {
            // Si un pays est sélectionné, on calcule les frais d'expédition
            $shippingCost = $this->calculateShippingCost($cart->totalWeight, $countryId);
        }
           // Stocker les frais d'expédition dans la session
        Session::put('shipping_cost', $shippingCost);
        // Ajouter les frais d'expédition au total du panier
        
        $totalPriceWithShipping = $cart->totalPrice + $shippingCost;
    
        return view('client.carte', [
            'countries' => $countries,
            'cart' => $cart,
            'products' => $cart->items,
            'shippingCost' => $shippingCost,
            'totalPriceWithShipping' => $totalPriceWithShipping
        ]);
    
    }
    


 
    public function updateCountry(Request $request)
    {
        // Valider que le champ 'country_id' a été soumis
        $request->validate([
            'country_id' => 'required|exists:countries,id',  // Vérifie que l'ID du pays existe
        ]);
    
        // Enregistrer l'ID du pays dans la session
        $countryId = $request->country_id;
        Session::put('country_id', $countryId);
    
        // Vérifier si le panier existe
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
    
        // Calculer les frais d'expédition en fonction du poids total et du pays sélectionné
        $shippingCost = $this->calculateShippingCost($cart->totalWeight, $countryId);
        // Sauvegarder le coût d'expédition dans la session
        Session::put('shipping_cost', $shippingCost);
    
        // Rediriger vers la page du panier avec un message de succès
        return redirect()->back()->with('status', 'Vous pouvez proceder au paiement maintenant.');
    }
    


  /*  public function updateCountry(Request $request) {
        $countryId = $request->input('country');
        Session::put('country', $countryId); // Mettre à jour le pays dans la session
        return redirect()->back();
    }
    */




    public function modifier_qty(Request $request, $id){

                // Valider la quantité
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        //print('the product id is '.$request->id.' And the product qty is '.$request->quantity);
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
    // Vérifiez si le produit est déjà dans le panier
        if ($cart->has($id)) {
            // Si oui, mettez à jour la quantité
            $cart->updateQty($id, $request->quantity);
        } else {
            // Sinon, ajoutez le produit avec la quantité spécifiée
            $product = Product::find($id); // Remplacez par votre modèle de produit
            $cart->add($product, $request->quantity);
        }
        Session::put('cart', $cart);
        // Récupérer le pays à partir de la session ou utiliser une valeur par défaut
        $country = Session::has('country_id') ? Session::get('country_id') : null;

        // Calculer les frais d'expédition en fonction du poids total et du pays
        $shippingCost = $this->calculateShippingCost($cart->totalWeight, $country);

        // Enregistrer les frais d'expédition dans la session pour l'afficher dans la vue panier
        Session::put('shippingCost', $shippingCost);

        //dd(Session::get('cart'));
        return redirect::to('/carte');
    }



    public function retirer_produit($id){

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
       
        if(count($cart->items) > 0){
            Session::put('cart', $cart);
        }
        else{
            Session::forget('cart');
        }

        //dd(Session::get('cart'));
        return redirect('/carte');
    }

  /*  public function checkout(){
        if(!Session::has('cart')){
            return view('client.carte');
        }
        return view ('client.checkout');

    }*/


    public function payer(Request $request)
    {
                    // Valider les champs requis
            $request->validate([
                'nom' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'pays' => 'required',  // Assurez-vous que le pays existe dans la table
            ]);
        // Vérifier s'il y a un panier dans la session
        if (!Session::has('cart')) {
        // Récupérer la liste des pays depuis la base de données
        $countries = Country::all();
        return view('client.carte', [
            'products' => null,
            'shippingCost' => 0,
            'totalPriceWithShipping' => 0,
            'countries' => $countries, // Ajout de la variable countries
        ]);
        }
        // recupérer l'ancien panier
    
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

            // Récupérer l'ID du pays de la session
        $countryId = Session::get('country_id', 0);

        // Récupérer le coût d'expédition depuis la session
        $shippingCost = Session::get('shipping_cost', 0);

        // récupérer total price sans frais d'expédition qui est déjà récupérer via session('cart)

        $totalPriceSimple = $cart->totalPrice;

        // Calculer le total avec les frais d'expédition
        $totalPriceWithShipping = $cart->totalPrice + $shippingCost;

        
        // Créer une nouvelle commande
        $order = new Order();
        $order->nom = $request->input('nom');
        $order->adresse = $request->input('adresse');
        $order->pays = $request->input('pays');
        $order->phone_number = $request->input('phone_number');    
        $order->total_price = $totalPriceWithShipping;
        $order->save();
    
        // Générer un payment_id automatiquement
        $uniqueId = uniqid('pay_');
        $order->payment_id = $uniqueId; // Exemple : PAY-00000001
        $order->save();
    
        // Enregistrer chaque produit dans la table 'order_items'
        foreach ($cart->items as $item) {
            $orderItem = new OrderArticle();
            $orderItem->product_name = $item['product_name'];
            $orderItem->quantity = $item['qty'];
            $orderItem->price = $item['product_price'];
            $orderItem->order_id = $order->id;
            $orderItem->save();
        }
        $order = Order::with('items')->find($order->id); // récupère la commande actuelle par son ID
        // calcul


        //return view('admin.commandes', compact('orders'));
        $email = Session::get('client')->email;
        Mail::to($email)->send(new SendMail($order,$totalPriceSimple, $shippingCost));

        // Vous pouvez aussi envoyer une copie à vous-même
        Mail::to('laila.bavy@gmail.com')->send(new SendMail($order,$totalPriceSimple, $shippingCost));
    
        // Vider le panier
        Session::forget('cart');
        Session::forget('country_id');

        
        // Récupérer la liste des pays
        $countries = Country::all();

        // Rediriger vers la page panier avec les pays dans la session
        return redirect('/carte')->with('countries', $countries)
                                    ->with('status', 'votre commande a été bien reçu, un ticket de paiement vous sera envoyé par email d\'ici peu, que vous pourriez régler par CB.');   
    }


    function getShippingCost($country, $totalWeight)
    {
        // Chercher le tarif qui correspond au pays et à la tranche de poids
        $shippingRate = ShippingRate::where('country', $country)
            ->where('min_weight', '<=', $totalWeight)
            ->where('max_weight', '>=', $totalWeight)
            ->first();
    
        // Si aucun tarif n'est trouvé, appliquer un tarif par défaut
        if (!$shippingRate) {
            $shippingRate = ShippingRate::where('country', 'Certain pays')->first();
        }
    
        return $shippingRate ? $shippingRate->rate : 0.00;
    }
    
    public function creer_compte(Request $request){
        $this->validate($request, ['email' => 'email|required|unique:clients',
                                    'password' => 'required|min:4']);
        $client = new Client();
        $client->email = $request->input('email');
        $client->password = bcrypt($request->input('password'));

        $client->save();

        return back()->with('status', 'Votre compte a été crée avec succès');
    }


    public function acceder_compte(Request $request){
        $this->validate($request, ['email' => 'email|required',
        'password' => 'required']);
        // on verifie s'il y a l'email venant de l'input dans la bdd colonne email
        $client = Client::where('email', $request->input('email'))->first();

        if($client){
            // on verifie si le password venant de l'input est egal à mdp dans la base, on utilise Hash pour decrypter

            if (Hash::check($request->input('password') , $client->password)) {

                Session::put('client', $client);
                return redirect('shop');

            } else {
                return back()->with('status', 'Email ou mdp incorrect');
            }
            

        }else{
            return back()->with('status', 'Vous n\'avez pas de compte'); 
        }

    }


    // calcul poids
/*    protected function calculateShippingCost($totalWeight, $countryId)
    {
        // Récupérer les tranches de poids pour le pays sélectionné
        $shippingRates = ShippingRate::where('country_id', $countryId)->get();
    
        // Chercher la tranche de poids correspondante au poids total
        foreach ($shippingRates as $rate) {
            if ($totalWeight >= $rate->weight_min && $totalWeight <= $rate->weight_max) {
                return $rate->price; // Retourner le prix correspondant à la tranche de poids
            }
        }
    
        // Si aucune tranche ne correspond, retourner un prix par défaut ou 0
        return 0;
    }*/

    public function calculateShippingCost($totalWeight, $countryId)
    {
        // Récupérer les tranches d'expédition du pays
        $shippingRates = ShippingRate::where('country_id', $countryId)->get();
    
        // Boucler sur les tranches pour trouver celle qui correspond au poids total
        foreach ($shippingRates as $rate) {
            if ($totalWeight >= $rate->weight_min && $totalWeight <= $rate->weight_max) {
                return $rate->price;
            }
        }
    
        // Si aucune tranche ne correspond, retourner 0 ou un prix par défaut
        return 0;
    }
    
         

    public function logout(){
        //supprimer la session
        Session::forget('client');
        return back();
    }

    public function client_login(){
        return view('client.login');
    }

    public function singup(){
        return view('client.singup');
    }


    public function paiement() {
        if (!Session::has('client')) {
            return view('client.login');
        }

        if (!Session::has('cart')) {
            $countries = Country::all();
            return view('client.carte', [
                'products' => null,
                'shippingCost' => 0,
                'totalPriceWithShipping' => 0,
                'countries' => $countries, // Passez les pays à la vue 'carte'
            ]);
        }

        // Est-ce qu'il y a qlq chose dans cart(panier) ? si oui get(), sinon mettez null
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // Prendre une nouvelle objet $cart qui vient de la classe Cart
        $cart = new Cart($oldCart);

        // Définir le pays de l'utilisateur (récupérer cette valeur de la session ou d'une autre source)
        $country = Session::has('country_id') ? Session::get('country_id') : 0;

        // Récupérer le coût d'expédition depuis la session
        $shippingCost = Session::get('shipping_cost', 0);

        // Ajouter les frais d'expédition au total du panier
        $totalPriceWithShipping = $cart->totalPrice + $shippingCost;

        // Récupérer la liste des pays depuis la base de données
        $countries = Country::all();

        // Réinitialiser le pays à 0 après le paiement
        Session::put('country_id', 0);

        return view('client.checkout', [
            'products' => $cart->items,
            'shippingCost' => $shippingCost,
            'totalPriceWithShipping' => $totalPriceWithShipping,
            'countries' => $countries, // Passez également les pays à la vue checkout
        ]);
    }

    public function post($id){

        $article = Article::find($id);
        $categories = CategoryArticle::all();
        $dernierArticles = Article::latest()->take(3)->get();
        

        return view('client.post')->with('article', $article)
                                    ->with('categories', $categories)
                                    ->with('dernierArticles', $dernierArticles);

    }

    public function blog(){
        $articles = Article::all();

        // Ajouter un extrait de contenu avec les 10 premiers mots pour chaque article
        foreach ($articles as $article) {
            $article->excerpt = self::getFirstWords($article->content, 10);
        }
       //dd($articles);
       
       $categories = CategoryArticle::all();
       $dernierArticles = Article::latest()->take(3)->get();
            return view('client.blog')->with('articles', $articles)
                                        ->with('categories', $categories)
                                        ->with('dernierArticles', $dernierArticles);

    }


    private static function getFirstWords($content, $wordCount = 10)
    {
        // Retirer les balises HTML et décoder les entités
        $cleanContent = strip_tags(html_entity_decode($content));
    
        // Séparer le contenu en mots
        $words = explode(' ', $cleanContent);
    
        // Prendre les 10 premiers mots
        $firstWords = array_slice($words, 0, $wordCount);
    
        // Retourner le résultat sous forme de chaîne de caractères
        return implode(' ', $firstWords) . '...';
    }

    

}
