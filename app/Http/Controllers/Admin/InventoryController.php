<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.inventory.index', compact('products', 'userInitials', 'userRole', 'currentDate'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.inventory.show', compact('product', 'userInitials', 'userRole', 'currentDate'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $user = auth()->user();
        $userInitials = strtoupper(substr($user->name, 0, 2));
        $userRole = ucfirst($user->role);
        $currentDate = now()->format('l, j F Y');

        return view('admin.inventory.edit', compact('product', 'userInitials', 'userRole', 'currentDate'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully');
    }
}