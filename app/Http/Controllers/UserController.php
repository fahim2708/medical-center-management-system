<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Doctor;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('type', '!=', 'patient');

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return view('user.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return view('user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {

        // dd($request);
        DB::beginTransaction();
        try {
            // Find the user by ID
            $user = User::findOrFail($id);
            // Update user details
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->type = $request->type;
            // Check if password field is filled
            if ($request->filled('password')) {
                // Hash and update the password
                $user->password = Hash::make($request->password);
            }

            // Save the updated user information
            $user->save();

            if ($user->type === 'facility') {
                $facility = Provider::where('user_id', $user->id)->first();
                $facility->name = $request->name;
                $facility->save();
            }
            elseif($user->type === 'doctor') {
                $doctor = Doctor::where('user_id', $user->id)->first();
                $doctor->name = $request->name;
                $doctor->save();
            }

            DB::commit();

            return redirect("/users");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
