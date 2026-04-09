<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'name' => 'required|string',
            'message' => 'required|string',
        ]);

        return back()->with('success', 'Your message has been sent. We will get back to you shortly.');
    }
}