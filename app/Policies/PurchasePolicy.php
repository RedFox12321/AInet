<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;

class PurchasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type == 'A' || $user->type == 'C';
    }
    public function view(User $user, Purchase $purchase): bool
    {
        return $user->type == 'A' || ($user->type == 'C' && $user->id === $purchase->customer->user->id);
    }
    public function store(?User $user): bool
    {
        return $user->type == 'C';
    }
}
