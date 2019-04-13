<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\NewCategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        $data = [
            'categories' => $categories
        ];
        return view('admin.categories', [
            'data' => $data
        ]);
    }

    public function create(NewCategoryRequest $request) {
        $category = new Category;
        $category->name = $request->name;

        $category->save();
        return response()->json(['success' => true]);
    }

    public function edit($id) {
        $category = Category::where('id', $id)->first();
        $data = [
            'category' => $category,
            'save' => false
        ];
        return view('admin.categories.edit', [
            'data' => $data
        ]);
    }

    public function update(NewCategoryRequest $request) {
        $category = Category::where('id', $request->id)->first();
        if (!$category) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'category' => ['That category does not exist.'],
            ]);
            throw $error;
        }

        $category->name = $request->name;
        $category->save();

        $data = [
            'category' => $category,
            'save' => true
        ];

        return view('admin.categories.edit', [
            'data' => $data
        ]);
    }
}
