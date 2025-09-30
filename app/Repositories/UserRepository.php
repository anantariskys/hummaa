<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByProvider(string $provider, string $providerId): ?User
    {
        return User::where('provider', $provider)
                   ->where('provider_id', $providerId)
                   ->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function markEmailAsVerified(User $user): User
    {
        return $this->update($user, [
            'email_verified_at' => Carbon::now()
        ]);
    }
}