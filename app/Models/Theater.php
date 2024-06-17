<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Screening;
use App\Models\Seat;

class Theater extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'photo_filename'
    ];

    public $timestamps = false;

    public function getImageExistsAttribute()
    {
        return Storage::fileExists("public/theater/{$this->photo_filename}");
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class)->withTrashed();
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/theater/{$this->photo_filename}")) {
            return asset("storage/theater/{$this->photo_filename}");
        } else {
            return asset("storage/theater/no_theater.jpg");
        }
    }

}
