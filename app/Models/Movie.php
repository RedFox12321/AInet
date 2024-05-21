<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Screening;
use App\Models\Genre;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url'
    ];

    public function screenings(): HasMany
    {
        return $this->hasMany(Screening::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'code', 'genre_code');
    }
}
