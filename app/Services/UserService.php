<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register(array $data): User
    {
        return $this->repository->create($data);
    }

    public function revokeUserToken(User $user): array
    {
        $this->repository->revokeCurrentToken($user);

        return [
            'message' => 'User logged out successfully'
        ];
    }

    public function refreshUserToken(User $user): array
    {
        $this->repository->revokeCurrentToken($user);

        return [
            'access_token' => $this->repository->refreshToken($user),
            'token_type' => 'Bearer'
        ];
    }

    public function newsFeed(User $user): Collection
    {
        return $this->repository->newsFeed($user);
    }

    public function forgotPassword(string $email): array
    {
        $user = $this->repository->findByEmail($email);

        $user->sendPasswordResetNotification($user->createToken('password_reset')->plainTextToken);

        return [
            'message' => 'We have emailed your password reset link!'
        ];
    }
}
