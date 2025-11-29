<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display all gallery items
     */
    public function index()
    {
        $items = Gallery::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $items,
        ]);
    }

    /**
     * Store a new gallery item
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'              => 'required|string|max:255',
            'image'              => 'nullable|string',
            'gallery_images'     => 'nullable|array',
            'gallery_images.*.url' => 'nullable|string',
            'short_description'  => 'nullable|string',
            'status'             => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $item = Gallery::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Gallery item created successfully',
            'data' => $item,
        ]);
    }

    /**
     * Display a single gallery item
     */
    public function show($id)
    {
        $item = Gallery::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Gallery item not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $item,
        ]);
    }

    /**
     * Update gallery item
     */
    public function update(Request $request, $id)
    {
        $item = Gallery::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Gallery item not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'              => 'sometimes|string|max:255',
            'image'              => 'nullable|string',
            'gallery_images'     => 'nullable|array',
            'gallery_images.*.url' => 'nullable|string',
            'short_description'  => 'nullable|string',
            'status'             => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $item->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Gallery item updated successfully',
            'data' => $item,
        ]);
    }

    /**
     * Delete gallery item
     */
    public function destroy($id)
    {
        $item = Gallery::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Gallery item not found',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Gallery item deleted successfully',
        ]);
    }
}
