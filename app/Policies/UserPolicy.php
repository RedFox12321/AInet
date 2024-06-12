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
    public function viewPasswordOnly(User $user): bool
    {
        return ($user->type == 'E');
    }
    public function create(User $user): bool
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
}
