<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{


    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new JsonResponse(User::query()->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        dd($request -> email);
        $created = $this->userRepository->create([
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name
        ]);
        return new JsonResponse([
            'data' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return new JsonResponse([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $update = $this->userRepository->update($id, $request->only([
            'email',
            'title'
        ]));

        return new JsonResponse(
           [ 'data' => $update]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = $this->userRepository->delete($id);
        return new JsonResponse([
            'data' => $delete
        ]);
    }
}