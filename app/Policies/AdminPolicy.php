<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->type == 'A') {
            return true;
        }

        return null;
    }


    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }

    public function view(User $user): bool
    {
        return $user->type == 'A';
    }

    public function update(User $user): bool
    {
        return $user->type == 'A';
    }

    public function delete(User $user): bool
    {
        return $user->type == 'A';
    }

    public function configure(User $user): bool
    {
        return $user->type == 'A';
    }
}
