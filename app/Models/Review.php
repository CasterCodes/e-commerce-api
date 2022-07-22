<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'product_id',
        "comment",
        "rating"
    ];


    public function reviewOwnedBy($userId) {
        return $this->user_id === $userId;
    }
}
