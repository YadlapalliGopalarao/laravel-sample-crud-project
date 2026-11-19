<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class crud extends Controller
{
    public function index(){

    }

    //create records
    public function create(Request $request){
        // Validation rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:todos,email',
            'city' => 'required|string|max:255'
        ], [
            'name.required' => 'Please enter your name.',
            'name.string' => 'Name must contain only text.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'city.required' => 'Please enter your city.'
        ]);

        // Save record into database
        $todo = Todo::create($validated);

        // Return JSON response
        return response()->json([
            'status' => true,
            'message' => 'Student created successfully.',
            'data' => $todo
        ], 201);
    }

    //get records
    public function getting(){
        //get the records
        $todo = Todo::all();

        // Return JSON response
        return response()->json([
            'status' => true,
            'message' => 'Records Fetched successfully.',
            'data' => $todo
        ], 200);
    }

    //update records
    public function update(Request $request, $id)
{
    // Find the existing record
    $todo = Todo::find($id);

    // Check whether record exists
    if (!$todo) {
        return response()->json([
            'status' => false,
            'message' => 'Student record not found.'
        ], 404);
    }

    // Validation
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:todos,email,' . $id,
        'city' => 'required|string|max:255'
    ], [
        'name.required' => 'Please enter your name.',
        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email.',
        'email.unique' => 'This email is already registered.',
        'city.required' => 'Please enter your city.'
    ]);

    // Update record
    $todo->update($validated);

    // Return response
    return response()->json([
        'status' => true,
        'message' => 'Student updated successfully.',
        'data' => $todo
    ], 200);
}

    public function show($id)
{
    // Find student by ID
    $todo = Todo::find($id);

    // Check if record exists
    if (!$todo) {
        return response()->json([
            'status' => false,
            'message' => 'Student record not found.'
        ], 404);
    }

    // Return student details
    return response()->json([
        'status' => true,
        'message' => 'Student details fetched successfully.',
        'data' => $todo
    ], 200);
}
    //delete records
    public function destroy($id)
{
    // Find the existing record
    $todo = Todo::find($id);

    // Check whether record exists
    if (!$todo) {
        return response()->json([
            'status' => false,
            'message' => 'Student record not found.'
        ], 404);
    }

    // Delete the record
    $todo->delete();

    // Return JSON response
    return response()->json([
        'status' => true,
        'message' => 'Student deleted successfully.'
    ], 200);
}

}
