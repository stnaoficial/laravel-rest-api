<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User as UserModel;
use App\Services\UserService;
use App\Traits\HasApiResponse;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            /** @var Collection<UserModel> */
            if ($userModelCollection = $this->userService->getUsers())
            {
                $response = [
                    'message' => 'User found',
                    'data' => UserResource::collection($userModelCollection)
                ];
    
                return $this->respondOk($response);
            }
            else
            {
                $response = [
                    'message' => 'User not found'
                ];

                return $this->respondNotFound($response);
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
     * Search for an specified resource.
     */
    public function search(SearchUserRequest $request)
    {
        try
        {
            $data = $request->validated();

            /** @var UserModel */
            if ($userModel = $this->userService->searchUser($data))
            {
                $response = [
                    'message' => 'User found',
                    'data'    => UserResource::make($userModel)
                ];
        
                return $this->respondOk($response);
            }
            else
            {
                $response = [
                    'message' => 'User not found'
                ];

                return $this->respondNotFound($response);
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
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try
        {
            $data = $request->validated();

            /** @var UserModel */
            $userModel = $this->userService->createUser($data);

            $response = [
                'message' => 'User created successfully',
                'data'    => UserResource::make($userModel)
            ];

            return $this->respondCreated($response);
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try
        {
            /** @var UserModel */
            if ($userModel = $this->userService->getUserById($id))
            {
                $response = [
                    'message' => 'User found',
                    'data'    => UserResource::make($userModel)
                ];
    
                return $this->respondOk($response);
            }
            else
            {
                $response = [
                    'message' => 'User not found'
                ];

                return $this->respondNotFound($response);
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
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try
        {            
            if ($this->userService->userExistsById($id))
            {     
                $data = $request->validated();

                $this->userService->updateUserById($id, $data);
    
                /** @var UserModel */
                $userModel = $this->userService->getUserById($id);
    
                $response = [
                    'message' => 'User updated successfully',
                    'data'    => UserResource::make($userModel)
                ];
    
                return $this->respondOk($response);
            }
            else
            {
                $response = [
                    'message' => 'User not found'
                ];

                return $this->respondNotFound($response);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            if ($this->userService->userExistsById($id))
            {
                $this->userService->deleteUserById($id);

                $response = [
                    'message' => 'User removed successfully'
                ];

                return $this->respondNoContent($response);
            }
            else
            {
                $response = [
                    'message' => 'User not found'
                ];

                return $this->respondNotFound($response);
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
}
