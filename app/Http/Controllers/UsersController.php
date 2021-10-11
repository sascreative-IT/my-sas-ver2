<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ErpUserDetail;
use App\Models\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'erpUserDetails.factory'])
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Users/UsersIndex', ['users' => $users]);
    }

    public function create()
    {
        return Inertia::render('Users/UserAdd',
            [
                'factories' => Factory::all()->toArray(),
                'roles' => \Spatie\Permission\Models\Role::select('name')->get()
            ]
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $user->assignRole($request->input('selected_roles'));

        ErpUserDetail::create([
            'user_id' => $user->id,
            'contact_number' => $request->input('contact_number'),
            'factory_id' => $request->input('selected_factory_id'),
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render(
            'Users/UserUpdate',
            [
                'factories' => Factory::all()->toArray(),
                'roles' => \Spatie\Permission\Models\Role::select('name')->get(),
                'initUser' => $user->loadMissing(['roles', 'erpUserDetails.factory'])->toArray()
            ],
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        $user->erpUserDetails()->update([
            'factory_id' => $request->input('selected_factory_id'),
            'contact_number' => $request->input('contact_number'),
        ]);
        $user->syncRoles($request->input('selected_roles'));

        return redirect()->route('users.index');
    }

    public function resetPassword(ResetPasswordRequest $request, User $user)
    {
        $user->password = $request->input('password');
        $user->save();

        return Redirect::route('users.edit', [$user->id])->with(['message' => 'password updated']);
    }

    public function deactivateUser(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer'
        ]);

        $user = User::find($validated['user_id']);

        $user->erpUserDetails()->update([
            'deactivated_by' => auth()->user()->id,
            'deactivated_at' => now(),
        ]);

        return Redirect::route('users.edit', [$user->id])->with(['message' => 'user account deactivated']);
    }
}
