<?php

namespace App\Policies;

use App\Models\Seat;
use App\Models\User;

class SeatPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type == 'A') {
            return true;
        }

        return null;
    }

    public function viewAny(?User $user): bool
    {
        return $user->type == 'C';
    }
    public function view(?User $user, Seat $seat): bool
    {
        return $user->type == 'C';
    }
    public function store(User $user): bool
    {
        return false;
    }
    public function update(User $user, Seat $seat): bool
    {
        return false;
    }
    public function delete(User $user, Seat $seat): bool
    {
        return false;
    }
}