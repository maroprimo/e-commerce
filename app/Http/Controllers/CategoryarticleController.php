<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryarticleController extends Controller
{
    //
    public function ajoutercategorie(){

        return view('admin.ajoutcatblog');
    }


    public function sauvercategorie(Request $request){
        $this->validate($request, ['name'=> 'required|unique:categories']);
      
     
        $categorie = New CategoryArticle;//nouvelle instance, nouvelle objet

        $categorie->name = $request->input('name');

        $categorie->save();

        return redirect('ajoutcatblog')->with('status', 'la catégorie '.$categorie->name. ' a été ajoutée avec succès');

    }

    public function categories(){
        $categories = CategoryArticle::get();

        return view('admin.listecategoriesblog')->with('categories', $categories); // transporter tous vers
    }

    

    public function edit_categorie($id){
        $categorie = CategoryArticle::find($id);

        return view('admin.editcategorieblog')->with('categorie', $categorie); //transporter ver editcategories
    }

    public function modifiercategorie(Request $request){ // tous les demandes dans les formulaires sont stocké dans $request

        $this->validate($request, ['category_name'=> 'required']);


              // selection du produit  en fonction de l'id du produit
        $category = CategoryArticle::find($request->input('id'));
        //lister avant sauvegarde dans la base de donnée
        $category->name = $request->input('name');

        
        $category->update();

        return redirect('/listecategoriesblog')->with('status', 'Le categorie a été modifié avec succès');

    }


    public function supprimercategorie($id){
        $categorie = CategoryArticle::find($id);

        $categorie->delete();

        return redirect('/listecategoriesblog')->with('status', 'la catégories '.$categorie->name. ' a été supprimé. ');

    }
    
}
