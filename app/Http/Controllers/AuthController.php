<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User as UserModel;
use App\Services\UserService;
use App\Traits\HasApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HasApiResponse;

    /**
     * Creates a new instance
     */
    public function __construct(
        private UserService $userService
    ) {
        //
    }

    /**
     * Authenticates a user to the app
     */
    public function login(LoginUserRequest $request)
    {
        try
        {
            $credentials = $request->validated();

            /** @var UserModel */
            if ($userModel = $this->userService->getUserByCredentials($credentials))
            {
                $data = [
                    'user'  => UserResource::make($userModel),
                    'token' => $this->userService->createAccessToken($userModel)
                ];
                
                $response = [
                    'message' => 'User successfully logged in',
                    'data'    => $data
                ];
        
                return $this->respondOk($response);
            }
        }
        catch(\Throwable $t)
        {
            $response = [
                'message' => $t->getMessage()
            ];

            return $this->respondBadRequest($response);
        }
    }

    /**
     * Unauthenticates a user from the app for a given bearer token
     */
    public function logout(Request $request)
    {
        try
        {
            dd($request->bearerToken());

            $userModel = $request->user();
    
            $this->userService->revokeAccessTokens($userModel);
            
            $response = [
                'message' => 'You have been successfully logged out'
            ];
            
            return $this->respondOk($response);
        }
        catch(\Throwable $t)
        {
            $response = [
                'message' => $t->getMessage()
            ];

            return $this->respondUnAuthorized($response);
        }
    }
}
