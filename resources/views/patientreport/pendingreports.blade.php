@extends('layouts.app')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Pending Reports List</h3>
        <ul>
            <li>
                <a href="">Medical Reports</a>
            </li>
            <li>Pending Reports</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Fees Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            {{-- <div class=" text-right"> --}}
                <div class="row gutters-8">
                    <div class="col-12 form-group">
                        <form class="text-right" action="{{ route('patient.pendingreports') }}" method="GET">
                            <div class="row gutters-8">
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group d-flex align-items-center">
                                    <label for="start_date" class="mr-2">From:</label>
                                    <input value="{{ request('start_date') }}" id="start_date" type="date" placeholder="Visit From" class="form-control" data-position='bottom right' name="start_date">
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group d-flex align-items-center">
                                    <label for="end_date" class="mr-2">To:</label>
                                    <input value="{{ request('end_date') }}" id="end_date" type="date" placeholder="Visit To" class="form-control" data-position='bottom right' name="end_date">
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <select class="form-control" name="doctor">
                                        <option value="">Select Doctor</option>
                                        @foreach ($doctors as $doctor)   
                                        <option value="{{ $doctor->id }}" @selected(request('doctor') == $doctor->id)>{{ $doctor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <select class="form-control" name="provider">
                                        <option value="">Select Facility</option>
                                        @foreach ($providers as $provider)   
                                        <option value="{{ $provider->id }}" @selected(request('provider') == $provider->id)>{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <input type="text" placeholder="Search..." class="form-control" name="search" value="{{ request('search') }}">
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                    </div> --}}
                </div>
                <div class="row gutters-8">
                    <div class="col-12 form-group d-flex">
                        <form action="{{ route('patient.changestatusreport') }}" method="post">
                            @csrf
                            <div id="bulk_select_report"></div>
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success mr-3 btn-lg font-weight-bold p-2">
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('patient.changestatusreport') }}" method="post">
                            @csrf
                            <div id="bulk_select_report2"></div>
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="btn btn-warning mr-3 btn-lg font-weight-bold p-2">
                                Reject
                            </button>
                        </form>
                        <form action="{{ route('patient.changestatusreport') }}" method="post">
                            @csrf
                            <div id="bulk_select_report3"></div>
                            <input type="hidden" name="status" value="4">
                            <button type="submit" class="btn btn-info mr-3 btn-lg font-weight-bold p-2">
                                Fix
                            </button>
                        </form>
                        <form action="{{ route('patient.reportbulkdelete') }}" method="post">
                            @csrf
                            <div id="bulk_select_report4"></div>
                            <button type="submit" class="btn btn-danger mr-3 btn-lg font-weight-bold p-2">
                                Delete
                            </button>
                        </form>
                        <form action="{{ route('patient.reportbulkdownlaod') }}" method="post">
                            @csrf
                            <div id="bulk_select_report5"></div>
                            <button type="submit" class="btn btn-info btn-lg font-weight-bold p-2">
                               Download
                            </button>
                        </form>
                    </div>
                    {{-- <div class="col-7-xxxl col-xl-7 col-lg-8 col-12 form-group">
                        <form class="text-right" action="{{ route('patient.pendingreports') }}" method="GET">
                            <div class="row gutters-8">
                                <div class="col-5-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <select class="form-control" name="provider">
                                        <option value="">Select Facility</option>
                                        @foreach ($providers as $provider)   
                                        <option value="{{ $provider->id }}" @selected(request('provider') == $provider->id)>{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <input type="text" placeholder="Search..." class="form-control" name="search" value="{{ request('search') }}">
                                </div>
                                <div class="col-2-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
            {{-- </div> --}}
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                        <tr>
                            <th> 
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input checkAll">
                                    <label class="form-check-label">Case</label>
                                </div>
                            </th>
                            <th class="text-center">Claiment</th>
                            <th>Document</th>
                            <th>Facility</th>
                            <th>Doctor</th>
                            <th>Document Type</th>
                            <th>Visit date</th>
                            <th>Note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($query as $report)
                            <tr>
                                @php
                                    $patientName=App\Models\Patient::findOrFail($report->patient_id);
                                @endphp
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="{{$report->id}}" 
                                        {{-- onclick="selectReport(this)" --}}
                                        >
                                        <label class="form-check-label">{{$patientName->id}}</label>
                                    </div>
                                </td>
                                
                                <td class="text-center"><span class="font-weight-bold">{{ $patientName->last_name }}</span><br>{{ $patientName->first_name }}</td>
                                <td><a href="{{ route('patient.view',['id'=>$patientName->id]) }}" onclick="window.open('{{ route('patient.view',['id'=>$patientName->id]) }}','newwindow','width=1600,height=800'); return false;" class="text-dark"><p class="text-primary">OPEN</p></a></td>
                                @php
                                    $providerName=App\Models\Provider::findOrFail($report->provider_id);
                                @endphp
                                <td>{{ $providerName->name }}</td>
                                {{-- <td>{{ $report->doctor->name }}</td> --}}
                                <td>{{ optional($report->doctor)->name }}</td>
                                <td>{{ $report->document_type }}</td>
                                <td>{{ $report->visit_date }}</td>
                                <td>{{ $report->note }}</td>
                                <td>
                                    <div class="d-flex flex-wrap">
                                        <a class="btn btn-info mr-2 mb-1"  href="javascript:var newWindow = window.open('{{ route('onlyoffice.open', ['id' => $report->id]) }}', 'targetWindow', 'width=1600,height=800'); newWindow.focus(); void(0);">
                                            Open
                                        </a>
                                        <a class="btn btn-success mr-2 mb-1" href="{{ route('patient.reportdownload',['id'=>$report->id]) }}">
                                            Download
                                        </a>
                                        <a class="btn btn-secondary mr-2 mb-1 edit_date_modal" href="#" data-id="{{ $report->id }}" data-toggle="modal" data-target="#update_date">
                                            Edit Date
                                        </a>
                                        <a class="btn btn-primary mr-2 mb-1 edit_note_modal" href="#" data-id="{{ $report->id }}" data-toggle="modal" data-target="#update_note">
                                            Add Note
                                        </a>
                                        <a class="btn btn-danger mr-2 mb-1" href="{{ route('patient.reportdelete',['id'=>$report->id]) }}">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $query->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- Fees Table Area End Here -->

    
{{-- modal --}}
<div class="ui-modal-box">
    <div class="modal-box d-flex justify-content-between">
        <!-- edit date modal -->
        <div class="modal sign-up-modal fade" id="update_date" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="font-semibold">Update Visit Date</h2>
                        <div class="close-btn">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="{{ route('patient.reportupdatedate') }}" class="login-form">
                            @csrf
                            <div class="row gutters-15">
                                <input type="hidden" value="" name="id" id="dateId">
                                <div class="form-group col-12">
                                    <label for="date">Visit Date</label>
                                    <input type="date" id="old_date" name="date" class="form-control" data-position="bottom right" value="" required>
                                </div>
                                <div class="form-group col-12">
                                    <button type="submit" class="login-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit date modal -->


        <!-- edit note modal -->
        <div class="modal sign-up-modal fade" id="update_note" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="font-semibold">Update Note</h2>
                        <div class="close-btn">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="{{ route('patient.reportupdatenote') }}" class="login-form">
                            @csrf
                            <input type="hidden" value="" name="id" id="noteId">
                            <div class="row gutters-15">
                                <div class="form-group col-12">
                                    <label for="note">Note</label>
                                    <textarea class="textarea form-control" name="note" id="old_note" cols="8" rows="8"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button type="submit" class="login-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit note modal -->
    </div>
</div>
 {{-- modal --}}

@push('script')
    <script>
        // date modal 
        $(document).on('click', '.edit_date_modal', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/patient/ajax_date/' + id,
                method: 'GET',
                success: function(data) {
                    $('#dateId').val(data.id);
                    $('#old_date').val(data.date);
                }
            });
        });
        // date modal 

        // note modal 
        $(document).on('click', '.edit_note_modal', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/patient/ajax_note/' + id,
                method: 'GET',
                success: function(data) {
                    $('#noteId').val(data.id);
                    $('#old_note').val(data.note);
                }
            });
        });
        // note modal 

        // checkbox 
        $(document).ready(function() {
            $('.checkAll').on('change', function() {
                $('.form-check-input').prop('checked', $(this).prop('checked'));
                updateBulkSelectReport();
            });

            $('.form-check-input').on('change', function() {
                updateBulkSelectReport();
            });

            function updateBulkSelectReport() {
                $('#bulk_select_report, #bulk_select_report2, #bulk_select_report3, #bulk_select_report4, #bulk_select_report5').empty(); 

                $('.form-check-input:checked').each(function() {
                    let value = $(this).val();
                    if (value !== 'on') {
                        let input = $('<input>').attr({
                        type: 'hidden',
                        name: 'ids[]',
                        value: value
                        });
                        $('#bulk_select_report').append(input.clone());
                        $('#bulk_select_report2').append(input.clone());
                        $('#bulk_select_report3').append(input.clone());
                        $('#bulk_select_report4').append(input.clone());
                        $('#bulk_select_report5').append(input.clone());
                    }
                });
            }
        });
    </script>
@endpush
@endsection
