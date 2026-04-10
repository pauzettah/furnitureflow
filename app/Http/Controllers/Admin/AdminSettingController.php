<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        // Get system statistics for settings dashboard
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalCarpenters = User::where('role', 'carpenter')->count();
        $totalDelivery = User::where('role', 'delivery')->count();

        return view('admin.settings.index', compact(
            'userInitials',
            'userRole',
            'currentDate',
            'totalUsers',
            'totalAdmins',
            'totalCustomers',
            'totalCarpenters',
            'totalDelivery'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.settings.profile', compact('user', 'userInitials', 'userRole', 'currentDate'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.settings.profile')->with('success', 'Profile updated successfully!');
    }

    public function security()
    {
        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.settings.security', compact('user', 'userInitials', 'userRole', 'currentDate'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.settings.security')->with('success', 'Password changed successfully!');
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        $userInitials = strtoupper(substr(auth()->user()->name, 0, 2));
        $userRole = ucfirst(auth()->user()->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.settings.users', compact('users', 'userInitials', 'userRole', 'currentDate'));
    }

    public function createUser()
    {
        $userInitials = strtoupper(substr(auth()->user()->name, 0, 2));
        $userRole = ucfirst(auth()->user()->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.settings.users-create', compact('userInitials', 'userRole', 'currentDate'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,customer,carpenter,delivery',
            'address' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.settings.users')->with('success', 'User created successfully!');
    }

    public function editUser($id)
    {
        $editUser = User::findOrFail($id);
        $userInitials = strtoupper(substr(auth()->user()->name, 0, 2));
        $userRole = ucfirst(auth()->user()->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.settings.users-edit', compact('editUser', 'userInitials', 'userRole', 'currentDate'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,customer,carpenter,delivery',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'role', 'address']));

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.settings.users')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return redirect()->route('admin.settings.users')->with('success', 'User deleted successfully!');
    }

    public function system()
    {
        $userInitials = strtoupper(substr(auth()->user()->name, 0, 2));
        $userRole = ucfirst(auth()->user()->role);
        $currentDate = now()->format('l, j F Y');

        // System information
        $systemInfo = [
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'mysql_version' => DB::select('select version() as version')[0]->version ?? 'N/A',
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'app_env' => app()->environment(),
            'app_debug' => config('app.debug') ? 'Enabled' : 'Disabled',
            'timezone' => config('app.timezone'),
            'date' => now()->format('Y-m-d H:i:s'),
        ];

        return view('admin.settings.system', compact('userInitials', 'userRole', 'currentDate', 'systemInfo'));
    }
}