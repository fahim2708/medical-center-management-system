<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Provider;
use App\Models\ProviderDoctorRelation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    // view for insert data to attach provider to doctor
    public function attachProviderToDoctor()
    {

        if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin') {
            $providers = Provider::get();
            $doctors = Doctor::get();

            return view('provider.attach_provider_to_doctor', compact('providers', 'doctors'));
        } elseif (Auth::user()->type == 'facility') {
            $userProvider = Provider::where('user_id', Auth::user()->id)->firstOrFail();
            $ProviderRelation = ProviderDoctorRelation::where('provider_id', $userProvider->id)->pluck('doctor_id')->toArray();
            $doctors = Doctor::whereNotIn('id', $ProviderRelation)->get();

            return view('provider.attach_provider_to_doctor', compact('doctors'));
        } else {
            return redirect()->back()->with('error');
        }
    }

    // insert data to attach provider to doctor
    public function attachProviderToDoctorStore(Request $request)
    {

        DB::beginTransaction();

        try {
            if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin') {

                foreach ($request->doctors as $doctor) {
                    $ProviderDoctorRelation = ProviderDoctorRelation::create([
                        'provider_id' => $request->provider,
                        'doctor_id' => $doctor
                    ]);
                }
            } elseif (Auth::user()->type == 'facility') {
                $provider = Provider::where('user_id', Auth::user()->id)->firstOrFail();

                foreach ($request->doctors as $doctor) {
                    $ProviderDoctorRelation = ProviderDoctorRelation::create([
                        'provider_id' => $provider->id,
                        'doctor_id' => $doctor
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

    // fetch doctors using ajax
    public function getDoctors($provider)
    {
        $ProviderRelation = ProviderDoctorRelation::where('provider_id', $provider)->pluck('doctor_id')->toArray();
        $doctors = Doctor::whereNotIn('id', $ProviderRelation)->get();

        return response()->json(['doctors' => $doctors]);
    }

    //Show list
    public function attachProviderToDoctorList()
    {
        if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin') {
            $providers = Provider::with('doctors')->paginate(10);
            return view('provider.attach_provider_to_doctor_list', compact('providers'));
        }
        elseif (Auth::user()->type == 'facility') {
            $providers = Provider::where('user_id', Auth::user()->id)->with('doctors')->paginate(10);
            return view('provider.attach_provider_to_doctor_list', compact('providers'));

        }
    }
}
