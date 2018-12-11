<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        return view('admin.categories.index', [
            'categories' => $category->get()
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->all());

        $category->attachUploadedImage($request->file);

        return redirect()->to('/admin/categories')->with([
            'status' => "Category successfully created."
        ]);
    }
}
