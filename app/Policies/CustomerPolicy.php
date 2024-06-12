<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->type == 'C' && $user->id == $customer->id;
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->type == 'C' && $user->id == $customer->id;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return false;
    }
}
