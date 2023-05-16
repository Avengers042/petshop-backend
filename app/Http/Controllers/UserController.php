<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

class UserController extends Controller
{
    public function index() {
        return response()->json(new UserCollection(User::all()));
    }

    public function store(StoreUserRequest $request) {
        return new UserResource(User::create($request->all()));
    }

    public function show(User $user) {
        return response()->json(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, User $user) {
        return $user->update($request->all());
    }

    public function destroy(User $user) {
        return $user->delete();
    }
}
