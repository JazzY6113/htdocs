<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'loan_id';
    protected $fillable = [
        'book_id',
        'reader_id',
        'librarian_id',
        'loan_date',
        'due_date',
        'return_date',
        'status'
    ];

    protected $dates = ['loan_date', 'due_date', 'return_date'];

    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'loaned')
                ->orWhere('status', 'overdue');
        })->whereNull('return_date');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
            ->orWhere(function($q) {
                $q->whereNull('return_date')
                    ->where('due_date', '<', date('Y-m-d'));
            });
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function reader()
    {
        return $this->belongsTo(Reader::class, 'reader_id');
    }

    public function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }

    public function scopeForReader($query, $readerId)
    {
        return $query->where('reader_id', $readerId);
    }

    public function scopeForBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    public function isOverdue(): bool
    {
        return $this->return_date === null &&
            $this->due_date < date('Y-m-d');
    }

    public function calculateFine(): float
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $daysOverdue = now()->diffInDays($this->due_date);
        return min($daysOverdue * 10, 500); // Макс 500 руб. штрафа
    }
}