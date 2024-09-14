<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\DoctorPatientRelation;
use App\Models\ProviderDoctorRelation;
use Illuminate\Support\Facades\DB;
use Auth;

class DoctorController extends Controller
{
    public function attachDoctorToPatient(){
        if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin') {
            $doctors=Doctor::get();

            return view('doctor.attach_doctor_to_patient',compact('doctors'));
        }elseif (Auth::user()->type == 'doctor') {
            $userDoctor=Doctor::where('user_id',Auth::user()->id)->firstOrFail();

            $doctorRelation=DoctorPatientRelation::where('doctor_id',$userDoctor->id)->
                                               pluck('patient_id')->
                                               toArray();

            $patients=Patient::
                     whereNotIn('id',$doctorRelation)->
                     get();
            
            return view('doctor.attach_doctor_to_patient',compact('patients'));                                            
        }elseif (Auth::user()->type == 'facility') {
            
            $userProvider=Provider::where('user_id',Auth::user()->id)->firstOrFail();

            $ProviderRelation=ProviderDoctorRelation::where('provider_id',$userProvider->id)->
                                                        pluck('doctor_id')->
                                                        toArray();
            
            $doctors=Doctor::
                    whereIn('id',$ProviderRelation)->
                    get();
            
            return view('doctor.attach_doctor_to_patient',compact('doctors'));                                                   
        }
    }

    public function attachDoctorToPatientStore(Request $request){

        DB::beginTransaction();

        try {
            if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin' || Auth::user()->type == 'facility') {

                foreach ($request->patients as $patient) {
                    $attachDoctorToPatient=DoctorPatientRelation::create([
                        'doctor_id' => $request->doctor,
                        'patient_id' => $patient,
                    ]);
                }

            } elseif (Auth::user()->type == 'doctor') {
                $doctor=Doctor::where('user_id',Auth::user()->id)->firstOrFail();

                foreach ($request->patients as $patient) {
                    $attachDoctorToPatient=DoctorPatientRelation::create([
                        'doctor_id' => $doctor->id,
                        'patient_id' => $patient,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success');
        } catch (\Throwable $e) {

            DB::rollback();
            
            return redirect()->back()->with('error');
        }
    }

    public function getPatient($doctor){
        $doctorRelation=DoctorPatientRelation::where('doctor_id',$doctor)->
                                               pluck('patient_id')->
                                               toArray();
        $patients=Patient::
                  whereNotIn('id',$doctorRelation)->
                  get();
        return response()->json(['patients'=>$patients]);
    }

    // new provider document menu 
    public function searchDoctors($providerId, Request $request)
    {
        $query = $request->query('query');
        $ProviderRelation = ProviderDoctorRelation::where('provider_id', $providerId)->pluck('doctor_id')->toArray();
        $doctors = Doctor::whereIn('id', $ProviderRelation)
            ->where('name', 'LIKE', "%{$query}%")
            ->get();
        
        return response()->json(['doctors' => $doctors]);
    }

    public function initialDoctors($providerId)
    {
        $ProviderRelation = ProviderDoctorRelation::where('provider_id', $providerId)->pluck('doctor_id')->toArray();
        $doctors = Doctor::whereIn('id', $ProviderRelation)->take(10)->get();

        return response()->json(['doctors' => $doctors]);
    }
    // new provider document menu
}
