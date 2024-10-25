<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Category;

class CategoryController extends Controller
{
    //
    public function ajoutercategorie(){

        return view('admin.ajoutercategorie');
    }


    public function sauvercategorie(Request $request){
        $this->validate($request, ['category_name'=> 'required|unique:categories',
                                    'category_image'=> 'required|image|mimes:JPG,jpg,jpeg,png,gif|max:1999']);
      
        if($request->hasFile('category_image')){
            // prend le nom du fichier avec extension
        $fileNameWithExt = $request->file('category_image')->getClientOriginalName();
            // prend juste le nom du fichier
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // juste prendre l'extention
        $extension = $request->file('category_image')->getClientOriginalExtension();
        // le nom que nous voulons sauvergarder dans la bdd
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;

        // uploader l'image
        $path = $request->file('category_image')->storeAs('public/product_images', $fileNameToStore);
        // on va prendre la vraie nom de l'image qui sera stocké dans ce dossier qui vient de créer
    }
    else{
        $fileNameToStore = 'noimage.jpg';
    }



        $categorie = New Category;//nouvelle instance, nouvelle objet

        $categorie->category_name = $request->input('category_name');
        $categorie->category_image = $fileNameToStore;

        $categorie->save();

        return redirect('ajoutercategorie')->with('status', 'la catégorie '.$categorie->category_name. ' a été ajoutée avec succès');

    }

    public function categories(){
        $categories = Category::get();

        return view('admin.categories')->with('categories', $categories); // transporter tous vers
    }

    public function edit_categorie($id){
        $categorie = Category::find($id);

        return view('admin.editcategorie')->with('categorie', $categorie); //transporter ver editcategories
    }

    public function modifiercategorie(Request $request){ // tous les demandes dans les formulaires sont stocké dans $request

        $this->validate($request, ['category_name'=> 'required',
                                    'category_image'=> 'required|image|mimes:JPG,jpg,jpeg,png,gif|max:1999']);


              // selection du produit  en fonction de l'id du produit
        $category = Category::find($request->input('id'));
        //lister avant sauvegarde dans la base de donnée
        $category->category_name = $request->input('category_name');

        // condition et préparation de l'image avant sauvegarde
   
        if($request->hasFile('category_image')){
            $fileNameWithExt = $request->file('category_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('category_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
   
            $path = $request->file('category_image')->storeAs('public/product_images', $fileNameToStore);

            // suppression de l'image déjà existant si ce dernier n'est pas noimage.jpg
            // noimage.jpg devrait être présent en permanant sur le dossier pour les produits qui n'ont pas d'image
            
            if($category->category_image != 'noimage.jpg'){

                Storage::delete('public/storage_images'.$category->category_image);
            
            }
            $category->category_image = $fileNameToStore;

        }
        
        $category->update();

        return redirect('/categories')->with('status', 'Le categorie a été modifié avec succès');

    }


    public function supprimercategorie($id){
        $categorie = Category::find($id);

        $categorie->delete();

        return redirect('/categories')->with('status', 'la catégories '.$categorie->categorie_name. ' a été supprimé. ');

    }
}
