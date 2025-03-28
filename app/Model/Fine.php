<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'fine_id';
    protected $fillable = [
        'reader_id', 'loan_id', 'amount',
        'reason', 'status', 'issue_date', 'payment_date'
    ];

    public function reader()
    {
        return $this->belongsTo(Reader::class, 'reader_id');
    }

    public function loan()
    {
        return $this->belongsTo(BookLoan::class, 'loan_id');
    }
}