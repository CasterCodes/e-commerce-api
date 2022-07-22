<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

     protected $fillable = [
        "name", 'price', 'rating', 'description', 'category', 'countInStock', 'image', 'brand', 'user_id', 'numReviews'
    ];

    public function reviews (): HasMany {
        return $this->hasMany(Review::class);
    }

    public function reviewed($id) {
        return $this->reviews->contains('user_id', auth()->id(), 'product_id', $id);
    }

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
