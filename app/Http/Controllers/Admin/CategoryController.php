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
        $categories=Category::OrderBy('id','DESC')->paginate(10);
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $categories=Category::create($request->all());
        $file_name=time().'.'.$request->image->extension();
        $upload=$request->image->move(public_path('images/categories'),$file_name);
        if($upload)
            {
                $categories->image="images/categories/".$file_name;
            }
            $categories->save();
            return redirect()->route('backend.categories.index');
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
        $category=Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
         $category=Category::find($id);
        $category->update($request->all());
        if($request->hasFile('image'))
         {
            $file_name=time().'.'.$request->image->extension();
            $upload=$request->image->move(public_path('images/categories'),$file_name);
            if($upload)
                {
                    $category->image='images/categories/'.$file_name;
                }
         }
         else
            {
                $category->image=$request->old_image;
            }
            $category->save();
            return redirect()->route('backend.categories.index');
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
