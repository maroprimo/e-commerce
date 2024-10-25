<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\ShippingRate;

class ShippingController extends Controller
{
    public function create()
    {
        $countries = Country::all();
        return view('admin.shipping.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'weight_min' => 'required|numeric',
            'weight_max' => 'required|numeric|gt:weight_min',
            'price' => 'required|numeric',
        ]);

        ShippingRate::create($request->all());

        return redirect()->back()->with('status', 'Tarif d\'expédition ajouté avec succès.');
    }



        public function index()
    {
        $shippingRates = ShippingRate::with('country')->get();
        return view('admin.shipping.index', compact('shippingRates'));
    }



    public function ajouterpays(){
        return view('admin.shipping.createpays');
    }


    public function sauvepays(Request $request){
        $this->validate($request, ['name' => 'required|unique:countries']);

        $country = New Country;

        $country->name = $request->input('name');

        $country->save();

        return redirect('admin/shipping/createpays')->with('status', 'le pays '.$country->name. ' a été ajoutée avec succès');

    }

}
