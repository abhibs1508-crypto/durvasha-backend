<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display all services
     */
    public function index()
    {
        $services = Service::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $services,
        ]);
    }

    /**
     * Store a new service
     */
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
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $service = Service::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Service created successfully',
            'data' => $service,
        ]);
    }

    /**
     * Display a single service
     */
    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $service,
        ]);
    }

    /**
     * Update a service
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'image' => 'nullable|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $service->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully',
            'data' => $service,
        ]);
    }

    /**
     * Delete a service
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found',
            ], 404);
        }

        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service deleted successfully',
        ]);
    }
}
