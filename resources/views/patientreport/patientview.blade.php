<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PMD</title>

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

    <style>
        form .error {
            color: #ff0000;
            font-weight: normal;
        }

        .drop-area {
            border: 2px dashed #525a62;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            position: relative;
        }

        .drop-area.hover {
            background-color: #f1f1f1;
        }

        .file-preview {
            margin-top: 10px;
            position: relative;
            font-size: 14px;
            color: #333;
        }
    </style>

</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper" class="wrapper bg-ash">
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>{{ $patientName->first_name }} {{ $patientName->last_name }} | Case #{{ $patientName->id }}
                    </h3>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Teacher Table Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="ui-modal-box">
                            <div class="modal-box d-flex justify-content-between">
                                <!-- Folder Create Button -->
                                <button type="button" class="modal-trigger" data-toggle="modal"
                                    data-target="#folder_create">
                                    Uploads
                                </button>
                                <!-- Folder Create Button -->
                                <!-- Folder Create Modal -->
                                <div class="modal sign-up-modal fade" id="folder_create" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h2 class="font-semibold">Uploads Documents</h2>
                                                <div class="close-btn">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="{{ route('patient.reportsubmit') }}"
                                                    class="login-form" id="register-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="patient_id"
                                                        value="{{ $patient }}">
                                                    <div class="row gutters-15">
                                                        <div class="form-group col-12">
                                                            <label>Document Type *</label>
                                                            <select class="select2" name="document_type"
                                                                id="document_type">
                                                                <option value="">Please Select</option>
                                                                <option value="INITIAL">INITIAL</option>
                                                                <option value="FOLLOW-UP">FOLLOW-UP</option>
                                                                <option value="POST-OP">POST-OP</option>
                                                                <option value="PRE-OP">PRE-OP</option>
                                                                <option value="OPERATIVE REPORT">OPERATIVE REPORT
                                                                </option>
                                                            </select>
                                                            <div id="document_type_error"></div>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <label>Facility *</label>
                                                            <select class="select2" name="provider_id" id="provider_id">
                                                                <option value="">Please Select</option>
                                                                @foreach ($providers as $provider)
                                                                    <option value="{{ $provider->id }}">
                                                                        {{ $provider->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div id="provider_id_error"></div>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <label>Doctor</label>
                                                            <select class="select2" name="doctor_id" id="doctor_id">
                                                                <option value="">Please Select</option>
                                                                @foreach ($doctors as $doctor)
                                                                    <option value="{{ $doctor->id }}">
                                                                        {{ $doctor->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <div id="doctor_id_error"></div> --}}
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <label for="date">Visit Date *</label>
                                                            <input type="date" placeholder="dd/mm/yyyy"
                                                                name="visit_date" id="visit_date"
                                                                class="form-control" data-position="bottom right">
                                                            <div id="visit_dates"></div>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            {{-- <label for="date">File *</label>
                                                            <input type="file" id="file-input" class="file-input" name="file" id="file"> --}}
                                                            <label for="file-input">File *</label>
                                                            <div id="drop-area" class="drop-area">
                                                                <p>Drag and drop a .docx file here or click to select a
                                                                    file
                                                                </p>
                                                                <input type="file" id="file-input"
                                                                    class="file-input" name="file" hidden
                                                                    accept=".docx" id="file">
                                                            </div>
                                                            <div id="file-preview" class="file-preview"></div>
                                                            <div id="file_error"></div>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <label for="date">Description</label>
                                                            <textarea class="textarea form-control" name="description" id="form-message" cols="5" rows="5"></textarea>
                                                        </div>
                                                        <div class="form-group col-12">
                                                            <label for="date">Note</label>
                                                            <textarea class="textarea form-control" name="note" id="form-message" cols="5" rows="5"></textarea>
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
                                <!-- Folder Create Modal -->
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{ route('patient.view', ['id' => $patient]) }}">
                            <div class="row gutters-8">
                                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    {{-- <input type="text" placeholder="Search by ID ..." class="form-control"> --}}
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                    {{-- <input type="text" placeholder="Search by Name ..." class="form-control"> --}}
                                </div>
                                <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search ..." class="form-control"
                                        name="search" value="{{ request()->input('search') }}">
                                </div>
                                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkAll">
                                                <label class="form-check-label">Case</label>
                                            </div>
                                        </th>
                                        <th>Claiment</th>
                                        <th>Facility</th>
                                        <th>Doctor</th>
                                        <th>Document Type</th>
                                        <th>Visit date</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patientReports as $report)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input">
                                                    <label class="form-check-label">{{ $patientName->id }}</label>
                                                </div>
                                            </td>
                                            <td>{{ $patientName->first_name }}</td>
                                            @php
                                                $providerName = App\Models\Provider::findOrFail($report->provider_id);
                                            @endphp
                                            <td>{{ $providerName->name }}</td>
                                            {{-- <td>{{ $report->doctor->name }}</td> --}}
                                            <td>{{ optional($report->doctor)->name }}</td>
                                            <td>{{ $report->document_type }}</td>
                                            <td>{{ $report->visit_date }}</td>
                                            <td>
                                                @if ($report->status == 1)
                                                    Aprroved
                                                @elseif ($report->status == 2)
                                                    Pending
                                                @elseif ($report->status == 3)
                                                    Rejected
                                                @else
                                                    Fix
                                                @endif
                                            </td>
                                            <td>{{ $report->note }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap">
                                                    {{-- <a class="btn btn-info mr-2 mb-1" href="{{ route('onlyoffice.open', ['id' => $report->id]) }}">
                                                        Open
                                                    </a> --}}
                                                    <a class="btn btn-info mr-2 mb-1"
                                                        href="javascript:var newWindow = window.open('{{ route('onlyoffice.open', ['id' => $report->id]) }}', 'targetWindow', 'width=1600,height=800'); newWindow.focus(); void(0);">
                                                        Open
                                                    </a> 
                                                    {{-- <a class="btn btn-info mr-2 mb-1"
                                                        href="javascript:var newWindow = window.open('{{ route('document.edit', ['id' => $report->id]) }}', 'targetWindow', 'width=1600,height=800'); newWindow.focus(); void(0);">
                                                        Open
                                                    </a> --}}
                                                    <a class="btn btn-primary mr-2 mb-1"
                                                        href="{{ route('patient.reportdownload', ['id' => $report->id]) }}">
                                                        Download
                                                    </a>
                                                    <a class="btn btn-primary mr-2 mb-1 edit_date_modal"
                                                        href="#" data-id="{{ $report->id }}"
                                                        data-toggle="modal" data-target="#update_date">
                                                        Edit Date
                                                    </a>
                                                    <a class="btn btn-primary mr-2 mb-1 edit_note_modal"
                                                        href="#" data-id="{{ $report->id }}"
                                                        data-toggle="modal" data-target="#update_note">
                                                        Add Note
                                                    </a>
                                                    <a class="btn btn-danger mr-2 mb-1"
                                                        href="{{ route('patient.reportdelete', ['id' => $report->id]) }}">
                                                        Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{$patientReports->links()}} --}}
                            {{ $patientReports->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
                <!-- Teacher Table Area End Here -->
                {{-- <footer class="footer-wrap-layout1">
                    <div class="copyright">© Copyrights <a href="#">akkhor</a> 2019. All rights reserved. Designed by <a href="#">PsdBosS</a></div>
                </footer> --}}
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>

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
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ route('patient.reportupdatedate') }}"
                                class="login-form">
                                @csrf
                                <div class="row gutters-15">
                                    <input type="hidden" value="" name="id" id="dateId">
                                    <div class="form-group col-12">
                                        <label for="date">Visit Date</label>
                                        <input type="date" id="old_date" name="date" class="form-control"
                                            data-position="bottom right" value="" required>
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
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ route('patient.reportupdatenote') }}"
                                class="login-form">
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
    <!-- Validate Js -->
    <script src="{{ asset('backend/js') }}/jquery.validate.js"></script>
    <!-- Custom Js -->
    <script src="{{ asset('backend/js') }}/main.js"></script>

    @stack('script')

    <script>
        //Previous Code by Nibir Start---------------------------------------------------------------

        // $(document).ready(function() {
        //     $.validator.addMethod("docxOnly", function(value, element) {
        //         return this.optional(element) || value.endsWith('.docx');
        //     }, "Please upload a .docx file");
        //     $(function() {
        //         $("#register-form").validate({
        //             rules: {
        //                 document_type: {
        //                     required: true,
        //                 },
        //                 provider_id: {
        //                     required: true,
        //                 },
        //                 visit_date: {
        //                     required: true,
        //                 },
        //                 file: {
        //                     required: true,
        //                     docxOnly: true,
        //                     maxSize: 10240
        //                 }
        //             },
        //             messages: {
        //                 document_type: {
        //                     required: "Please Select Document Type",
        //                 },
        //                 provider_id: {
        //                     required: "Please Select Provider",
        //                 },
        //                 visit_date: {
        //                     required: "Please Enter Visit Date",
        //                 },
        //                 file: {
        //                     required: "Please Insert File",
        //                     docxOnly: 'plese Insert Doc File Only',
        //                     maxSize: 'plese Insert Required Size Only'
        //                 }
        //             },
        //             errorElement: "div",
        //             errorPlacement: function(error, element) {
        //                 if (element.attr("name") == "document_type") {
        //                     error.appendTo(
        //                     "#document_type_error"); // Place error in specific div
        //                 } else if (element.attr("name") == "provider_id") {
        //                     error.appendTo("#provider_id_error"); // Place error in specific div
        //                 } else {
        //                     error.insertAfter(element); // Default error placement
        //                 }

        //             },
        //             submitHandler: function(form) {
        //                 form.submit();
        //             }
        //         });
        //     });
        // });

        //Previous Code by Nibir End---------------------------------------------------------------------
        //-----------------------------------------------------------------------------------------------
        //-----------------------------------------------------------------------------------------------
        //-----------------------------------------------------------------------------------------------
        //-----------------------------------------------------------------------------------------------
        //-----------------------------------------------------------------------------------------------
        //Fahim New Code Start---------------------------------------------------------------------------

        $(document).ready(function() {
            $.validator.addMethod("fileRequired", function(value, element) {
                console.log("File validation triggered");
                return element.files.length > 0;
            }, "Please select a file.");

            $("#register-form").validate({
                rules: {
                    document_type: {
                        required: true,
                    },
                    provider_id: {
                        required: true,
                    },
                    visit_date: {
                        required: true,
                    },
                    file: {
                        fileRequired: true,
                    }
                },
                messages: {
                    document_type: {
                        required: "Please select document type",
                    },
                    provider_id: {
                        required: "Please select facility.",
                    },
                    visit_date: {
                        required: "Please enter visit date",
                    },
                    file: {
                        fileRequired: "Please insert a file",
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    // console.log("Error:", error.text(), "Element:", element.attr("name"));
                    if (element.attr("name") == "document_type") {
                        error.appendTo("#document_type_error");
                    } else if (element.attr("name") == "provider_id") {
                        error.appendTo("#provider_id_error");
                    } else if (element.attr("name") == "visit_date") {
                        error.appendTo("#visit_dates");
                    } else if (element.attr("name") == "file") {
                        error.appendTo("#file_error");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        //Drag and Drop + check .docx file
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('file-input');
            const filePreview = document.getElementById('file-preview');

            dropArea.addEventListener('click', () => {
                fileInput.click();
            });

            dropArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dropArea.classList.add('hover');
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.classList.remove('hover');
            });

            dropArea.addEventListener('drop', (event) => {
                event.preventDefault();
                dropArea.classList.remove('hover');

                const files = event.dataTransfer.files;
                if (files.length) {
                    fileInput.files = files; // Set the files to the file input element
                    validateAndDisplayFile(files[0]); // Validate and display the file
                }
            });

            fileInput.addEventListener('change', (event) => {
                const files = event.target.files;
                if (files.length) {
                    validateAndDisplayFile(files[0]); // Validate and display the file
                }
            });

            function validateAndDisplayFile(file) {
                filePreview.innerHTML = ''; // Clear any previous content

                if (!file.name.endsWith('.docx')) {
                    alert('Please upload a .docx file.');
                    fileInput.value = ''; // Clear the input if the file is not valid
                    return;
                }

                // Display the file name
                const fileName = document.createElement('p');
                fileName.textContent = `Selected file: ${file.name}`;
                filePreview.appendChild(fileName);
            }
        });

        //Fahim New Code End-----------------------------------------------

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
    </script>

</body>

</html>
