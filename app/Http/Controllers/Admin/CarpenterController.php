<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class CarpenterController extends Controller
{
    public function index()
    {
        $carpenters = User::where('role', 'carpenter')->latest()->paginate(15);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.carpenters.index', compact('carpenters', 'userInitials', 'userRole', 'currentDate'));
    }

    public function show($id)
    {
        $carpenter = User::with('assignedTasks')->findOrFail($id);
        $tasks = Task::where('carpenter_id', $id)->with('order')->latest()->get();

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.carpenters.show', compact('carpenter', 'tasks', 'userInitials', 'userRole', 'currentDate'));
    }
}