<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name'
    ];

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'code'; // or null

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
