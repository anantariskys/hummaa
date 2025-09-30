<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find user by provider and provider ID
     */
    public function findByProvider(string $provider, string $providerId): ?User;

    /**
     * Create new user
     */
    public function create(array $data): User;

    /**
     * Update user data
     */
    public function update(User $user, array $data): User;

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified(User $user): User;
}