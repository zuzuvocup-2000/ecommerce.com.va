<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthRepositoryInterface as AuthRepository;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\User;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService implements AuthServiceInterface
{
    public $authRepository;

    public function __construct(
        AuthRepository $authRepository,
    ){
        $this->authRepository = $authRepository;
    }

    public function register($request){

        DB::beginTransaction();
        try{
            $insert = $request->all();
            $auth = $this->authRepository->register($insert);
            DB::commit();
            return $auth;
        }catch(\Exception $e ){
            DB::rollBack();
            echo $e->getMessage();die();
            return false;
        }
    }
}
