<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // GET all blogs
    public function index()
    {
        return Blog::orderBy('id', 'desc')->get();
    }

    // GET single blog
    public function show($id)
    {
        return Blog::findOrFail($id);
    }

    // CREATE blog
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'image'       => 'nullable|image',
            'content'     => 'required',
            'description' => 'nullable',
            'status'      => 'required',
        ]);

        // Upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'title'       => $request->title,
            'slug'        => $request->slug ?? Str::slug($request->title),
            'image'       => $imagePath,
            'content'     => $request->contant,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'data'    => $blog,
        ]);
    }

    // UPDATE blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'image'       => 'nullable|image',
            'content'     => 'required',
            'description' => 'nullable',
            'status'      => 'required',
        ]);

        // Upload new image if available
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $blog->image = $imagePath;
        }

        $blog->title       = $request->title;
        $blog->slug        = $request->slug ?? Str::slug($request->title);
        $blog->content     = $request->contant;
        $blog->description = $request->description;
        $blog->status      = $request->status;

        $blog->save();

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'data'    => $blog,
        ]);
    }

    // DELETE blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }
}
