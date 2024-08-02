<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $todayAdmissions = Admission::whereDate('datetime_of_admission', now()->format('Y-m-d'))->get();
        return response()->json($todayAdmissions, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'ward' => 'required|max:255',
            'datetime_of_admission' => 'required|date',
        ]);

        $admission = Admission::create($validatedData);

        return response()->json($admission, 201);
    }

    public function show(string $id)
    {
        $admission = Admission::find($id);

        if ($admission) {
            return response()->json($admission, 200);
        } else {
            return response()->json(['message' => 'Admission not found'], 404);
        }
    }

    public function update(Request $request, Admission $admission)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'ward' => 'required|max:255',
            'datetime_of_admission' => 'required|date',
            'datetime_of_discharge' => 'nullable|date',
        ]);

        if ($admission) {
            $admission->update($validatedData);
            return response()->json($admission, 200);
        } else {
            return response()->json(['message' => 'Admission not found'], 404);
        }
    }

    public function destroy(Admission $admission)
    {
        if ($admission) {
            $admission->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Admission not found'], 404);
        }
    }

    public function discharge(Request $request, Admission $admission)
    {
        $validatedData = $request->validate([
            'datetime_of_discharge' => 'required|date',
        ]);

        if ($admission) {
            $admission->update(['datetime_of_discharge' => $validatedData['datetime_of_discharge']]);
            return response()->json($admission, 200);
        } else {
            return response()->json(['message' => 'Admission not found'], 404);
        }
    }
}