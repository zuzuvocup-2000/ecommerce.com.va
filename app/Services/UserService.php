<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Repositories\Interfaces\RoutesRepositoryInterface as RoutesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Routes;
use Illuminate\Support\Str;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{

    public $userRepository;
    public $routesRepository;

    public function __construct(
        UserRepository $userRepository,
        RoutesRepository $routesRepository,
    ){
        $this->routesRepository = $routesRepository;
        $this->userRepository = $userRepository;
    }

    public function getList($request){
        $perpage = $request->input('perpage') ?? 20;
        $user = $this->userRepository->paginateUser($perpage);
        return $user;
    }

    public function create($request){

        DB::beginTransaction();
        try{
            $insert = $request->all();
            $insert['canonical'] = Str::slug($insert['canonical'], '-');
            $user = $this->userRepository->create($insert);

            $routes_insert = [
                'module' => 'users',
                'object_id' => $user->id,
                'canonical' => $insert['canonical']
            ];
            $routes = $this->routesRepository->create($routes_insert);
            DB::commit();
            return $user;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try{
            $update = $request->except(['create']);
            $user = $this->userRepository->update($id, $update);
                
            $routes_update = [
                'canonical' => $update['canonical']
            ];
            $routes = $this->routesRepository->updateByObjectId($id, 'users', $routes_update);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function delete($id){
        DB::beginTransaction();
        try{
            $user = $this->userRepository->deleteById($id);
            $routes = $this->routesRepository->deleteByObjectId($id, 'users');

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
     }
}
