<?php

namespace App;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function refreshToken(User $user, string $name = 'auth_token'): string;
    public function revokeCurrentToken(User $user): void;
    public function newsFeed(User $user): Collection;

}
