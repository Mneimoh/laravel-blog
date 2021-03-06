<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Post::orderBy('id', 'DESC')->where('post_type', 'page')->get();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('admin.page.create', compact('categories'));
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
            'title' => 'required|unique:posts',
            'details' => 'required',
            'category_id' => 'required',
        ],
            [
                'thumbnail.required' => 'Enter thumbnail url',
                'title.required' => 'Enter title',
                'title.unique' => 'Title already exist',
                'details.required' => 'Enter details',
                'category_id.required' => 'Select categories'
            ]
        );
        $post = new Post;
        $post->user_id = Auth::id();
        $post->thumbnail = $request->thumbnail;
        $post->title = $request->title;
        $post->slug = str_slug($request->title);
        $post->sub_title = $request->sub_title;
        $post->details = $request->details;
        $post->is_published = $request->is_published;
        $post->post_type = 'page';
        $post->save();

        $post->categories()->sync($request->category_id, false);
        Session::flash('message','Page created successfully');

        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Post::find($id);
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.page.edit', compact('categories','page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Post::find($id);
        $this->validate($request, [
            'thumbnail' => 'required',
            'title' => 'required|unique:posts,title,' . $page->id, //this means ignore this post id
            'details' => 'required',
            'category_id' => 'required',
        ],
            [
                'thumbnail.required' => 'Enter thumbnail url',
                'title.required' => 'Enter title',
                'title.unique' => 'Title already exist',
                'details.required' => 'Enter details',
                'category_id.required' => 'Select categories'
            ]
        );
        
        $page->user_id = Auth::id();
        $page->thumbnail = $request->thumbnail;
        $page->title = $request->title;
        $page->slug = str_slug($request->title);
        $page->sub_title = $request->sub_title;
        $page->details = $request->details;
        $page->is_published = $request->is_published;
        $page->post_type = 'page';
        $page->save();

        $page->categories()->sync($request->category_id, false);
        Session::flash('update-message','Page updated successfully');

        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();

        Session::flash('delete-message', 'Page Deleted successfully');
        return redirect()->route('pages.index');
    }
}
