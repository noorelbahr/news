<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * AuthController constructor.
     * - - -
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->create(
            $request->name,
            $request->email,
            bcrypt($request->password),
            $request->gender
        );

        $token = $user->createToken('News App')->accessToken;

        return $this->success('Account created successfully.', 201, [
            'access_token' => $token
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->fail('Invalid email or password.');
        }

        $token = $user->createToken('News App')->accessToken;

        return $this->success('Login successful.', 200, [
            'access_token' => $token
        ]);
    }
}
