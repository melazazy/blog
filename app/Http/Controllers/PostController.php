<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //title unique and only letters ,
        // image with image type [ png, jpg, webp ]and max size for upload 2M,
        // content Minimum number of letters 20

        $request->validate([
            'title'=>'required|unique:posts|alpha',
            'image'=>'required|image|mimes:png,jpg,webp|max:2048',
            'content'=>'required|min:20',
        ]);
        //image =>  return path with name (image_for_web)
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'),$imageName);
        // save Post
        $post = new Post;
        $post->title = $request->title;
        $post->author = auth()->user()->name;
        $post->content = $request->content;
        $post->image = $imageName;
        $post->date = now();
        $post->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //find post and update
        $post = Post::find($id);
        $request->validate([
            'title'=>'required|unique:posts,title,'.$post->id.'|alpha',
            'image'=>'required|image|mimes:png,jpg,webp|max:2048',
            'content'=>'required|min:20',
        ]);
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'),$imageName);
            $post->image = $imageName;
        }
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
