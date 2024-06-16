<?php

namespace App\Policies;

use App\Http\Requests\TicketFormRequest;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type == 'A' || $user->type == 'E' ;
    }
    public function viewMy(User $user, Ticket $ticket): bool
    {
        return $user->type == 'C';
    }
    public function view(?User $user, Ticket $ticket): bool
    {
        return $user?->type == 'A' || $user?->type == 'E' || ($user?->type == 'C' && $user->id === $ticket->purchase->customer->id);
    }
    public function store(User $user, Ticket $ticket): bool
    {
        return $user->type == 'C';
    }
    public function generateQRCode(?User $user): bool
    {
        return $user == null || $user?->type == 'C';
    }
    public function viewQRCode(?User $user): bool
    {
        return $user->type == 'C' || $user->type == 'A';
    }

}
