<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')
        ->with('children')
        ->orderBy('name')
        ->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')
        ->orderBy('name')
        ->get();
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
       $category = Category::create([
        'name' => $request->name,
        'parent_id' => $request->parent_id,
        'image' => '',
    ]);

    if ($request->hasFile('image')) {
        $file_name = time() . '.' . $request->image->extension();

        $upload = $request->image->move(
            public_path('images/categories'),
            $file_name
        );

        if ($upload) {
            $category->image = 'images/categories/' . $file_name;
            $category->save();
        }
    }

    return redirect()
        ->route('backend.categories.index')
        ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')
        ->where('id', '!=', $id)
        ->orderBy('name')
        ->get();

        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $file_name = time() . '.' . $request->image->extension();

            $upload = $request->image->move(
            public_path('images/categories'),
            $file_name
        );

        if ($upload) {
            $category->image = 'images/categories/' . $file_name;
        }
        }

        $category->save();

        return redirect()
        ->route('backend.categories.index')
        ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        $category->delete();
        return redirect()->route('backend.categories.index');
    }
}
