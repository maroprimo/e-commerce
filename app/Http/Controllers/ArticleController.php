<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\CategoryArticle;
use Illuminate\Support\Facades\Storage;
class ArticleController extends Controller

{
    public function create(){

        $categories = CategoryArticle::all(); // Récupérer toutes les catégories

        return view('admin.createarticle', compact('categories'));

    }  
    
    

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|nullable|image|mimes:JPG,jpg,jpeg,png,gif|max:2048',
            'category_name' => 'required', // Validation pour la catégorie
        ]);

        // Gestion de l'image
        if($request->hasFile('image')){
            // prend le nom du fichier avec extension
        $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // prend juste le nom du fichier
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // juste prendre l'extention
        $extension = $request->file('image')->getClientOriginalExtension();
        // le nom que nous voulons sauvergarder dans la bdd
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;

        // uploader l'image
        $path = $request->file('image')->storeAs('public/product_images', $fileNameToStore);
        // on va prendre la vraie nom de l'image qui sera stocké dans ce dossier qui vient de créer
    }
    else{
        $fileNameToStore = 'noimage.jpg';
    }

        // ajouter article
        $article = new Article();
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->image = $fileNameToStore;
        $article->category_name = $request->input('category_name');
        $article->status = 1;

        $article->save();
        // Création de l'article
        /*Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $fileNameToStore,
            'category_name' => $request->input('category_name'), // Ajouter category_id ici
        ]);*/
    

        return redirect('admin/articles/create')->with('status', 'le produit '.$article->title. 'a été bien ajoutée');
    }


    public function modif(Request $request){
        // Validation des données
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|nullable|image|mimes:JPG,jpg,jpeg,png,gif|max:2048',
            'category_name' => 'required', // Validation pour la catégorie
        ]);

        // Gestion de l'image
        if($request->hasFile('image')){
            // prend le nom du fichier avec extension
        $fileNameWithExt = $request->file('image')->getClientOriginalName();
            // prend juste le nom du fichier
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        // juste prendre l'extention
        $extension = $request->file('image')->getClientOriginalExtension();
        // le nom que nous voulons sauvergarder dans la bdd
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;

        // uploader l'image
        $path = $request->file('image')->storeAs('public/product_images', $fileNameToStore);
        // on va prendre la vraie nom de l'image qui sera stocké dans ce dossier qui vient de créer
        }
        else{
        $fileNameToStore = 'noimage.jpg';
        }

        // ajouter article
        $article = Article::find($request->input('id')); // name id dans hidden
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->image = $fileNameToStore;
        $article->category_name = $request->input('category_name');
        //$article->status = 1;

        $article->update();
        // Création de l'article
        /*Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $fileNameToStore,
            'category_name' => $request->input('category_name'), // Ajouter category_id ici
        ]);*/


        return redirect('admin/articles/liste')->with('status', 'l\'article '.$article->title. 'a été bien modifiée');


    }


    public  function editarticle($id){
        $categories = CategoryArticle::all();
        $article = Article::find($id);

        return view('admin.editarticle', [
            'article' => $article,
            'categories' => $categories
        ]);

    }


    public function liste()
    {
        $articles = Article::all();

        // Ajouter un extrait de contenu avec les 10 premiers mots pour chaque article
        foreach ($articles as $article) {
            $article->excerpt = self::getFirstWords($article->content, 10);
        }
       //dd($articles);
            return view('admin.index')->with('articles', $articles);
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



        public function supprimer($id){
            $article = Article::find($id);
            if ($article->image != 'noimage.jpg'){
                Storage::delete('public/storage_images'.$article->image);

            }

            $article->delete();

            return redirect('/admin/articles/liste')->with('status', 'L\'article '.$article->title. 'a été supprimée');

        }
        
        
}
