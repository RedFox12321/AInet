<?php

namespace App\Notifications;

use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchasePaid extends Notification implements ShouldQueue
{
    use Queueable;

    private $purchase;
    /**
     * Create a new notification instance.
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
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
        $url = url(route('purchases.show', ['purchase' => $this->purchase]));
        $path = storage_path('app/pdf_purchases/' . $this->purchase->receipt_pdf_filename);

        \Log::info("Sending pdf");
        return (new MailMessage)
            ->greeting('Good day!')
            ->line('Your purchase of tickets has been complete.')
            ->line('Attached to this email the respective purchase pdf')
            ->action('View purchase', url($url))
            ->line('Thank you for visiting CineMagic!')
            ->attach($path, [
                'as' => 'purchase_receipt.pdf',
                'mime' => 'application/pdf',
            ]);
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
