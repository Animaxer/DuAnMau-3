<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients')->withPivot('quantity_required');
    }

    public function getMaxOrderableQuantityAttribute()
    {
        $ingredients = $this->ingredients;
        if ($ingredients->isEmpty()) {
            return 0; // Or return a large number if no ingredients mean infinite stock, but let's assume 0
        }

        $max = PHP_INT_MAX;
        foreach ($ingredients as $ingredient) {
            $required = $ingredient->pivot->quantity_required;
            if ($required > 0) {
                $possible = floor($ingredient->stock / $required);
                if ($possible < $max) {
                    $max = $possible;
                }
            }
        }
        return $max == PHP_INT_MAX ? 0 : $max;
    }
}
