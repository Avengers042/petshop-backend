<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return new UserCollection(User::all());
    }

    public function store(StoreUserRequest $request) {
        return new UserResource(User::create($request->all()));
    }

    public function show(User $user) {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user) {
        return $user->update($request->all());
    }

    public function destroy(User $user) {
        return $user->delete();
    }
}
