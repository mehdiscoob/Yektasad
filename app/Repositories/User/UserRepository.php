<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class UserRepository implements UserRepositoryInterface
{
    /**
     * The User model instance.
     *
     * @var User
     */
    protected $userModel;

    /**
     * UserRepository constructor.
     *
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Get users as pagination.
     *
     * @param array|null $data
     * @return Paginator
     */
    public function getUserPaginate(?array $data): Paginator
    {
        $users = $this->userModel->query();

        if (isset($data["keyword"])) {
            $users->where(function ($q) use ($data) {
                $q->where("id", $data['keyword'])
                    ->orWhere("name", "like", "%" . $data['keyword'] . "%")
                    ->orWhere("email", "like", "%" . $data['keyword'] . "%")
                    ->orWhere("mobile", "like", "%" . $data['keyword'] . "%");
            });
        }

        if (isset($data["orderBy"])) {
            $users->orderBy($data["orderByColumn"], $data["orderBy"]);
        }

        return $users->paginate($data['perPage']);
    }


    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->userModel->create($data);
    }

    /**
     * Find a user by their email address.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->userModel->where('email', $email)->first();
    }

    /**
     * Update a user's information.
     *
     * @param array $data
     * @param int $userId
     * @return User|null
     */
    public function update(array $data, int $userId): ?User
    {
        $user = $this->findById($userId);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return null;
    }

    /**
     * Find a user by their ID.
     *
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User
    {
        return $this->userModel->find($userId);
    }

    /**
     * Delete a user by their ID.
     *
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool
    {
        $user = $this->findById($userId);

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }
}
