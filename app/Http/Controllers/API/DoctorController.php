<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorPatientRelation;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\ProviderDocuments;
use App\Models\ProviderDocumentsFolder;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //Provider List
    public function providerList()
    {
        // Get the logged-in user's ID
        $userId = Auth::user()->id;
        // Fetch the providers list associated with the logged-in user-id
        $doctor = Doctor::with('providers')->where('user_id', $userId)->get();

        return response()->json([
            'data' => $doctor
        ], 200);
    }

    //Patient List

    public function patientList()
    {
        // Get the logged-in user's ID
        $userId = Auth::user()->id;
        // Fetch the providers list associated with the logged-in user-id
        $doctor = Doctor::with('patients')->where('user_id', $userId)->get();

        return response()->json([
            'data' => $doctor
        ], 200);
    }


    //Count Patient List
    public function countPatient()
    {
        // Get the logged-in user's ID
        $userId = Auth::user()->id;
        // Fetch the providers list associated with the logged-in user-id
        $doctor = Doctor::withCount('patients')->where('user_id', $userId)->get();

        return response()->json([
            'data' => $doctor
        ], 200);
    }


    //Add a new patient
    public function addPatient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'provider_id' => 'required|exists:providers,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' =>  $validator->messages()->all(),
            ]);
        }
        DB::beginTransaction();
        try {
            //Get Logged In Doctor's ID
            $userId = Auth::user()->id;
            $doctorID = Doctor::where('user_id', $userId)->first();

            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'provider_id' => $request->provider_id,
                'dob' => $request->dob,
                'doa' => $request->doa,
                'gender' => $request->gender,
                'claim_type' => $request->claim_type,
            ]);

            $doctorPatientRelation = DoctorPatientRelation::create([
                'doctor_id' => $doctorID->id,
                'patient_id' => $patient->id,
            ]);

            DB::commit();

            return response([
                'status' => 'success',
                'message' => 'Patient added successfully',
                'patient' => $patient,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => 'Patient couldn\'t be added',
            ]);
        }
    }

    //Save file and audio

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            //Doctor ID
            $userId = Auth::user()->id;
            $doctorID = Doctor::where('user_id', $userId)->first();

            $providerId = $request->provider_id;

            $folderName = "Mobile APP";
            $folder = DB::table('provider_documents_folders')
                ->where('doctor_id', $doctorID->id)
                ->where('provider_id', $providerId)
                ->where('folder_name', $folderName)
                ->where('deleted_at')
                ->first();

            // If exists folder
            if ($folder) {
                // return "yes";

                $folderID = $folder->id;

                $files = $request->file('file');
                if ($files && $files[0] !== null) {
                    foreach ($files as $file) {
                        $uploadPath = 'mobileApp/';
                        $filename = $file->getClientOriginalName();
                        $fileExtension = $file->getClientOriginalExtension();
                        $fileNameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
                        $path = $uploadPath . $filename;
                        $i = 1;
                        while (Storage::disk('local')->exists($path)) {
                            $filename = $fileNameWithoutExtension . '_' . $i . '.' . $fileExtension;
                            $path = $uploadPath . $filename;
                            $i++;
                        }
                        Storage::disk('local')->put($path, file_get_contents($file));

                        $data = ProviderDocuments::create([
                            'file_name' => $filename,
                            'file_path' => $path,
                            'folder_id' => $folderID,
                            'doctor_id' => (int)$doctorID->id,
                            'provider_id' => (int)$providerId,
                            'patient_id' => $request->patient_id,
                            'favourites' => 2
                        ]);
                    }
                }
                // If not exists folder
            } else {
                // return "no";
                $folder = ProviderDocumentsFolder::create([
                    'folder_name' => "Mobile APP",
                    'provider_id' => (int)$providerId,
                    'doctor_id' => (int)$doctorID->id,
                    'date' => Carbon::today()->toDateString()
                ]);
                $folderId = $folder->id;

                $files = $request->file('file');
                if ($files && $files[0] !== null) {
                    foreach ($files as $file) {
                        $uploadPath = 'mobileApp/';
                        $filename = $file->getClientOriginalName();
                        $fileExtension = $file->getClientOriginalExtension();
                        $fileNameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
                        $path = $uploadPath . $filename;
                        $i = 1;
                        while (Storage::disk('local')->exists($path)) {
                            $filename = $fileNameWithoutExtension . '_' . $i . '.' . $fileExtension;
                            $path = $uploadPath . $filename;
                            $i++;
                        }
                        Storage::disk('local')->put($path, file_get_contents($file));

                        $data = ProviderDocuments::create([
                            'file_name' => $filename,
                            'file_path' => $path,
                            'folder_id' => $folderId,
                            'doctor_id' => (int)$doctorID->id,
                            'provider_id' => (int)$providerId,
                            'patient_id' => $request->patient_id,
                            'favourites' => 2
                        ]);
                    }
                }
            }

            DB::commit();

            return response([
                'status' => 'success',
                'message' => 'Files added successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }


    //Fetch All File

    public function fileList(Request $request)
    {
        
        // Authenticated Doctor ID
        $userId = Auth::user()->id;
        $doctorID = Doctor::where('user_id', $userId)->first();
    
        // Retrieve provider_id and patient_id from the request
        $providerId = $request->input('provider_id');
        $patientId = $request->input('patient_id');
    
        // Get files that match the doctor_id, provider_id, and patient_id
        $files = DB::table('provider_documents')
                    ->where('doctor_id', $doctorID->id)
                    ->where('provider_id', $providerId)
                    ->where('patient_id', $patientId)
                    // ->where('file_path', 'like', '%.mp3')
                    ->get();
    
        return response()->json([
            'data' => $files
        ], 200);
    }
    
}
