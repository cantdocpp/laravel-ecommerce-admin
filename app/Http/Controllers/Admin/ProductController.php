<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index() {
        return view('admin.products.product');
    }

    public function create() {
        return view('admin.products.create');
    }
}
