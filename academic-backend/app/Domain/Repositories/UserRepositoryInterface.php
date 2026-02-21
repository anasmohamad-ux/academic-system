<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    // Auth-related
    public function create(
        string $name,
        string $email,
        string $password,
        string $role
    ): User;

    public function findByEmail(string $email): ?User;

    public function findModelByEmail(string $email): mixed;

    // Admin-related
    public function findAll(): array;

    public function findById(int $id): ?User;

    public function update(
        int $id,
        string $name,
        string $email,
        string $role
    ): User;

    public function delete(int $id): void;
}