<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;

class ScreeningPolicy
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
        return $user === null || $user->type == 'C';
    }
    public function view(?User $user): bool
    {
        return $user === null || $user->type == 'C';
    }
    public function store(User $user): bool
    {
        return false;
    }
    public function update(User $user): bool
    {
        return false;
    }
    public function delete(User $user): bool
    {
        return false;
    }
}
