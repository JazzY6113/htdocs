<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'title',
        'author_id',
        'publisher_id',
        'publication_year',
        'price',
        'total_copies',
        'available_copies',
        'is_new_edition',
        'summary'
    ];

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'book_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0);
    }

    public function scopeOverdue($query)
    {
        return $query->whereHas('loans', function($q) {
            $q->whereNull('return_date')
                ->where('due_date', '<', date('Y-m-d'));
        });
    }

    public function getAuthorFullName(): string
    {
        return $this->author ? $this->author->getFullName() : 'Неизвестен';
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount(['loans' => function($q) {
            $q->whereNotNull('return_date');
        }])
            ->orderBy('loans_count', 'desc')
            ->limit($limit);
    }

    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }
}