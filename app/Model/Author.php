<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'author_id';
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'birth_year',
        'country'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function getFullName(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }

    public static function createFromFullName(string $fullName): Author
    {
        $names = preg_split('/\s+/', trim($fullName));
        return self::create([
            'surname' => $names[0] ?? 'Неизвестен',
            'name' => $names[1] ?? 'Автор',
            'patronymic' => $names[2] ?? null,
            'country' => 'Не указана',
            'birth_year' => null
        ]);
    }

    public function getBooksCount(): int
    {
        return $this->books()->count();
    }
}