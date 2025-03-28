<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'reader_id';
    protected $fillable = [
        'library_card_number',
        'name',
        'surname',
        'patronymic',
        'address',
        'phone',
        'registration_date',
        'status',
        'user_id'
    ];

    protected $attributes = [
        'status' => 'active',
        'registration_date' => null
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reader) {
            if (empty($reader->library_card_number)) {
                throw new \RuntimeException('Номер читательского билета не может быть пустым');
            }

            if (empty($reader->registration_date)) {
                $reader->registration_date = date('Y-m-d');
            }
        });
    }

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'reader_id');
    }

    public function activeLoans()
    {
        return $this->loans()->active();
    }

    public function overdueLoans()
    {
        return $this->loans()->overdue();
    }

    public function getFullName(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getActiveLoansCount(): int
    {
        return $this->activeLoans()->count();
    }
}