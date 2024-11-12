<?php

namespace App;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function refreshToken(User $user, string $name = 'auth_token'): string;
    public function revokeCurrentToken(User $user): void;

}