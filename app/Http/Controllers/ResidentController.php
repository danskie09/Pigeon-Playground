<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;

class ResidentController extends Controller
{
    //

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:Male,Female',
                'civil_status' => 'required|in:Single,Married,Widowed,Divorced',
                'address' => 'required|string',
                'contact_number' => 'required|string|size:11',
                'email' => 'nullable|email|max:255'
            ]);

            $resident = Resident::create($validated);

            return redirect()->back()->with('success', 'Resident created successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create resident')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $resident = Resident::findOrFail($id);
        return response()->json($resident);
    }













}
