<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

     protected $fillable = [
        "name", 'price', 'rating', 'description', 'category', 'countInStock', 'image', 'brand', 'user_id', 'numReviews'
    ];

    public function scopeFilter($query, $filters) {

        if($filters['brand'] ?? false) {
            return $query->where('brand', 'like', "%" .request()->query('brand'). "%");
        }

         if($filters['category'] ?? false) {
            return $query->where('category', 'like', "%" .request()->query('category'). "%");
        }
        
        if($filters['search'] ?? false) {
            return $query->where('title', 'like', "%" .request()->query('search'). "%")
            ->orWhere('description', 'like', "%" .request()->query('search'). "%")
            ->orWhere('brand', 'like', "%" .request()->query('search'). "%")
            ->orWhere('category', 'like', "%" .request()->query('search'). "%");
        }
    }
}
