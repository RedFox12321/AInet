<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Screening;
use App\Models\Purchase;
use App\Models\Seat;

class Ticket extends Model
{
    use HasFactory;


    protected $fillable = [
        'screening_id',
        'seat_id',
        'purchase_id',
        'price',
        'qrcode_url',
        'status'
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class)->withTrashed();
    }
}