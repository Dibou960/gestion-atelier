<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FournisseurController extends Controller
{
    public function ChargerSelectFournisseur()
    {
        $fournisseurs = Fournisseur::all(); // Supposons que vous ayez un modèle Fournisseur
    
        return response()->json($fournisseurs);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        if (empty($searchTerm)) {
            return response()->json(['error' => 'Le terme de recherche ne peut pas être vide.'], 400); // Code 400 pour Bad Request
        }

        $fournisseurs = Fournisseur::where('nom', 'LIKE', "%$searchTerm%")->get();

        if ($fournisseurs->isEmpty()) {
            return response()->json(['message' => 'Aucun fournisseur trouvé pour le terme de recherche donné.'], 404); // Code 404 pour Not Found
        }

        return response()->json($fournisseurs);
    }
}
