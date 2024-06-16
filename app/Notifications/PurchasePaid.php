<?php

namespace App\Notifications;

use App\Http\Controllers\TicketController;
use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class PurchasePaid extends Notification implements ShouldQueue
{
    use Queueable;

    private $purchase;
    private $tickets;
    /**
     * Create a new notification instance.
     */
    public function __construct(Purchase $purchase, Collection $tickets)
    {
        $this->purchase = $purchase;
        $this->tickets = $tickets;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('purchases.show', ['purchase' => $this->purchase]);
        $purchasePath = Storage::path('pdf_purchases/' . $this->purchase->receipt_pdf_filename);

        $ticketsPDF = TicketController::class::generatePDF($this->tickets);

        return (new MailMessage)
            ->greeting('Good day!')
            ->line('Your purchase of tickets has been complete.')
            ->line('Attached to this email is the respective purchase receipt as a pdf file')
            ->action('View purchase', url($url))
            ->line('Thank you for visiting CineMagic!')
            ->attach(
                $purchasePath,
                [
                    'as' => 'purchase_receipt.pdf',
                    'mime' => 'application/pdf',
                ]
            )
            ->attachData(
                $ticketsPDF,
                'purchased_tickets.pdf',
                ['mime' => 'application/pdf',]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
