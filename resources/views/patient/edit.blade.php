@extends('layouts.app')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Edit Patient</h3>
        <ul>
            <li>
                <a href="{{ route('home') }}">Patients</a>
            </li>
            <li>Edit Patient</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <form action="/patient/update/{{ $patient->id }}" method="POST" class="new-added-form"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" value="{{ $patient->id }}">
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>First Name *</label>
                        <input value="{{ $patient->first_name }}" type="text" placeholder=""
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
                        <input value="{{ $patient->last_name }}" type="text" placeholder=""
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
                        <select class="select2" name="provider" id="provider">
                            <option value="">Please Select Facility</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}" @selected($provider->id == $patient->provider_id)>{{ $provider->name }}
                                </option>
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
                        <input value="{{ $patient->dob }}" type="date" placeholder="dd/mm/yyyy" class="form-control"
                            data-position='bottom right' name="dob">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Date Of Accident</label>
                        <input value="{{ $patient->doa }}" type="date" placeholder="dd/mm/yyyy" class="form-control"
                            data-position='bottom right' name="doa">
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Gender *</label>
                        <select class="select2" name="gender">
                            <option value="">Please Select Gender</option>
                            <option value="Male" @selected($patient->gender == 'Male')>Male</option>
                            <option value="Female" @selected($patient->gender == 'Female')>Female</option>
                            <option value="N/A" @selected($patient->gender == 'N/A')>N/A</option>
                        </select>
                        @error('gender')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12 form-group">
                        <label>Claim Type</label>
                        <select class="select2" name="claim_type">
                            <option value="">Please Select Claim Type</option>
                            <option value="Workers Comp" @selected($patient->claim_type == 'Workers Comp')>Workers Comp</option>
                            <option value="No Fault" @selected($patient->claim_type == 'No Fault')>No Fault</option>
                            <option value="Labour Law" @selected($patient->claim_type == 'Labour Law')>Labour Law</option>
                            <option value="Slip and Fall" @selected($patient->claim_type == 'Slip and Fall')>Slip and Fall</option>
                            <option value="Subbed" @selected($patient->claim_type == 'Subbed')>Subbed</option>
                            <option value="Lien" @selected($patient->claim_type == 'Lien')>Lien</option>
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
