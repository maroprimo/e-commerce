<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoursEuro;

class CoursEuroController extends Controller
{
    //
    public function showForm()
    {
        // Récupérer le dernier taux de change
        $dernierTaux = CoursEuro::latest()->first();
        return view('admin.form', compact('dernierTaux'));
    }

    public function updateTaux(Request $request)
    {
        // Valider l'entrée
        $request->validate([
            'taux' => 'required|numeric',
        ]);

        // Supprimer le dernier taux
        $dernierTaux = CoursEuro::latest()->first();
        if ($dernierTaux) {
            $dernierTaux->delete();
        }
        

        // Insérer le nouveau taux
        CoursEuro::create([
            'taux' => $request->taux,
        ]);

        return redirect()->back()->with('success', 'Le taux a été mis à jour avec succès !');
    }
}
