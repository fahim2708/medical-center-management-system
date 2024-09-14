@extends('layouts.app')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Add new @if(Auth::user()->type == 'facility') doctor @else user @endif </h3>
        <ul>
            <li>
                <a href="{{ route('home') }}">User Management</a>
            </li>
            <li>Add @if(Auth::user()->type == 'facility') Doctor @else User @endif</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">

            </div>
            <form action="{{ route('register') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-12 col-lg-6 col-12 form-group">
                        <label>Name *</label>
                        <input name="name" value="{{old('name')}}" type="text" placeholder=""
                            class="form-control  @error('name')
                        border-red
                    @enderror">
                        @error('name')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Email *</label>
                        <input type="email" value="{{old('email')}}" placeholder=""
                            class="form-control  @error('email')
                        border-red
                    @enderror"
                            name="email">
                        @error('email')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Username *</label>
                        <input type="text" value="{{old('username')}}" placeholder=""
                            class="form-control   @error('username')
                        border-red
                    @enderror"
                            name="username">
                        @error('username')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>User Type *</label>
                        <select
                            class="select2"
                            name="type">
                            <option value="">Please Select Type *</option>
                            <option value="admin">Admin</option>
                            <option value="facility">Facility</option>
                            <option value="doctor">Doctor</option>
                        </select>
                        @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @elseif (Auth::user()->type == 'facility')
                     <input type="hidden" name="type" value="doctor">
                    @endif
                    <div class="col-xl-6 col-lg-6 col-12 form-group ">
                        <label>Password *</label>
                        <input type="password" placeholder=""
                            class="form-control   @error('password')
                        border-red
                    @enderror"
                            name="password">
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
