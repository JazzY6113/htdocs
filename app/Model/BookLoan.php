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
        'book_id', 'reader_id', 'librarian_id',
        'loan_date', 'due_date', 'return_date', 'status'
    ];

    protected $dates = ['loan_date', 'due_date', 'return_date'];

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

    public function fines()
    {
        return $this->hasMany(Fine::class, 'loan_id');
    }

    public function isOverdue(): bool
    {
        if ($this->return_date) {
            return $this->return_date > $this->due_date;
        }
        return date('Y-m-d') > $this->due_date;
    }

    public function getOverdueDays(): int
    {
        if (!$this->isOverdue()) return 0;

        $endDate = $this->return_date ?: date('Y-m-d');
        return (new \DateTime($this->due_date))
            ->diff(new \DateTime($endDate))
            ->days;
    }

    public function calculateFine(): float
    {
        $overdueDays = $this->getOverdueDays();
        if ($overdueDays <= 0) return 0;

        $overdueMonths = ceil($overdueDays / 30);
        $fine = $this->book->price * 0.005 * $overdueMonths;

        return min($fine, $this->book->price);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('return_date');
    }

    public function scopeOverdue($query)
    {
        return $query->where(function($q) {
            $q->whereNull('return_date')
                ->where('due_date', '<', date('Y-m-d'));
        });
    }
}