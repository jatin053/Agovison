<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAccountRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request, UserRepository $userRepository): View
    {
        return view('admin.users.index', [
            'filters' => $request->only(['search', 'role', 'status']),
            'roles' => ['Admin', 'Farmer', 'Buyer', 'Expert'],
            'users' => $userRepository->adminListing($request->all()),
        ]);
    }

    public function update(UserAccountRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $roles = $data['roles'] ?? [$user->primaryRole()];

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'],
            'is_blocked' => (bool) ($data['is_blocked'] ?? false),
            'blocked_at' => ($data['is_blocked'] ?? false) ? now() : null,
        ]);

        $user->syncRoles($roles);

        return back()->with('success', 'User account updated successfully.');
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot block your own account.');
        }

        $user->update([
            'is_blocked' => ! $user->is_blocked,
            'status' => $user->is_blocked ? 'active' : 'inactive',
            'blocked_at' => $user->is_blocked ? null : now(),
        ]);

        return back()->with('success', 'User status updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
