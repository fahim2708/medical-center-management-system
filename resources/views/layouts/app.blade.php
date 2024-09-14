<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PDM</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/img') }}/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('backend/fonts') }}/flaticon.css">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/fullcalendar.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/animate.min.css">
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/select2.min.css">
    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/datepicker.min.css">
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/dropzone.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/style.css">
    <!-- Modernize js -->
    <script src="{{ asset('backend/js') }}/modernizr-3.6.0.min.js"></script>

</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper" class="wrapper bg-ash">
        <!-- Header Menu Area Start Here -->
        @include('layouts.header')
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
                <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="index.html"><img src="{{ asset('backend/img') }}/logo1.png" alt="logo"></a>
                    </div>
                </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                        {{-- User Management Start --}}
                        <li class="nav-item sidebar-nav-item {{ Request::routeIs('user.index') || Request::routeIs('register') ? 'active' : '' }}">
                            <a href="#"
                                class="nav-link {{ Request::routeIs('user.index') || Request::routeIs('register') ? 'menu-active' : '' }}"><i
                                    class="flaticon-classmates"></i><span>User Management</span></a>
                            <ul class="nav sub-group-menu {{ Request::routeIs('user.index') || Request::routeIs('register') ? 'sub-group-active' : '' }}">
                                <li class="nav-item">
                                    <a href="{{ route('user.index') }}"
                                        class="nav-link {{ Request::routeIs('user.index') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>All Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('register') }}"
                                        class="nav-link {{ Request::routeIs('register') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Add User</a>
                                </li>
                            </ul>
                        </li>
                        @elseif (Auth::user()->type == 'facility')
                        {{-- User Management Start --}}
                        <li class="nav-item sidebar-nav-item {{ Request::routeIs('register') ? 'active' : '' }}">
                            <a href="#"
                                class="nav-link {{ Request::routeIs('register') ? 'menu-active' : '' }}"><i
                                    class="flaticon-classmates"></i><span>Doctor Management</span></a>
                            <ul class="nav sub-group-menu {{ Request::routeIs('register') ? 'sub-group-active' : '' }}">
                                <li class="nav-item">
                                    <a href="{{ route('register') }}"
                                        class="nav-link {{ Request::routeIs('register') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Add Doctor</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        {{-- Patients Start --}}
                        <li class="nav-item sidebar-nav-item {{ Request::routeIs('patient.index') || Request::routeIs('patient.create') ? 'active' : '' }}">
                            <a href="#"
                                class="nav-link {{ Request::routeIs('patient.index') || Request::routeIs('patient.create') ? 'menu-active' : '' }}"><i
                                    class="flaticon-multiple-users-silhouette"></i><span>Patients</span></a>
                            <ul class="nav sub-group-menu {{ Request::routeIs('patient.index') || Request::routeIs('patient.create') ? 'sub-group-active' : '' }}">
                                <li class="nav-item">
                                    <a href="{{ route('patient.index') }}"
                                        class="nav-link {{ Request::routeIs('patient.index') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>All Patients</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('patient.create') }}"
                                        class="nav-link {{ Request::routeIs('patient.create') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Add Patient</a>
                                </li>
                            </ul>
                        </li>

                        {{-- Medical Reports Start --}}
                        <li class="nav-item sidebar-nav-item {{ Request::routeIs('patient.approvereports') || Request::routeIs('patient.pendingreports') || Request::routeIs('patient.rejectedreports') || Request::routeIs('patient.fixreports') ? 'active' : '' }}">
                            <a href="#" class="nav-link {{ Request::routeIs('patient.approvereports') || Request::routeIs('patient.pendingreports') || Request::routeIs('patient.rejectedreports') || Request::routeIs('patient.fixreports') ? 'menu-active' : '' }}"><i class="flaticon-script"></i><span>Medical
                                    Reports</span></a>
                            <ul class="nav sub-group-menu {{ Request::routeIs('patient.approvereports') || Request::routeIs('patient.pendingreports') || Request::routeIs('patient.rejectedreports') || Request::routeIs('patient.fixreports') ? 'sub-group-active' : '' }}">
                                <li class="nav-item">
                                    @php
                                        $approveReports=App\Models\PatientReport::where('status', 1)->count();
                                        $pendingReports=App\Models\PatientReport::where('status', 2)->count();
                                        $rejectReports=App\Models\PatientReport::where('status', 3)->count();
                                        $fixReports=App\Models\PatientReport::where('status', 4)->count();
                                    @endphp
                                    <a href="{{ route('patient.approvereports') }}" class="nav-link {{ Request::routeIs('patient.approvereports') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Aprroved Reports ({{ $approveReports }})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('patient.pendingreports') }}" class="nav-link {{ Request::routeIs('patient.pendingreports') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Pending Reports ({{ $pendingReports }})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('patient.rejectedreports') }}" class="nav-link {{ Request::routeIs('patient.rejectedreports') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Rejected Reports ({{ $rejectReports }})</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('patient.fixreports') }}" class="nav-link {{ Request::routeIs('patient.fixreports') ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Fix Reports ({{ $fixReports }})</a>
                                </li>
                            </ul>
                        </li>

                        {{-- old Provider Documents Start --}}
                        {{-- <li class="nav-item sidebar-nav-item {{ Request::routeIs('provider.view') ? 'active' : '' }}">
                            <a href="#" class="nav-link {{ Request::routeIs('provider.view') ? 'menu-active' : '' }}"><i class="flaticon-books"></i><span>Upload Center</span></a>
                            <ul class="nav sub-group-menu {{ Request::routeIs('provider.view') ? 'sub-group-active' : '' }}">
                                @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                                    @php
                                        $allProviders = App\Models\Provider::get();
                                    @endphp
                                    @foreach ($allProviders as $singleProvider)
                                        <li class="nav-item">
                                            <a href="#" class="nav-link"><i
                                                    class="fas fa-angle-right"></i>{{ $singleProvider->name }}</a>
                                            <ul class="nav sub-group-menu {{ Request::routeIs('provider.view') ? 'sub-group-active' : '' }}">
                                                @php
                                                    $ProviderRelation = App\Models\ProviderDoctorRelation::where(
                                                        'provider_id',
                                                        $singleProvider->id,
                                                    )
                                                        ->pluck('doctor_id')
                                                        ->toArray();
                                                    $doctors = App\Models\Doctor::whereIn(
                                                        'id',
                                                        $ProviderRelation,
                                                    )->get();
                                                @endphp
                                                @foreach ($doctors as $doctor)
                                                    <li class="nav-item">
                                                        <a href="{{ route('provider.view', ['providerId' => $singleProvider->id, 'doctorId' => $doctor->id]) }}"
                                                            class="nav-link mx-5 {{ Request::routeIs('provider.view') && request()->providerId == $singleProvider->id && request()->doctorId == $doctor->id ? 'menu-active' : '' }}">{{ $doctor->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                @elseif (Auth::user()->type == 'facility')
                                    @php
                                        $singleProvider = App\Models\Provider::where(
                                            'user_id',
                                            Auth::user()->id,
                                        )->firstOrFail();
                                    @endphp
                                    <li class="nav-item">
                                        <a href="#" class="nav-link"><i
                                                class="fas fa-angle-right"></i>{{ $singleProvider->name }}</a>
                                        <ul class="nav sub-group-menu">
                                            @php
                                                $ProviderRelation = App\Models\ProviderDoctorRelation::where(
                                                    'provider_id',
                                                    $singleProvider->id,
                                                )
                                                    ->pluck('doctor_id')
                                                    ->toArray();
                                                $doctors = App\Models\Doctor::whereIn('id', $ProviderRelation)->get();
                                            @endphp
                                            @foreach ($doctors as $doctor)
                                                <li class="nav-item">
                                                    <a href="{{ route('provider.view', ['providerId' => $singleProvider->id, 'doctorId' => $doctor->id]) }}"
                                                        class="nav-link mx-5">{{ $doctor->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </li> --}}
                        {{-- old Provider Documents Ends --}}


                        {{-- new provider document menu --}}
                        <li class="nav-item sidebar-nav-item {{ Request::routeIs('provider.view') ? 'active' : '' }}">
                            <a href="#" class="nav-link {{ Request::routeIs('provider.view') ? 'menu-active' : '' }}">
                                <i class="flaticon-books"></i><span>Upload Center</span>
                            </a>
                            <ul class="nav sub-group-menu {{ Request::routeIs('provider.view') ? 'sub-group-active' : '' }}">
                                @if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                                    @php
                                        $allProviders = App\Models\Provider::get();
                                    @endphp
                                    @foreach ($allProviders as $singleProvider)
                                            @php
                                                $isActive = Request::routeIs('provider.view') && request()->providerId == $singleProvider->id;
                                            @endphp
                                        <li class="nav-item {{ $isActive ? 'active' : '' }}">
                                            <a href="#" class="nav-link {{ $isActive ? 'menu-active' : '' }}"><i class="fas fa-angle-right"></i>{{ $singleProvider->name }}</a>
                                            <ul class="nav sub-group-menu {{ $isActive ? 'menu-open' : '' }}">
                                                <!-- Search Bar -->
                                                <div class="pl-5 pr-5 mb-3">
                                                    <input type="text" id="doctorSearch-{{ $singleProvider->id }}" class="form-control my-2" placeholder="Search doctors...">
                                                </div>
                                                
                                                @php
                                                    $ProviderRelation = App\Models\ProviderDoctorRelation::where('provider_id', $singleProvider->id)
                                                        ->pluck('doctor_id')
                                                        ->toArray();
                                                    $doctors = App\Models\Doctor::whereIn('id', $ProviderRelation)->take(10)->get();
                                                @endphp
                                                <div id="doctorList-{{ $singleProvider->id }}">
                                                    @foreach ($doctors as $doctor)
                                                        <li class="nav-item {{ Request::routeIs('provider.view') && request()->providerId == $singleProvider->id && request()->doctorId == $doctor->id ? 'active' : '' }}">
                                                            <a href="{{ route('provider.view', ['providerId' => $singleProvider->id, 'doctorId' => $doctor->id]) }}"
                                                                class="nav-link mx-5 {{ Request::routeIs('provider.view') && request()->providerId == $singleProvider->id && request()->doctorId == $doctor->id ? 'menu-active' : '' }}">{{ $doctor->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </div>
                                            </ul>
                                        </li>
                                    @endforeach
                                @elseif (Auth::user()->type == 'facility')
                                    @php
                                        $singleProvider = App\Models\Provider::where('user_id', Auth::user()->id)->firstOrFail();
                                        $isActive = Request::routeIs('provider.view') && request()->providerId == $singleProvider->id;
                                    @endphp
                                    <li class="nav-item {{ $isActive ? 'active' : '' }}">
                                        <a href="#" class="nav-link {{ $isActive ? 'menu-active' : '' }}"><i class="fas fa-angle-right"></i>{{ $singleProvider->name }}</a>
                                        <ul class="nav sub-group-menu {{ $isActive ? 'menu-open' : '' }}">
                                            <!-- Search Bar -->
                                            <div class="pl-5 pr-5 mb-3">
                                                <input type="text" id="doctorSearch-{{ $singleProvider->id }}" class="form-control my-2" placeholder="Search doctors...">
                                            </div>
                                            @php
                                                $ProviderRelation = App\Models\ProviderDoctorRelation::where('provider_id', $singleProvider->id)
                                                    ->pluck('doctor_id')
                                                    ->toArray();
                                                $doctors = App\Models\Doctor::whereIn('id', $ProviderRelation)->take(10)->get();
                                            @endphp
                                            <div id="doctorList-{{ $singleProvider->id }}">
                                                @foreach ($doctors as $doctor)
                                                    <li class="nav-item {{ Request::routeIs('provider.view') && request()->providerId == $singleProvider->id && request()->doctorId == $doctor->id ? 'active' : '' }}">
                                                        <a href="{{ route('provider.view', ['providerId' => $singleProvider->id, 'doctorId' => $doctor->id]) }}"
                                                            class="nav-link mx-5 {{ Request::routeIs('provider.view') && request()->providerId == $singleProvider->id && request()->doctorId == $doctor->id ? 'menu-active' : '' }}">{{ $doctor->name }}</a>
                                                    </li>
                                                @endforeach
                                            </div>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        {{-- new provider document menu --}}

                        {{-- Providers & Doctors relation start --}}
                        <li class="nav-item">
                            <a href="{{ route('attach_provider_to_doctor') }}"
                                class="nav-link {{ Request::routeIs('attach_provider_to_doctor') ? 'menu-active' : '' }}"><i
                                    class="flaticon-menu-1"></i><span>Attached Facility with Doctors</span></a>
                        </li>

                        {{-- Patient Doctor Relation Start --}}
                        <li class="nav-item">
                            <a href="{{ route('attach_doctor_to_patient') }}"
                                class="nav-link {{ Request::routeIs('attach_doctor_to_patient') ? 'menu-active' : '' }}"><i
                                    class="flaticon-planet-earth"></i><span>Attached Doctors with Patients</span></a>
                        </li>


                        {{-------------------- Providers Doctors Relation List Start -----------------------}}
                        {{-- <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link {{ Request::routeIs('attach_provider_to_doctor') ? 'menu-active' : '' }}"><i class="flaticon-menu-1"></i><span>Providers</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="{{ route('attach_provider_to_doctor') }}" class="nav-link {{ Request::routeIs('attach_provider_to_doctor') ? 'menu-active' : '' }}"><i class="fas fa-angle-right"></i>Link Doctors</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('attach_provider_to_doctor_list') }}" class="nav-link {{ Request::routeIs('attach_provider_to_doctor_list') ? 'menu-active' : '' }}"><i class="fas fa-angle-right"></i>Linked Doctor's List</a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-------------------- Providers Doctors Relation List End -----------------------}}





                        {{------------------- Extra Code Start ------------------------------}}
                        {{-- <li class="nav-item">
                            <a href="all-subject.html" class="nav-link"><i
                                    class="flaticon-open-book"></i><span>Subject</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="class-routine.html" class="nav-link"><i class="flaticon-calendar"></i><span>Class
                                    Routine</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="student-attendence.html" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Attendence</span></a>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-shopping-list"></i><span>Exam</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="exam-schedule.html" class="nav-link"><i class="fas fa-angle-right"></i>Exam
                                        Schedule</a>
                                </li>
                                <li class="nav-item">
                                    <a href="exam-grade.html" class="nav-link"><i class="fas fa-angle-right"></i>Exam
                                        Grades</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="transport.html" class="nav-link"><i
                                    class="flaticon-bus-side-view"></i><span>Transport</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="hostel.html" class="nav-link"><i class="flaticon-bed"></i><span>Hostel</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="notice-board.html" class="nav-link"><i
                                    class="flaticon-script"></i><span>Notice</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="messaging.html" class="nav-link"><i
                                    class="flaticon-chat"></i><span>Messeage</span></a>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-menu-1"></i><span>UI Elements</span></a>
                            <ul class="nav sub-group-menu">
                                <li class="nav-item">
                                    <a href="notification-alart.html" class="nav-link"><i class="fas fa-angle-right"></i>Alart</a>
                                </li>
                                <li class="nav-item">
                                    <a href="button.html" class="nav-link"><i class="fas fa-angle-right"></i>Button</a>
                                </li>
                                <li class="nav-item">
                                    <a href="grid.html" class="nav-link"><i class="fas fa-angle-right"></i>Grid</a>
                                </li>
                                <li class="nav-item">
                                    <a href="modal.html" class="nav-link"><i class="fas fa-angle-right"></i>Modal</a>
                                </li>
                                <li class="nav-item">
                                    <a href="progress-bar.html" class="nav-link"><i class="fas fa-angle-right"></i>Progress Bar</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-tab.html" class="nav-link"><i class="fas fa-angle-right"></i>Tab</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-widget.html" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Widget</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="map.html" class="nav-link"><i
                                    class="flaticon-planet-earth"></i><span>Map</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="account-settings.html" class="nav-link"><i
                                    class="flaticon-settings"></i><span>Account</span></a>
                        </li> --}}
                        {{------------------- Extra Code End ------------------------------}}

                    </ul>
                </div>
            </div>
            <!-- Sidebar Area End Here -->
            <div class="dashboard-content-one">
                @yield('content')
                <!-- Footer Area Start Here -->
                {{-- @include('layouts.footer') --}}
                <!-- Footer Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
    <!-- jquery-->
    <script src="{{ asset('backend/js') }}/jquery-3.3.1.min.js"></script>
    <!-- Plugins js -->
    <script src="{{ asset('backend/js') }}/plugins.js"></script>
    <!-- Popper js -->
    <script src="{{ asset('backend/js') }}/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('backend/js') }}/bootstrap.min.js"></script>
    <!-- Counterup Js -->
    <script src="{{ asset('backend/js') }}/jquery.counterup.min.js"></script>
    <!-- Moment Js -->
    <script src="{{ asset('backend/js') }}/moment.min.js"></script>
    <!-- Waypoints Js -->
    <script src="{{ asset('backend/js') }}/jquery.waypoints.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="{{ asset('backend/js') }}/jquery.scrollUp.min.js"></script>
    <!-- Full Calender Js -->
    <script src="{{ asset('backend/js') }}/fullcalendar.min.js"></script>
    <!-- Chart Js -->
    <script src="{{ asset('backend/js') }}/Chart.min.js"></script>
    <!-- Select 2 Js -->
    <script src="{{ asset('backend/js') }}/select2.min.js"></script>
    <!-- Date Picker Js -->
    <script src="{{ asset('backend/js') }}/datepicker.min.js"></script>
    <!-- Dropzone Js -->
    <script src="{{ asset('backend/js') }}/dropzone.min.js"></script>
    <!-- Custom Js -->
    <script src="{{ asset('backend/js') }}/main.js"></script>

    @stack('script')

    {{-- ajax file favourite --}}
    <script>
        function fileFavourite(id) {
            $.ajax({
                url: '/provider/filefavourite/' + id,
                type: 'Get',
                data: {
                    id: 'id'
                },
                success: function(response) {
                    if(response.result==1){
                        $('#fileFav'+id).html('<img src="{{ asset("backend/img/thumbs1.png") }}" style="height: 20px" alt="logo">');
                    }else{
                        $('#fileFav'+id).html('<img src="{{ asset("backend/img/thumbs2.png") }}" style="height: 20px" alt="logo">');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        }

        // new provider documents menu
        document.querySelectorAll('input[id^="doctorSearch"]').forEach(input => {
            input.addEventListener('input', function() {
                let providerId = this.id.split('-')[1];
                let filter = this.value.toLowerCase();
                let doctorList = document.getElementById(`doctorList-${providerId}`);

                if (filter.length > 0) {
                    // Perform AJAX call to search in all doctors
                    fetch(`/search/doctors/${providerId}?query=${filter}`)
                        .then(response => response.json())
                        .then(data => {
                            doctorList.innerHTML = '';
                            if (data.doctors.length > 0) {
                                data.doctors.forEach(doctor => {
                                    let doctorItem = `<li class="nav-item">
                                        <a href="/view/${providerId}/${doctor.id}" class="nav-link mx-5">${doctor.name}</a>
                                    </li>`;
                                    doctorList.innerHTML += doctorItem;
                                });
                            } else {
                                doctorList.innerHTML = '<li class="nav-item">No doctors found</li>';
                            }
                        });
                } else {
                    // Reset to initial 10 doctors when search is cleared
                    fetch(`/provider/${providerId}/doctors/initial`)
                        .then(response => response.json())
                        .then(data => {
                            doctorList.innerHTML = '';
                            data.doctors.forEach(doctor => {
                                let doctorItem = `<li class="nav-item">
                                    <a href="/view/${providerId}/${doctor.id}" class="nav-link mx-5">${doctor.name}</a>
                                </li>`;
                                doctorList.innerHTML += doctorItem;
                            });
                        });
                }
            });
        });
        // new provider documents menu
    </script>
    {{-- ajax file favourite --}}
</body>

</html>
