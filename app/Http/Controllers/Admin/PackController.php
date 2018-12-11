<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PackStoreRequest;
use App\Models\Category;
use App\Models\Pack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackController extends Controller
{
    public function index(Pack $pack)
    {
        return view('admin.packs.index', [
            'packs' => $pack->with('categories')->get()
        ]);
    }

    public function create(Category $category)
    {
        return view('admin.packs.create', [
            'categories' => $category->get()
        ]);
    }

    public function store(PackStoreRequest $request)
    {
        $pack = Pack::create($request->all());

        foreach ($request->input('categories') as $categoryId) {
            $pack->Categories()->attach($categoryId);
        }

        $pack->attachUploadedImage($request->file);

        return redirect()->to('/admin/packs')->with([
            'status' => 'Pack successfully created.'
        ]);
    }
}
