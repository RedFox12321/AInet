<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'blocked',
        'photo_filename'
    ];

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

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/photos/{$this->photo_filename}");
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'id')->withTrashed();
    }

    public function getImageUrlAttribute()
    {
        if ($this->photo_url && Storage::exists("public/photos/{$this->photo_url}")) {
            return asset("storage/photos/{$this->photo_filename}");
        } else {
            return asset("storage/photos/anonymous.jpg");
        }
    }
}
