<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('admin.users.user');
    }

    public function create() {
        return view('admin.users.userCreate');
    }

    public function store(Request $request) {
        dd($request->all());
    }
}
