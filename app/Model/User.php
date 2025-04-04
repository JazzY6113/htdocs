<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'login',
        'password',
        'role',
        'is_active',
        'avatar',
        'api_token',
        'token_expires_at'
    ];

    protected $dates = ['token_expires_at'];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('user_id', $id)->first();
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLibrarian(): bool
    {
        return $this->role === 'librarian';
    }

    public function getFullName(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }
}