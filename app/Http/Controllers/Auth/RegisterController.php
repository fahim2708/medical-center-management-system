<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Doctor;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function create(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            //If user type doctor
            if ($request->type == 'doctor') {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'type' => $request->type,
                ]);

                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'can_add_patient' => 1
                ]);
            }
            //If user type provider
            elseif ($request->type == 'facility') {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'type' => $request->type,
                ]);

                $provider = Provider::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'can_add_doctor' => 1
                ]);
            }

            //Other users type
            else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'type' => $request->type,
                ]);
            }

            DB::commit();

            if(Auth::user()->type === "facility")
            {
                return redirect('/');
            }
            return redirect('/users');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error');
        }
    }
}
