<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'libeller' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|string',
            'stock' => 'required|integer|min:0',
            'fournisseur' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        $imagePath = $request->file('photo')->store('image','public'); 
    
        // Trouver l'ID de la catégorie à partir du libellé
        $categorie = Category::where('libeller', $validatedData['categorie'])->first();
    
        // Vérifier si la catégorie existe
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie introuvable'], 404);
        }
    
        // Trouver l'ID du fournisseur à partir du nom
        $fournisseur = Fournisseur::where('nom', $validatedData['fournisseur'])->first();
    
        // Vérifier si le fournisseur existe
        if (!$fournisseur) {
            return response()->json(['message' => 'Fournisseur introuvable'], 404);
        }
    
        // Associer les ID de la catégorie et du fournisseur à l'article
        $validatedData['categorie_id'] = $categorie->id;
        $validatedData['fournisseur_id'] = $fournisseur->id;
    
        // Génération de la référence
        $libellerInitials = strtoupper(substr($validatedData['libeller'], 0, 3));
        $categorieInitials = strtoupper(substr($categorie->libeller, 0, 3));
    
        $lastInsertedNumber = Article::where('categorie_id', $categorie->id)->count() + 1;
        $reference = 'REF-' . $libellerInitials . '-' . $categorieInitials . '-' . str_pad($lastInsertedNumber, 3, '0', STR_PAD_LEFT);
    
        $validatedData['reference'] = $reference;
        $validatedData['photo'] = $imagePath; 
    
        // Créer l'article avec les données, y compris le chemin de l'image
        $article = Article::create($validatedData);
    
        return response()->json($article, 201);
    }
    
        

    public function update(Request $request, $id)
    {
        // Recherche de l'article à mettre à jour
        $article = Article::find($id);
    
        // Vérifier si l'article existe
        if (!$article) {
            return response()->json(['message' => 'Article introuvable'], 404);
        }
    
        // Validation des données de la requête
        $validatedData = $request->validate([
            'libeller' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|string',
            'stock' => 'required|integer|min:0',
            'fournisseur' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Vous pouvez ajuster cette validation si nécessaire
        ]);
    
        // Mise à jour des champs modifiables
        $article->libeller = $validatedData['libeller'];
        $article->prix = $validatedData['prix'];
        $article->stock = $validatedData['stock'];
    
        // Trouver la catégorie associée
        $categorie = Category::where('libeller', $validatedData['categorie'])->first();
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie introuvable'], 404);
        }
        $article->categorie_id = $categorie->id;
    
        // Trouver le fournisseur associé
        $fournisseur = Fournisseur::where('nom', $validatedData['fournisseur'])->first();
        if (!$fournisseur) {
            return response()->json(['message' => 'Fournisseur introuvable'], 404);
        }
        $article->fournisseur_id = $fournisseur->id;
    
        // Mise à jour de la photo si une nouvelle photo est envoyée
        if ($request->hasFile('photo')) {
            $newImagePath = $request->file('photo')->store('image', 'public');
            $article->photo = $newImagePath;
        }
    
        // Enregistrement des modifications
        $article->save();
    
        return response()->json($article, 200);
    }
    
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
    public function index()
    {
        $perPage = 5;
    
        $articles = Article::select(
            'articles.*',
            'categories.libeller as categorie_libeller',
            'fournisseurs.nom as fournisseur_nom'
        )
            ->join('categories', 'articles.categorie_id', '=', 'categories.id')
            ->join('fournisseurs', 'articles.fournisseur_id', '=', 'fournisseurs.id')
            ->paginate($perPage);
    
        // Modifier les URL des images pour qu'elles soient absolues
        foreach ($articles as $article) {
            $imagePath = $article->photo; // Récupérer le chemin de l'image depuis la base de données
            $article->photo = asset('storage/' . $imagePath);
        }
    
        return response()->json($articles);
    }
    
    


    public function recherche(Request $request)
    {
        $termeRecherche = $request->input('terme_recherche', '');

        // Effectuer la recherche dans la base de données
        $fournisseurs = Fournisseur::where('nom', 'LIKE', "%$termeRecherche%")->get();

        return response()->json([
            'fournisseurs' => $fournisseurs,
            'termeRecherche' => $termeRecherche,
        ]);
    }

   
}
