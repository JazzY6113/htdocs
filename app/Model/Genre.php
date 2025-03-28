<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'genre_id';
    protected $fillable = ['name'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_genres', 'genre_id', 'book_id');
    }
}