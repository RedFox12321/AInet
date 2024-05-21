<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theater;
use App\Models\Ticket;

class Seat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'theater_id',
        'row',
        'seat_number'
    ];

    public $timestamps = false;

    public function theater(): BelongsTo
    {
        return $this->belongsTo(Theater::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
