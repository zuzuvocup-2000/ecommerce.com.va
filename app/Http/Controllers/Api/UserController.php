<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\User;
use App\Services\Interfaces\UserServiceInterface;
use Validator;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService) {
        $this->userService = $userService;
    }

    public function list(Request $request)
    {
        $user = $this->userService->getList($request);
        return response()->json([
            'message' => 'User successfully changed password',
            'user' => $user,
        ], 201);
    }
}