<?php

namespace App\Repositories;

use App\Models\Article;
use App\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected function setModel()
    {
        $this->model = new User();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function refreshToken(User $user, string $name = 'auth_token'): string
    {
        return $user->createToken($name)->plainTextToken;
    }

    public function revokeCurrentToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function newsFeed(User $user): Collection
    {
        return $user->articles();
    }
}
