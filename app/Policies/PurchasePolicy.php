<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;

class PurchasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }
    public function viewMy(User $user): bool
    {
        return $user->type == 'C';
    }
    public function view(User $user, Purchase $purchase): bool
    {
        return $user->type == 'A' || ($user->type == 'C' && $user->id === $purchase->customer->id);
    }
    public function generatePDF(?User $user): bool
    {
        return $user == null || $user?->type == 'C';
    }
    public function viewPDF(User $user): bool
    {
        return $user == null || $user->type == 'C' || $user->type == 'A';
    }
}
