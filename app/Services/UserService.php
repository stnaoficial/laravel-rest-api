<?php

namespace App\Services;

use App\Exceptions\InvalidUserCredentialsException;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
        //
    }

    public function searchUser(array $data)
    {
        return $this->userRepository->searchOne($data);
    }

    public function getUsers()
    {
        return $this->userRepository->all();
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }

    public function userExistsById(int $id)
    {
        return $this->userRepository->existsById($id);
    }

    public function getUserById(mixed $id)
    {
        return $this->userRepository->findOneById($id);
    }

    public function updateUserById(mixed $id, array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->updateById($id, $data);
    }

    public function deleteUserById(mixed $id)
    {
        return $this->userRepository->deleteById($id);
    }

    public function getUserByCredentials(array $credentials)
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        /** @var UserModel */
        $userModel = $this->userRepository->findOneByEmail($email);

        if (!$userModel || !Hash::check($password, $userModel->password))
        {
            throw new InvalidUserCredentialsException('Invalid user credentials');
        }
        
        return $userModel;
    }

    public function createAccessToken(UserModel $userModel)
    {
        return $userModel->createToken('ABC')->accessToken;
    }

    public function getAccessToken(UserModel $userModel)
    {
        return $userModel->token();
    }

    public function revokeAccessTokens(UserModel $userModel)
    {
        $tokens = $userModel->tokens;

        foreach($tokens as $token)
        {
            $token->revoke();
        }

        return $tokens;
    }

    public function revokeAccessToken(UserModel $userModel)
    {
        $token = $this->getAccessToken($userModel);

        return $token->revoke();
    }
}