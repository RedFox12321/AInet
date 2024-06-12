<?php

namespace App\Policies;

use App\Http\Requests\TicketFormRequest;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user, Ticket $ticket): bool
    {
        return $user->type == 'E';
    }
    public function viewMine(User $user, Ticket $ticket): bool
    {
        return $user->type == 'E' || ($user->type == 'C' && $user->id === $ticket->purchase->customer->id);
    }
    public function view(?User $user, Ticket $ticket): bool
    {
        return $user->type == 'E' || ($user?->type == 'C' && $user->id === $ticket->purchase->customer->id);
    }
    public function store(User $user, Ticket $ticket): bool
    {
        return $user->type == 'C';
    }
}
