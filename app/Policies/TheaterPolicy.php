<?php

namespace App\Policies;

use App\Models\Theater;
use App\Models\User;

class TheaterPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type == 'A') {
            return true;
        }

        return null;
    }
    public function viewAny(User $user): bool
    {
        return false;
    }
    public function view(User $user, Theater $theater): bool
    {
        return false;
    }
    public function store(User $user): bool
    {
        return false;
    }
    public function update(User $user, Theater $theater): bool
    {
        return false;
    }

    public function delete(User $user, Theater $theater): bool
    {
        return false;
    }
}