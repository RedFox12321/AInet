<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
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

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
}
