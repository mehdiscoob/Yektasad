<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface UserServiceInterface
{

    /**
     * Get users as pagination.
     *
     * @param array|null $data
     * @return Paginator
     */
    public function getUserPaginate(?array $data): Paginator;

    /**
     * Get a user by their ID.
     *
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User;

    /**
     * Get a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User;


    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Update a user's information.
     *
     * @param array $userData
     * @param int $userId
     * @return User|null
     */
    public function updateUser(array $userData, int $userId): ?User;


    /**
     * Create a user's information.
     *
     * @param array $userData
     * @return User|null
     */
    public function createUser(array $userData): ?User;


    /**
     * Register a new User.
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User;


    /**
     * Delete a user by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool;
}
