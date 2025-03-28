<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'publisher_id';
    protected $fillable = [
        'name',
        'country',
        'foundation_year'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }

    public function getBooksCount(): int
    {
        return $this->books()->count();
    }
}