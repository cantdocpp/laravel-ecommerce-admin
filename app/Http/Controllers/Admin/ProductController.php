<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() {
        return view('admin.products.product');
    }

    public function create() {
        return view('admin.products.create');
    }

    private function save_image($image) {
        $image_name = $image->getClientOriginalName();
        $split_image_name = explode(' ', $image_name);
        $join_image_name = implode('-', $split_image_name);
        $lower_image_name = strtolower($join_image_name);

        $filename = 'product-photo-' . time() . '-' . $lower_image_name;

        // save to storage/app/photos as the new $filename
        $image->storeAs('public/products', $filename);

        $path = Storage::url('products/' . $filename);
        return $path;
    }

    public function store(Request $request, Product $product, Category $category) {
        $main_image = $request->file('image');
        $main_image_url = $this->save_image($main_image);
        $files = $request->other;
        $other_image_arr = [];
        foreach($files as $file) {
            array_push($other_image_arr, $this->save_image($file));
        }

        $name = $request->name;
        $description = $request->description;
        $visibility = $request->visibility;
        $category_name = $request->category;
        $price = $request->price;
        $stock = $request->stock;
        $sku = $request->sku;
        $weight = $request->weight;
        $long = $request->long;
        $width = $request->width;
        $height = $request->height;
        
        $findCategory = Category::where('category_name', $category_name)->first();
        if (is_null($findCategory)) {
            $category->category_name = $category_name;
            $category->save();
            $findCategory = $category->id;
        } else {
            $findCategory = $findCategory->id;
        }

        $product->category_id = $findCategory;
        $product->name = $name;
        $product->image = $main_image_url;
        $product->description = $description;
        $product->visibility = $visibility;
        $product->price = $price;
        $product->stock = $stock;
        $product->sku = $sku;
        $product->weight = $weight;
        $product->long = $long;
        $product->width = $width;
        $product->height = $height;
        $product->save();
        $product_id = $product->id;

        for($i = 0; $i < count($other_image_arr); $i++) {
            $productImage = new ProductImage;
            $productImage->product_id = $product_id;
            $productImage->product_image = $other_image_arr[$i];
            $productImage->save();
        }

        return 'success';
    }
}
