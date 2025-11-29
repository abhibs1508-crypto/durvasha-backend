<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display all contact messages
     */
    public function index()
    {
        $contacts = Contact::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $contacts,
        ]);
    }

    /**
     * Store a new contact message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = Contact::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
            'data' => $contact,
        ]);
    }

    /**
     * Show single contact message
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Message not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $contact,
        ]);
    }

    /**
     * Delete a contact message
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Message not found',
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'status' => true,
            'message' => 'Message deleted successfully',
        ]);
    }
}
