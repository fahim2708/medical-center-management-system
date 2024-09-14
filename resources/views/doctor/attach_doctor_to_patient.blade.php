@extends('layouts.app')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Attach Doctor To Patient</h3>
        <ul>
            <li>
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li>Attach Doctor To Patient</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
@if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')   
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">

            </div>
            <form action="{{ route('attach_doctor_to_patient.store') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Doctor's *</label>
                        <select
                            class="select2"
                            name="doctor"
                            id="doctor">
                            <option>Please Select Doctor *</option>
                            @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        {{-- @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Patient's *</label>
                        <select
                            class="select2"
                            name="patients[]"
                            id="patients">
                        </select>
                        {{-- @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <div class="col-12 form-group mg-t-8 text-right">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Admit Form Area End Here -->

    @push('script')
    <!-- loading doctor's using ajax -->
    <script>
        $(document).ready(function(){
            $('#doctor').change(function(){
                var doctorId = $(this).val();
                console.log(doctorId);
                
                $.ajax({
                    url: '/get_patients/'+ doctorId,
                    type: 'GET',
                    success: function(response){
                        var patients = response.patients;
                        var options = '<option value="">Please Select Patient *</option>';;
                        $.each(patients, function(index, patient){
                            options += '<option value="'+ patient.id +'">'+ patient.first_name +' '+ patient.last_name +'</option>';
                        });
                        $('#patients').html(options);
                    }
                });
            });
        });

        $("#patients").select2({
            multiple: true,
        }).on("select2:selecting", function(e) {
            if (!e.params.args.data.id) {
                e.preventDefault();
            }
        });

    </script>
    <!-- loading doctor's using ajax -->
    @endpush 
@elseif (Auth::user()->type == 'facility')
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">

            </div>
            <form action="{{ route('attach_doctor_to_patient.store') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Doctor's *</label>
                        <select
                            class="select2"
                            name="doctor"
                            id="doctor">
                            <option>Please Select Doctor *</option>
                            @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        {{-- @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Patient's *</label>
                        <select
                            class="select2"
                            name="patients[]"
                            id="patients">
                        </select>
                        {{-- @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <div class="col-12 form-group mg-t-8 text-right">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Admit Form Area End Here -->

    @push('script')
    <!-- loading doctor's using ajax -->
    <script>
        $(document).ready(function(){
            $('#doctor').change(function(){
                var doctorId = $(this).val();
                console.log(doctorId);
                
                $.ajax({
                    url: '/get_patients/'+ doctorId,
                    type: 'GET',
                    success: function(response){
                        var patients = response.patients;
                        var options = '<option value="">Please Select Patient *</option>';;
                        $.each(patients, function(index, patient){
                            options += '<option value="'+ patient.id +'">'+ patient.first_name +' '+ patient.last_name +'</option>';
                        });
                        $('#patients').html(options);
                    }
                });
            });
        });

        $("#patients").select2({
            multiple: true,
        }).on("select2:selecting", function(e) {
            if (!e.params.args.data.id) {
                e.preventDefault();
            }
        });

    </script>
    <!-- loading doctor's using ajax -->
    @endpush 
@elseif (Auth::user()->type == 'doctor')
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">   
            <div class="heading-layout1">

            </div>
            <form action="{{ route('attach_doctor_to_patient.store') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Patient's *</label>
                        <select multiple
                            class="select2"
                            name="patients[]"
                            id="patients">
                            <option value="" disabled>Please Select Doctor *</option>
                            @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->middle_name }}</option>
                            @endforeach
                        </select>
                        {{-- @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <div class="col-12 form-group mg-t-8 text-right">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Admit Form Area End Here --> 
@endif    
    
@endsection
