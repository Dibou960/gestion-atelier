<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllLibellers()
    {
        $libellers = Category::pluck('libeller');

        return response()->json($libellers);
    }

    public function index(Request $request)
    {
        $elementsParPage = 5;

        $pageDemandee = $request->input('page', 1);

        $categories = Category::paginate($elementsParPage);

        $dernierePage = $categories->lastPage();

        if ($pageDemandee > $dernierePage) {

            return response()->json(['message' => 'Page introuvable'], 404);
        }

        $donnees = $categories->items();

        return response()->json($donnees);
    }

    public function store(Request $request)
    {
        $libelle = $request->input('libeller');

        $existeDeja = Category::withTrashed()

            ->where('libeller', $libelle)

            ->first();

        if ($existeDeja) {

            if ($existeDeja->trashed()) {

                $existeDeja->restore();

                return response()->json(['message' => "La catégorie '$libelle' a été restaurée."]);
            } else {
                return response()->json(['message' => "La catégorie '$libelle' existe déjà."], 422);
            }
        }
        $category = Category::create([

            'libeller' => $libelle,
        ]);
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $libelle = $request->input('libeller');

        $category = Category::find($id);

        if (!$category) {

            return response()->json(['message' => "La catégorie avec l'ID $id n'existe pas."], 404);
        }
        $validatedData = $request->validate([

            'libeller' => "required|unique:categories,libeller,{$id},id,deleted_at,NULL",
        ]);

        $category->update(['libeller' => $validatedData['libeller']]);

        return response()->json(['message' => "Catégorie mise à jour avec succès."]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $categoryName = $category->libeller;

        $category->delete();

        return response()->json(['message' => "Catégorie : $categoryName supprimée avec succès "]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('q');

        $categories = Category::where('libeller', 'LIKE', "%$searchTerm%")->get();

        return response()->json($categories);
    }

}
