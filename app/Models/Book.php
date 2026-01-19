<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'photo',
    ];

    /**
     * Get the category this book belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the initials from the book title (for avatar fallback)
     */
    public function getInitials()
    {
        $words = explode(' ', $this->title);
        return strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    }

    /**
     * Get the path to the book's photo
     */
    public function getPhotoPath()
    {
        return $this->photo ? asset('storage/items/' . $this->photo) : null;
    }
}
