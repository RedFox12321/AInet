<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
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
        return false;
    }
    public function viewShowcase(?User $user): bool
    {
        return true;
    }
    public function view(?User $user, Movie $movie): bool
    {
        return $user?->type == 'C';
    }
    public function store(User $user): bool
    {
        return false;
    }
    public function update(User $user, Movie $movie): bool
    {
        return false;
    }
    public function delete(User $user, Movie $movie): bool
    {
        return false;
    }
}
