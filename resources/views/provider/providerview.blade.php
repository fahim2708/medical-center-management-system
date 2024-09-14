@extends('layouts.app')

@section('content')
<style>
    .dashboard-content-one{
        padding: 0;
    }
    /* .sidebar-menu-content{
        height: 100vh;
    } */
    .main_row{
        overflow-x: hidden;
        padding-left: 15px !important;
        padding-right: 10px !important;
    }
</style>
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area p-2 mb-2">
        <ul>
            <li>
                <a href="{{ route('home') }}">Provider Documents</a>
            </li>
            <li>Add Documents</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row no-gutters main_row">
        <!-- left side -->
        <div class="col-12 col-xl-4 col-3-xxxl">
            <div class="card dashboard-card-one d-block mr-3">
                <div class="card-body p-3">
                    <div class="ui-modal-box">
                        <div class="modal-box d-flex justify-content-between pl-4 pr-4">
                            <!-- Folder Create Button -->
                            <button type="button" class="btn btn-primary btn-lg p-3 font-weight-bold m-0" data-toggle="modal" data-target="#folder_create">
                                Add Folder
                            </button>
                            <form action="{{ route('provider.folderbulkdelete') }}" method="post">
                                @csrf
                                <div id="bulk_folder_delete_inputs"></div>
                                <button type="submit" class="btn btn-danger btn-lg p-3 font-weight-bold">
                                    Delete
                                </button>
                            </form>
                            <!-- Folder Create Button -->
                            <!-- Folder Create Modal -->
                            <div class="modal sign-up-modal fade" id="folder_create" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h2 class="font-semibold">Create Folder</h2>
                                            <div class="close-btn">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="{{ route('provider.folderinsert') }}" class="login-form">
                                                @csrf
                                                <div class="row gutters-15">
                                                    <input type="hidden" value="{{ $providerFolderId }}" name="providerFolderId">
                                                    <input type="hidden" value="{{ $doctorFolderId }}" name="doctorFolderId">
                                                    <div class="form-group col-12">
                                                        <label for="name">Folder Name</label>
                                                        <input type="text" placeholder="name" name="name" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="date">Folder Date</label>
                                                        <input type="date" placeholder="dd/mm/yyyy" name="date" class="form-control" data-position="bottom right">
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <button type="submit" class="login-btn">Create Folder</button>
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
                    {{-- <div class="sort_by">
                        <label>Sort By:</label>
                        <select class="select2" name="sort">
                            <option value="ASC">ASC</option>
                            <option value="Desc">Desc</option>
                        </select>
                    </div> --}}
                    <div class="pt-3">
                        <h6 class="m-0">All folders</h6>
                        <div class="folders d-block">
                            <div class="table-responsive">
                                <table class="table text-nowrap"> 
                                    <tbody>
                                        @foreach ($folders as $folder)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="bulkFolderDelete" value="{{ $folder->id }}" onclick="selectFolder(this)">
                                                    <label class="form-check-label"><img src="{{ asset("backend/img") }}/folder.png" style="height: 20px" alt="logo"></label>
                                                    <a href="javascript:void(0);" onclick="loadReport({{ $folder->id }})" class="text-dark"> {{ $folder->folder_name }} <span>{{ \Carbon\Carbon::parse($folder->date)->format('d-m-Y') }}
                                                        </span> </a>
                                                </div>
                                            </td>
                                            {{-- <td>
                                            </td> --}}
                                            <td>
                                                <a class="h3 btn btn-danger" href="{{ route('provider.folderdelete',['id'=>$folder->id]) }}">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- left side -->
        <!-- right side -->
        <div class="col-12 col-xl-8 col-9-xxxl p-0" id="reportsTable">
        </div>
        <!-- right side -->
    </div>

    @push('script')
    <script>
        function loadReport(id) {
            $.ajax({
                url: "{{ route('provider.filereports') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#reportsTable').html(response);

                    Dropzone.autoDiscover = false;
                    let myDropzone = new Dropzone("#filrdropzone", {
                        init: function() { },

                        // new code
                        success: function(file, response) {
                            if (response.success) {
                                appendNewFileToTable(response.file);
                            } else {
                                alert('File upload failed!');
                            }
                        }, 
                        // new code 
                    });

                },

                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }

        // new code file upload
        function appendNewFileToTable(file) {
            let serialNumber = $('#render_report tr').length + 1;
            let date = new Date(file.created_at);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();

            let formattedDate = `${day}-${month}-${year}`;

            var newRow = `
                <tr>
                    <td class="p-0">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input form-check-report" value="${file.id}" onclick="checkValue(this)">
                            <label class="form-check-label">${serialNumber}</label>
                            <a href="javascript:void(0);" onclick="fileFavourite(${file.id})" id="fileFav${file.id}">
                                <img src="{{ asset('backend/img') }}/thumbs2.png" style="height: 20px" alt="logo">
                            </a>
                        </div>
                    </td>
                    <td class="p-0">${file.file_name}
                    <td class="p-1">
                        <div id="urgent-icon-${file.id}">
                        </div>
                    </td>
                    </td>
                    <td class="p-0">${formattedDate}</td>
                    <td>
                        <div class="d-flex flex-wrap">
                            <a class="btn btn-info mr-2 mb-1"
                            href="/provider/fileopen/${file.id}" 
                            onclick="window.open(this.href, 'newwindow', 'width=1400,height=800'); return false;">
                            Open
                            </a>
                            <a class="btn btn-success mr-2 mb-1"
                            href="/provider/filedownload/${file.id}">
                            Download
                            </a>
                            <a class="btn btn-danger mr-2 mb-1"
                            href="/provider/filedelete/${file.id}">
                            Delete
                            </a>
                            <a class="btn btn-secondary mr-2 mb-1 edit_name_modal" href="#" data-id="${file.id}" data-toggle="modal" data-target="#update_name">
                            Rename
                            </a>
                            <a class="btn btn-warning" id="urgent-btn-${file.id}" onclick="toggleUrgent(${file.id}, 'urgent')" href="javascript:void(0);">
                            Urgent
                            </a>
                        </div>
                    </td>
                </tr>`;

            $('#render_report').append(newRow);
        }
        // new code for file upload

        function selectFolder(checkbox) {
            var value = checkbox.value;
            var dynamicInputs = document.getElementById('bulk_folder_delete_inputs');

            if (checkbox.checked) {
                if (!document.getElementById('input-' + value)) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = value;
                    input.id = 'input-' + value;
                    dynamicInputs.appendChild(input);
                }
            } else {
                var inputToRemove = document.getElementById('input-' + value);
                if (inputToRemove) {
                    dynamicInputs.removeChild(inputToRemove);
                }
            }
        }

        // checkbox for report
        function toggleCheckAll(source) {
            const checkboxes = document.querySelectorAll('.form-check-report');
            
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = source.checked;
            });

            updateBulkSelectReport();
        }

        function checkValue(checkbox) {
            updateBulkSelectReport();
        }

        function updateBulkSelectReport() {
            
            $('#bulk_select_report_download, #bulk_select_report_delete').empty(); 

            $('.form-check-report:checked').each(function() {
                let value = $(this).val();
                if (value !== 'on') {
                    let input = $('<input>').attr({
                    type: 'hidden',
                    name: 'ids[]',
                    value: value
                    });
                    $('#bulk_select_report_download').append(input.clone());
                    $('#bulk_select_report_delete').append(input.clone());
                }
            });
        }
        // checkbox for report

        //search report 
        function submitSearchForm() {
            event.preventDefault();
            var formData = $('#search-form').serialize();
            
            $.ajax({
                url: '{{ route("reports.search") }}',
                method: 'GET',
                data: formData,
                success: function(response) {
                    $('#render_report').html(response);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
        //search report

        // file rename modal 
        $(document).on('click', '.edit_name_modal', function() {
            var id = $(this).data('id');
            console.log(id);
            
            $.ajax({
                url: '/provider/ajax_name/' + id,
                method: 'GET',
                success: function(data) {
                    $('#nameId').val(data.id);
                    $('#old_name').val(data.file);
                }
            });
        });
        // file rename modal 


        // ajax urgent
        function toggleUrgent(reportId, action) {
            var url = action === 'urgent' ? "{{ route('provider.fileurgent', ':id') }}" : "{{ route('provider.fileremoveurgent', ':id') }}";
            url = url.replace(':id', reportId);
            console.log(url);
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        var link = $('#urgent-btn-' + reportId);
                        var iconContainer = $('#urgent-icon-' + reportId);

                        if (response.urgent == 1) {
                            link.text('Remove Urgent')
                            .removeClass('btn-warning')
                            .addClass('btn-success')
                            .attr('onclick', 'toggleUrgent(' + reportId + ', \'remove-urgent\')');
                            iconContainer.html('<img src="{{ asset('backend/img/emergency-icon.png') }}" style="height: 25px" alt="Urgent">');
                        } else {
                            link.text('Urgent')
                            .removeClass('btn-success')
                            .addClass('btn-warning')
                            .attr('onclick', 'toggleUrgent(' + reportId + ', \'urgent\')');
                            iconContainer.html('');
                        }
                    }
                },
                error: function() {
                    alert('Failed to update status.');
                }
            });
        }

    </script>
    @endpush

@endsection
