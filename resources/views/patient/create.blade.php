@extends('layouts.app')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Add New Patient</h3>
        <ul>
            <li>
                <a href="{{ route('home') }}">Patients</a>
            </li>
            <li>Add Patient</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <form action="{{ route('patient.store') }}" method="POST" class="new-added-form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>First Name *</label>
                        <input value="{{old('first_name')}}" type="text" placeholder=""
                            class="form-control @error('first_name')
                        border-red
                    @enderror"
                            name="first_name">
                        @error('first_name')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Last Name *</label>
                        <input value="{{old('last_name')}}" type="text" placeholder=""
                            class="form-control @error('last_name')
                        border-red
                    @enderror"
                            name="last_name">
                        @error('last_name')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Facility *</label>
                        <select
                            class="select2"
                            name="provider"
                            id="provider">
                            <option value="">Please Select Facility</option>
                            @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                        @error('provider')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Date Of Birth</label>
                        <input value="{{old('dob')}}" type="date" placeholder="dd/mm/yyyy" class="form-control" data-position='bottom right'
                            name="dob">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Date Of Accident</label>
                        <input value="{{old('doa')}}" type="date" placeholder="dd/mm/yyyy" class="form-control" data-position='bottom right'
                            name="doa">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Gender</label>
                        <select class="select2" name="gender">
                            <option value="">Please Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Claim Type</label>
                        <select class="select2" name="claim_type">
                            <option value="">Please Select Claim Type</option>
                            <option value="Workers Comp">Workers Comp</option>
                            <option value="No Fault">No Fault</option>
                            <option value="Labour Law">Labour Law</option>
                            <option value="Slip and Fall">Slip and Fall</option>
                            <option value="Subbed">Subbed</option>
                            <option value="Lien">Lien</option>
                        </select>
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
