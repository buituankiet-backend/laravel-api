<?php
namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function create($attributes = []) {
        dd($attributes);
        return DB::transaction(function () use ($attributes) {
            $created = User::query()->create([
                'name'  => data_get($attributes, 'name'),
                'email' => data_get($attributes, 'email'),
                'password' => Hash::make(data_get($attributes, 'password')),
            ]);

            throw_if(!$created, GeneralJsonException::class, 'Failed to create model.');

            return $created;
        });
    }

    public function update($id,array $attributes){
        return DB::transaction(function () use ($id, $attributes) {
            $user =  User::find($id);
            throw_if(!$user, GeneralJsonException::class, 'Not find user.');
            $update = $user->update([
                'name' => data_get($attributes, 'name', $user->name),
                'email' => data_get($attributes, 'email', $user->email),
            ]);
            throw_if(!$update, GeneralJsonException::class, 'Can not update user.');
            return $user;
        });
    }

    public function delete($id) {
        return DB::transaction(function () use ($id) {
            $user = User::find($id);
            throw_if(!$user, GeneralJsonException::class, 'Not find user.');
            $delete = $user -> forceDelete();
            throw_if(!$delete, GeneralJsonException::class, 'Can not delete user.');
            return $delete;
        });
    }

}