<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'libeller', 'prix', 'stock', 'reference', 'categorie_id', 'fournisseur_id', 'photo'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
}
