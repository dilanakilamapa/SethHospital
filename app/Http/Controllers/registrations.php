<?php

namespace App\Http\Controllers;

use App\Models\registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class registrations extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = registration::all();
        return new JsonResponse($registrations);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registration = Registration::findOrFail($id);
        return new JsonResponse($registration);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'OTP' => 'required|integer',
            'OTP_verify' => 'required|in:true,false',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }
        
        $registration = Registration::create($request->all());
        return new JsonResponse($registration, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registration = Registration::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'age' => 'sometimes|required|integer',
            'gender' => 'sometimes|required|in:male,female',
            'OTP' => 'sometimes|required|integer',
            'OTP_verify' => 'sometimes|required|in:true,false',
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 422);
        }
        $registration->update($request->all());
        return new JsonResponse($registration, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();
        return new JsonResponse(['message' => 'Registration deleted successfully'], 200);
    }
}