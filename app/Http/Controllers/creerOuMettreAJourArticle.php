<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class creerOuMettreAJourArticle extends Controller
{
    private function creerOuMettreAJourArticle(Request $request, Article $article = null)
    {
        // Validation des données de la requête
        $validatedData = $request->validate([
            'libeller' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'categorie' => 'required|string',
            'stock' => 'required|integer|min:0',
            'fournisseur' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Autres étapes communes ici...

        // Mise à jour des champs modifiables
        if ($article === null) {
            $article = new Article();
        }

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

        return $article;
    }

    public function update(Request $request, $id)
    {
        // Recherche de l'article à mettre à jour
        $article = Article::find($id);

        // Vérifier si l'article existe
        if (!$article) {
            return response()->json(['message' => 'Article introuvable'], 404);
        }

        // Appel de la méthode pour créer ou mettre à jour un article
        $article = $this->creerOuMettreAJourArticle($request, $article);

        return response()->json($article, 200);
    }

}
