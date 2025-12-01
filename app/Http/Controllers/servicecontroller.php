<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    // Display all services
    public function index()
    {
        $services = Service::latest()->get();

        // Add full image URL for frontend
        $services->map(function ($service) {
            $service->image_url = url('storage/' . $service->image);
            return $service;
        });

        return response()->json([
            'status' => true,
            'data' => $services,
        ]);
    }

    // Store new service
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['slug'] = Str::slug($data['title']); // create slug from title
        $service = Service::create($data);

        return response()->json(['status' => true, 'message' => 'Service created', 'data' => $service]);
    }

    // Display single service by **slug**
    public function show($slug)
    {
        $service = Service::where('slug', $slug)->first();

        if (!$service) {
            return response()->json(['status' => false, 'message' => 'Service not found'], 404);
        }

        $service->image_url = url('storage/' . $service->image); // full image URL

        return response()->json(['status' => true, 'data' => $service]);
    }

    // Update service
    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) return response()->json(['status' => false, 'message' => 'Service not found'], 404);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'image' => 'nullable|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) return response()->json(['status' => false, 'errors' => $validator->errors()], 422);

        $data = $validator->validated();
        if (isset($data['title'])) $data['slug'] = Str::slug($data['title']); // update slug

        $service->update($data);

        return response()->json(['status' => true, 'message' => 'Service updated', 'data' => $service]);
    }

    // Delete service
    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) return response()->json(['status' => false, 'message' => 'Service not found'], 404);

        $service->delete();
        return response()->json(['status' => true, 'message' => 'Service deleted']);
    }
}
