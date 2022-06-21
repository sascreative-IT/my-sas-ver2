<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeactivateUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserIndexRequest;
use App\Jobs\SendWelcomeEmailToUser;
use App\Models\ErpUserDetail;
use App\Models\Factory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(UserIndexRequest $request)
    {
        $q = $request->get('q');

        $users = User::query()
            ->with(['roles', 'erpUserDetails.factory'])
            ->when($q, function ($query, $q) {
                return $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->paginate()
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
        try {
            $password = $this->generateRandomPassword();
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $password,
            ]);

            $user->assignRole($request->input('selected_roles'));
            $user->factories()->sync($request->input('selected_factories'));

            ErpUserDetail::create([
                'user_id' => $user->id,
                'contact_number' => $request->input('contact_number'),
                'factory_id' => $request->input('selected_factory_id'),
            ]);

            dispatch(new SendWelcomeEmailToUser($user, $password));
            return redirect()->route('users.index')
                ->with(['message' => 'user account created successfully.']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        return Inertia::render(
            'Users/UserUpdate',
            [
                'factories' => Factory::all()->toArray(),
                'roles' => \Spatie\Permission\Models\Role::select('name')->get(),
                'initUser' => $user->loadMissing(['roles', 'erpUserDetails.factory', 'factories'])->toArray()
            ],
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
            $user->erpUserDetails()->update([
                'factory_id' => $request->input('selected_factory_id'),
                'contact_number' => $request->input('contact_number'),
            ]);
            $user->syncRoles($request->input('selected_roles'));
            $user->factories()->sync($request->input('selected_factories'));
            return redirect()->route('users.index')
                ->with(['message' => 'user account created successfully.']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function resetPassword(ResetPasswordRequest $request, User $user)
    {
        try {
            $user->password = $request->input('password');
            $user->save();

            return Redirect::route('users.edit', [$user->id])
                ->with(['message' => 'password updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function deactivateUser(DeactivateUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::find($validated['user_id']);

        $user->erpUserDetails()->update([
            'deactivated_by' => auth()->user()->id,
            'deactivated_at' => now(),
        ]);

        return Redirect::route('users.edit', [$user->id])->with(['message' => 'user account deactivated']);
    }

    private function generateRandomPassword($passlength = 8): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $passlength; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
