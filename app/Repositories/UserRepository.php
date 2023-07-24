<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User as UserModel;
use App\Traits\HasBaseRepository;

class UserRepository implements UserRepositoryInterface
{
    use HasBaseRepository;

    public function __construct(
        private UserModel $userModel
    ) {
        $this->setEntity($userModel);
    }

    public function findOneByEmail(string $email)
    {
        return $this->setIdentifier('email')->findOneByIdentifier($email);
    }
}