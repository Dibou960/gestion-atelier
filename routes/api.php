<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FournisseurController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/categories', [CategoryController::class, 'store']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/categories/search', [CategoryController::class, 'search']);

Route::get('articles/{id}', [ArticleController::class, 'index']);

Route::get('/fournisseurs', [FournisseurController::class, 'search']);

Route::get('/articles', [ArticleController::class, 'index']);

Route::get('/fournisseurs', [FournisseurController::class, 'ChargerSelectFournisseur']);


Route::get('/all-libellers', [CategoryController::class, 'getAllLibellers']);


Route::post('/articles', [ArticleController::class, 'store']);

Route::put('/articles/{article}', [ArticleController::class, 'update']);

Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

Route::get('/fournisseur/search', [FournisseurController::class, 'search'])->name('fournisseur.search');

Route::post('/inserer-image', [ArticleController::class, 'insererImage'])->name('inserer.image');

Route::post('upload-image', 'ArticleController@uploadAndSaveImage');

Route::post('/upload-image', [ArticleController::class, 'uploadAndSaveImage']);
