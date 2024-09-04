<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Get users as pagination.
     *
     * @param array|null $data
     * @return Paginator
     */
    public function getUserPaginate(?array $data): Paginator
    {
        if (!isset($data['perPage'])){$data['perPage']=20;}
        return $this->userRepository->getUserPaginate($data);
    }

    /**
     * Get a user by their ID.
     *
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }

    /**
     * Get a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Update a user's information.
     *
     * @param array $userData
     * @param int $userId
     * @return User|null
     */
    public function updateUser(array $userData, int $userId): ?User
    {
        return $this->userRepository->update($userData, $userId);
    }

    /**
     * Create a user's information.
     *
     * @param array $userData
     * @return User|null
     * @throws Exception
     */
    public function createUser(array $userData): ?User
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($userData);
            DB::commit();
            return $user;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    /**
     * Register a new User.
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User
    {
        $userData['password']=Hash::make($userData['password']);
        return $this->userRepository->create($userData);
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }
}
