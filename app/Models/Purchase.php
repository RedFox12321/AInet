<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Ticket;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'total_price',
        'customer_name',
        'customer_email',
        'nif',
        'payment_type',
        'payment_ref',
        'receipt_pdf_filename'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function generatePDF(): void
    {
        $this->receipt_pdf_filename = "purchase-details-$this->id.pdf";
        $filePath = "pdf_purchases/$this->receipt_pdf_filename";

        $pdf = Pdf::loadView('main.purchases.pdf', compact('purchase'));
        Storage::put($filePath, $pdf->output());
    }
}
