<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', [User::class]); // Authorize the current user
        return User::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create', [User::class]); // Authorize the current user

        $user = User::create($request->only(['name', 'email', 'password']));

        return response()->json([
            'success'   => true,
            'message'   => __('messages.users.created_successfully'),
            'user'      => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user); // Authorize the current user

        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update', $user); // Authorize the current user

        $user->update($request->only(['name', 'email', 'password']));

        return response()->json([
            'success'   => true,
            'message'   => __('messages.users.updated_successfully'),
            'user'      => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user); // Authorize the current user

        $user->delete();
        return response()->json([
            'success'   => true,
            'message'   => __('messages.users.deleted_successfully'),
        ]);
    }

    public function profile(Request $request)
    {
        return $request->user();
    }

    public function posts(User $user)
    {
        Gate::authorize('posts', $user); // Authorize the current user

        return $user->posts;
    }
}
