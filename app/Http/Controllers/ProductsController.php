<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Storage;
class ProductsController extends Controller
{
    //
    public function ajouterproduit(){

        $categories = Category::All()->pluck('category_name', 'category_name');

        return view('admin.ajouterproduit')->with('categories', $categories);
    }

    public function sauverproduit(Request $request){

        $this->validate($request, ['product_name'=>'required|unique:products',
                                    'product_price'=> 'required',
                                    'weight'=> 'required',
                                    'product_image'=> 'required|image|mimes:JPG,jpg,jpeg,png,gif|max:1999',
                                    'product_description'=> 'required|string',
                                    'product_category'=>'required']);

        if($request->hasFile('product_image')){
                // prend le nom du fichier avec extension
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
                // prend juste le nom du fichier
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // juste prendre l'extention
            $extension = $request->file('product_image')->getClientOriginalExtension();
            // le nom que nous voulons sauvergarder dans la bdd
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            // uploader l'image
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStore);
            // on va prendre la vraie nom de l'image qui sera stocké dans ce dossier qui vient de créer
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }

        $product = new Product();
       // $product = DB::table('produits')->where('product_name', 'produit')->count();

        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->weight = $request->input('weight');
        $product->product_description = $request->input('product_description');
        $product->product_category = $request->input('product_category');
        $product->product_image = $fileNameToStore;
        $product->status = 1;

        $product->save();

        return redirect('/ajouterproduit')->with('status', 'le produit '.$product->product_name. 'a été bien ajoutée');

    }

    public function produits(){
        $produits = Product::get();
        // transporter toutes ces infos vers la page admin.produit--s
        return view('admin.produits')->with('produits', $produits);
    }

    public function editproduit($id) {
        $categories = Category::All()->pluck('category_name', 'category_name');
        $produit = Product::find($id);
    
        return view('admin.editproduit', [
            'produit' => $produit,
            'categories' => $categories
        ]);
    }

    public function modifierproduit(Request $request){
        // configuration validation formulaire NB ,product_name,' . $id
        $this->validate($request, ['product_name'=>'required',
                                    'product_price'=> 'required',
                                    'weight'=> 'required',
                                    'product_image'=> 'image|nullable|max:1999',
                                    'product_description'=> 'required',
                                    'product_category'=>'required']);

        // selection du produit  en fonction de l'id du produit
        $product = Product::find($request->input('id'));
        //lister avant sauvegarde dans la base de donnée
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->weight = $request->input('weight');
        $product->product_description = $request->input('product_description');
        $product->product_category = $request->input('product_category');

        // condition et préparation de l'image avant sauvegarde
   
        if($request->hasFile('product_image')){
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('product_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
   
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStore);

            // suppression de l'image déjà existant si ce dernier n'est pas noimage.jpg
            // noimage.jpg devrait être présent en permanant sur le dossier pour les produits qui n'ont pas d'image
            
            if($product->product_image != 'noimage.jpg'){

                Storage::delete('public/storage_images'.$product->product_image);
            
            }
            $product->product_image = $fileNameToStore;

        }
        
        $product->update();


   
        return redirect('/produits')->with('status', 'Le produit a été modifié avec succès');
    }


    public function supprimerproduit($id){

        $product = Product::find($id);
        if($product->product_image != 'noimage.jpg'){

            Storage::delete('public/storage_images'.$product->product_image);
        
        }

        $product->delete();

        return redirect('/produits')->with('status', 'Le produit '.$product->product_name. 'a été supprimée');
    }

    public function activer_produit($id){
        $produit = Product::find($id);
        $produit->status = 1;
        
        $produit->update();

        return redirect('/produits')->with('status', 'Le produit '.$produit->product_name. 'a été activé');

    }

    public function desactiver_produit($id){
        $produit = Product::find($id);
        $produit->status = 0;

        $produit->update();

        return redirect('/produits')->with('status', 'Le produit '.$produit->product_name. 'a été désactiver');

    } 

    
}