<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    public function generateQRCode(): void
    {
        $qrCode = QrCode::format('png')->size(200)->generate(url(route('tickets.show', ['ticket' => $this])));
        $this->qrcode_url = "ticket-$this->id-qrcode.png";
        $filePath = "ticket_qrcodes/$this->qrcode_url";

        Storage::put($filePath, $qrCode);
    }
}
