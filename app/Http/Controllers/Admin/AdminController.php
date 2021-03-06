<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function redirect() {
        $user = Auth::user();
        if (! $user) {
            return redirect(route('admin.dashboard'));
        }
    }

    public function showLoginView() {
        return view('admin.login');
    }

    public function index() {
        return view('admin.dashboard');
    }
}
