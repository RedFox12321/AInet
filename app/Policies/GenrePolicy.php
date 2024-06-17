<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;

class GenrePolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user->type == 'A') {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Genre $genre): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Genre $genre): bool
    {
        return false;
    }

    public function delete(User $user, Genre $genre): bool
    {
        return false;
    }
}
