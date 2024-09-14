@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>User Edit</h3>
        <ul>
            <li>
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li>Update User</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->

    <!-- Display Error Message -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <!-- Your heading here -->
            </div>
            <form action="/user/update/{{ $user->id }}" method="POST" class="new-added-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" value="{{ $user->id }}">
                    <div class="col-xl-12 col-lg-6 col-12 form-group">
                        <label>Name *</label>
                        <input type="text" placeholder="" class="form-control @error('name') border-red @enderror" name="name" value="{{ $user->name }}">
                        @error('name')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Email *</label>
                        <input type="text" placeholder="" class="form-control @error('email') border-red @enderror" name="email" value="{{ $user->email }}">
                        @error('email')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Username *</label>
                        <input type="text" placeholder="" class="form-control @error('username') border-red @enderror" name="username" value="{{ $user->username }}">
                        @error('username')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label>User Type *</label>
                            <select class="select2" name="type">
                                <option value="">Please Select Type *</option>
                                <option value="admin" @selected($user->type == 'admin')>Admin</option>
                                <option value="facility" @selected($user->type == 'facility')>Facility</option>
                                <option value="doctor" @selected($user->type == 'doctor')>Doctor</option>
                            </select>
                            @error('type')
                                <div class="text-red text-xs">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Password *</label>
                        <input type="password" placeholder="*******" class="form-control @error('password') border-red @enderror" name="password">
                        @error('password')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 form-group mg-t-8 text-right">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Admit Form Area End Here -->
@endsection
