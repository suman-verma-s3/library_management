<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'isbn',
        'publisher',
        'publication_year',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 👇 NEW
   public function copies()
{
    return $this->hasMany(BookCopy::class);
}

    public function availableCopies()
    {
        return $this->hasMany(BookCopy::class)->where('status', 'available');
    }
}