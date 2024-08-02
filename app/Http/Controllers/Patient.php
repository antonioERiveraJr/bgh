<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return response()->json(Patient::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'middle_name' => 'nullable|max:255',
            'suffix_name' => 'nullable|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|max:255',
        ]);

        $patient = Patient::create($validatedData);

        return response()->json($patient, 201);
    }

    public function show(string $id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            return response()->json($patient, 200);
        } else {
            return response()->json(['message' => 'Patient not found'], 404);
        }
    }

    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'middle_name' => 'nullable|max:255',
            'suffix_name' => 'nullable|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|max:255',
        ]);

        if ($patient) {
            $patient->update($validatedData);
            return response()->json($patient, 200);
        } else {
            return response()->json(['message' => 'Patient not found'], 404);
        }
    }

    public function destroy(Patient $patient)
    {
        if ($patient) {
            $patient->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Patient not found'], 404);
        }
    }
}
