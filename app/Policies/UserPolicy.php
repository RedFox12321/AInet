<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }
    public function view(User $user): bool
    {
        return $user->type == 'A';
    }
    public function create(User $user): bool
    {
        return $user->type == 'A';
    }
    public function update(User $user): bool
    {
        return $user->type == 'A' || $user->type == 'C';
    }
    public function delete(User $user): bool
    {
        return $user->type == 'A';
    }
}
