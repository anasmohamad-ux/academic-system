<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Services\TokenService;
use Illuminate\Support\Facades\Hash;

class LoginUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TokenService $tokenService
    ) {
    }

    public function execute(
        string $email,
        string $password
    ): ?array {

        $model = $this->userRepository->findModelByEmail($email);

        if (!$model) {
            return null;
        }

        if (!Hash::check($password, $model->password)) {
            return null;
        }

        $token = $this->tokenService->generate($model);

        $domainUser = $this->userRepository->findByEmail($email);

        return [
            'user' => $domainUser,
            'token' => $token
        ];
    }
}
