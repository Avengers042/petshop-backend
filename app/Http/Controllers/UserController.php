<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function index() {
        return response()->json(new UserCollection(User::all()));
    }

    public function store(StoreUserRequest $request) {
        try {
            new UserResource(User::create($request->all()));
            return response('Usuário cadastrado com sucesso.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(User $user) {
        return response()->json(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, User $user) {
        if(!$user){
            return response('Usuário não cadastrado.');
        }

        try {
            new UserResource($user->update($request->all()));

            return response('Usuário atualizado.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(User $user) {
        if(!$user){
            return response('Usuário não cadastrado.');
        }

        try {
            $user->delete();

            return response('Usuário excluído.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
