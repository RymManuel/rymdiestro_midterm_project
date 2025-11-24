<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This allows us to use Category::create() with these fields
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all books in this category
     * Relationship: One category has many books
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}