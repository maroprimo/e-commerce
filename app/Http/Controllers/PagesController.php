<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use Session;

class PagesController extends Controller
{
    public function apropos(){
        return view('pages.apropos');
    }

    public function services(){
        //notre model
        $produits = Product::orderBy('product_name', 'desc')->paginate(3) ; 
        // methode model de laravel
       /* $produits = DB::table('products')// ici DB c'est une class et table()methode
        // liste des methodes d'affichage sur le front
                //->orderBy('product_name', 'asc')
                ->inRandomOrder()
                ->paginate(1);
                //->get();*/

        return view('pages.services')->with('produits', $produits);
    }

    public function detail($id){
        //return view('pages.detail');
        //return 'Nom est '.$noms. ' ID est '.$id. ' Merci <br> retour à la page home';
       /* $produits = DB::table('products')
                    ->where('id', $id)
                    ->first();*/

        // va dans la bdd>>table Products et prend le produit qui a l'id dans le parametre
        //$produits = Product::where('id', $id)->first;
        $produits = Product::find($id);

        return view('pages.detail')->with('produit', $produits);
    }

    public function create(){
        return view('pages.create');
    }


    public function sauverproduit(Request $request){
        //print('Le nom de produit est '.$request->product_name);
        $this->validate($request, [
            'product_name'=> 'required',
            'product_price'=> 'required',
            'product_description'=> 'required',
            'product_image'=> 'image|nullable|max:1999'
            
        ]);

        $fileNameWithExt = $request->product_image->getClientOriginalName();

        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // pour voir le nom et l'extension
        $ext = $request->file('product_image')->getClientOriginalExtension();

        $fileNameToStore = $fileName.'_'.time().'.'.$ext;

        print('Le nom du fichier est '.$fileNameToStore. 'merci');

        $produit = New Product();

        $produit->product_name = $request->product_name;// autre facon: $request->input('product_name')
        $produit->product_price = $request->product_price;
        $produit->description = $request->product_description;
        // autre facon
       /* $data = array();
        $data['product_name'] = $request->input('product_name');
        .... etc
        DB::table('products')
            ->insert($data);*/

        $produit->save();

        Session::put('message', 'Le produit '.$request->product_name. ' a été insérer avec succès');

        return redirect('/create');

    }

    public function edit($id){
        // on va prendre un seul enregistrement par son id
        $produit = Product::find($id);
        return view('pages.edit')->with('produit', $produit);//ici on transporte les variable dans fichier edit

    }

    public function modifier(Request $request){ // c'est la réponse du formulaire
        
        $produit = Product::find($request->input('id'));

        $produit->product_name = $request->input('product_name');
        $produit->product_price = $request->input('product_price');
        $produit->description = $request->input('product_description');

        $produit->update();
        // redirection dans page services et on va dire a cette page d'afficher ce message
        return redirect('/services')->with('message', 'Le produit '.$request->product_name. ' a été modifier avec succès');
    }

    public function supprimer($id){
        $produit = Product::find($id);
        
        $produit->delete();
        return redirect('/services')->with('message', 'Le produit '.$produit->product_name. ' a été supprimer avec succès');
    }
}
