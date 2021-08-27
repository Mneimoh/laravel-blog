<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = gallery::orderBy('id', 'DESC')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gallery.create');
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
            'image_url' => 'required',
        ],
            [
                'image_url.required' => 'Select image'
            ]
        );

        foreach ($request->image_url as $image_url) {
            //get the filename with extension
            $fileNameWithExt = $image_url->getClientOriginalName();

            //Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get just file extension
            $fileExtension = $image_url->getClientOriginalExtension();

            //Get file name to store
            $fileNameToStore = $fileName . '_' . $fileExtension;
            //echo "<img scr'".$fileNameToStore."'>";
            $gallery = new Gallery;
            $gallery->user_id = Auth::id();
            $gallery->image_url = $fileNameToStore;
            $save = $gallery->save();

            if ($save) {
                $image_url->storeAs('public/gelleries', $fileNameToStore);
            }
            /*$image = time().".".$image_url->getClientOriginalExtension();
            $image_url->move('/storage/gallery/', $image);
            $gellery = new Gallery;
            $gallery->image_url = $image_url;
            $gallery->save();*/
        }

        Session::flash('message', 'Images uploaded successfully');
        return redirect()->route('galleries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //Delete the image file
        Storage::delete('public/galleries' . $gallery->image_url);

        //Delete data from table
        $gallery->delete();

        Session::flash('delete-message', 'Image deleted successfully');
        return redirect()->route('galleries.index');
    }
}
