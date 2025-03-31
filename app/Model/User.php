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
        'avatar'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);
        });
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function findIdentity(int $id)
    {
        return self::where('user_id', $id)->first();
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

    public function getFullName(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }

    public function isLibrarian(): bool
    {
        return $this->role === 'librarian';
    }

    public function getAvatarPath()
    {
        $avatarPath = "/public/avatars/{$this->avatar}";

        if ($this->avatar && file_exists($_SERVER['DOCUMENT_ROOT'] . $avatarPath)) {
            return $avatarPath;
        }
        return '/img/default-avatar.png';
    }
}