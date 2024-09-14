<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('provider');

        if ($request->filled('claim')) {
            $query->where('claim_type', $request->input('claim'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%");
            });
        }

        $patients = $query->orderBy('created_at', 'desc')->paginate(25);

        return view('patient.index', compact('patients'));
    }

    public function create()
    {
        $providers = Provider::get();
        return view('patient.create', compact('providers'));
    }

    public function store(PatientRequest $request)
    {

        DB::beginTransaction();
        try {

            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'provider_id' => $request->provider,
                'dob' => $request->dob,
                'doa' => $request->doa,
                'gender' => $request->gender,
                'claim_type' => $request->claim_type,
            ]);

            DB::commit();



            return redirect('/patients');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error');
        }
    }

    public function edit($id)
    {
        $providers = Provider::all();
        $patient = Patient::where('id', $id)->firstOrFail();
        return view('patient.edit', compact('patient', 'providers'));
    }

    public function update(PatientRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $patient = Patient::findOrFail($id);

            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->provider_id = $request->provider;
            $patient->dob = $request->dob;
            $patient->doa = $request->doa;
            $patient->gender = $request->gender;
            $patient->claim_type = $request->claim_type;

    
            $patient->save();

            DB::commit();

            return redirect('/patients')->with('success', 'Patient updated successfully');;
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error')->with('error', 'An error occurred while updating the patient');
        }
    }

    public function delete($id){
        $patientDelete = Patient::findOrFail($id)->delete();

        return redirect()->back()->with('success');
    }
}
