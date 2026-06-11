<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'name',
        'email',
        'password',
        'username',
        'phone',
        'bio',
        'avatar',
        'birth_date',
        'gender',
        'role',
        'seller_name',
        'seller_description',
        'seller_phone',
        'seller_address',
        'seller_banner',
        'seller_revenue',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute($value)
    {
        return $this->attributes['nama'] ?? $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nama'] = $value;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function isSeller(): bool
    {
        return in_array(strtolower((string) $this->role), ['penjual', 'seller', 'seller_store'], true);
    }
}
