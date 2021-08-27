<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'ASC')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'thumbnail' => 'required',
            'name' => 'required|unique:categories'
        ],
            [
                'thumbnail.required' => 'Enter thumbnail url',
                'name.required' => 'Enter name',
                'name.unique' => 'Category already exist',

            ]
        );
        $category = new Category;
        $category->user_id = Auth::id();
        $category->thumbnail = $request->thumbnail;
        $category->name = $request->name;
        $category->is_published = $request->is_published;
        $category->slug = str_slug($request->name);
        $category->save();
        Session::flash('message','Category created successfully');

        return redirect()->route('categories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'thumbnail' => 'required',
            'name' => 'required|unique:categories,name,' . $category->id, //this means ignore this post id
        ],
            [
                'thumbnail.required' => 'Enter thumbnail url',
                'name.required' => 'Enter name',
                'name.unique' => 'Category already exist',

            ]
        );
        $category->user_id = Auth::id();
        $category->thumbnail = $request->thumbnail;
        $category->name = $request->name;
        $category->is_published = $request->is_published;
        $category->slug = str_slug($request->name);
        $category->save();
        Session::flash('update-message','Category updated successfully');

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        Session::flash('delete-message','Category deleted successfully');
        return redirect()->route('categories.index');
    }
}
