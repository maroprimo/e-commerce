<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    //
    public function ajouterslider(){

        return view('admin.ajouterslider');
    }

    public function sauverslider(Request $request){
        // condition formulaire
        $this->validate($request, ['description1'=>'required',
                                    'description2'=>'required',
                                    'slider_image'=>'image|nullable|max:1999']);

        // il faut instancier le nouveau slider, à chaque enregistrement il faut faire linstanciation
        if($request->hasFile('slider_image')){

            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('slider_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('slider_image')->storeAs('public/slider_images', $fileNameToStore);
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }
        $slider = new Slider();

        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->slider_image = $fileNameToStore;
        $slider->status = 1;


        $slider->save();

        return redirect('/ajouterslider')->with('status', 'le slider '.$slider->descrition_one. 'a été bien ajoutée');

    }

    public function sliders(){

        $sliders = Slider::All();

        return view('admin.sliders')->with('sliders', $sliders);
    }


    public function editerslider($id){
        $slider = Slider::find($id);
        return view('admin.editerslider')->with('slider', $slider);
    }

    public function modifierslider(Request $request){       
    // configuration validation formulaire NB ,product_name,' . $id
        
    $this->validate($request, ['description1'=>'required',
                                'description2'=>'required',
                                'slider_image'=>'image|nullable|max:1999']);

        // selection du slider  en fonction de l'id du produit
        $slider = Slider::find($request->input('id'));
        //lister avant sauvegarde dans la base de donnée
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');

        // condition et préparation de l'image avant sauvegarde
   
        if($request->hasFile('slider_image')){
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('slider_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
   
            $path = $request->file('slider_image')->storeAs('public/slider_images', $fileNameToStore);

            // suppression de l'image déjà existant si ce dernier n'est pas noimage.jpg
            // noimage.jpg devrait être présent en permanant sur le dossier pour les produits qui n'ont pas d'image
            
            if($slider->slider_image != 'noimage.jpg'){

                Storage::delete('public/slider_images'.$slider->slider_image);
            
            }
            $slider->slider_image = $fileNameToStore;

        }
        
        $slider->update();


   
        return redirect('/sliders')->with('status', 'Le slider a été modifié avec succès');
    }

    public function supprimerslider($id){
        $slider = Slider::find($id);
        if($slider->slider_image != 'noindex.jpg'){

            Storage::delete('public/slider_images'.$slider->slider_image); 
        }
        $slider->delete();

        return redirect('/sliders')->with('status', 'le slider a été supprimé avec succès');
    }

    public function activerslider($id){// id qui vient de l'url
        $slider = Slider::find($id);

        $slider->status = 1;

        $slider->update();

        return redirect('/sliders')->with('status', 'le slider a été activé avec succès');
    }

    public function desactiverslider($id){
        $slider = Slider::find($id);

        $slider->status = 0;

        $slider->update();

        return redirect('/sliders')->with('status', 'le slider a été desactivé avec succès');
    }
}
