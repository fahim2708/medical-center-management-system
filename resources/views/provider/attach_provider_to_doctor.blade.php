@extends('layouts.app')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Attach Provider To Doctor</h3>
        <ul>
            <li>
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li>Attach Provider To Doctor</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
@if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')   
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">

            </div>
            <form action="{{ route('attach_provider_to_doctor.store') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Facility *</label>
                        <select
                            class="select2"
                            name="provider"
                            id="provider">
                            <option>Please Select Facility *</option>
                            @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                        {{-- @error('type')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Doctor's *</label>
                        <select
                            class="select2"
                            name="doctors[]"
                            id="doctors">
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
            $('#provider').change(function(){
                var providerId = $(this).val();
                console.log(providerId);
                
                $.ajax({
                    url: '/get_doctors/'+ providerId,
                    type: 'GET',
                    success: function(response){
                        var doctors = response.doctors;
                        var options = '<option value="">Please Select Doctor *</option>';;
                        $.each(doctors, function(index, doctor){
                            options += '<option value="'+ doctor.id +'">'+ doctor.name +'</option>';
                        });
                        $('#doctors').html(options);
                    }
                });
            });
        });

        $("#doctors").select2({
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
            <form action="{{ route('attach_provider_to_doctor.store') }}" method="POST" class="new-added-form">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-12 form-group">
                        <label>Doctor's *</label>
                        <select multiple
                            class="select2"
                            name="doctors[]"
                            id="doctors">
                            <option value="" disabled>Please Select Doctor *</option>
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
