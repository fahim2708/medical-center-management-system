<div class="card dashboard-card-one d-block mr-3">
    <div class="card-body p-3">
        <form action="{{ route('provider.fileinsert') }}" method="POST" class="dropzone" enctype="multipart/form-data"
            id="filrdropzone">
            @csrf
            <input type="hidden" value="{{ $id }}" name="id">
        </form>
        <hr>
        {{-- <form class="mg-b-20 text-right mt-4">
            <div class="row gutters-8">
                <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <input type="text" placeholder="Search by Name ..." class="form-control">
                </div>
                <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                    <input type="text" placeholder="Search by Email ..." class="form-control">
                </div>
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <input type="text" placeholder="Search..." class="form-control">
                </div>
                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                </div>
            </div>
        </form> --}}
        <div class="row gutters-8">
            <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group d-flex">
                <form action="{{ route('provider.bulkfiledownload') }}" method="post">
                    @csrf
                    <div id="bulk_select_report_download"></div>
                    <input type="hidden" name="status" value="4">
                    <button type="submit" class="btn btn-success btn-lg font-weight-bold mr-2 p-3">
                        Download
                    </button>
                </form>
                <form action="{{ route('provider.bulkfiledelete') }}" method="post">
                    @csrf
                    <div id="bulk_select_report_delete"></div>
                    <button type="submit" class="btn btn-danger btn-lg font-weight-bold p-3">
                        Delete
                    </button>
                </form>
            </div>
            <div class="col-8-xxxl col-xl-8 col-lg-8 col-12 form-group">
                <form class="text-right" method="GET" id="search-form">
                    <div class="row gutters-8">
                        <input type="hidden" name="id" id="search-id" value="{{ $id }}">
                        <div class="col-7-xxxl col-xl-8 col-lg-8 col-12 form-group">
                            <input type="text" placeholder="Search..." class="form-control" name="search" id="search-input">
                        </div>
                        <div class="col-5-xxxl col-xl-4 col-lg-4 col-12 form-group">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow" onclick="submitSearchForm()">SEARCH</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table data-table text-nowrap" id="uploadTable">
                <thead>
                    <tr>
                        <th class="p-0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input form-check-all-report" onclick="toggleCheckAll(this)">
                                <label class="form-check-label">Sl no.</label>
                            </div>
                        </th>
                        <th class="p-0">Name</th>
                        <th></th>
                        <th class="p-0">Upload Date</th>
                        <th class="text-left p-0">Actions</th>
                    </tr>
                </thead>
                <tbody id="render_report">
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($reports as $report)
                        <tr>
                            <td class="p-0">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input form-check-report" value="{{ $report->id }}" onclick="checkValue(this)">
                                    <label class="form-check-label">{{ $i++ }}</label>
                                    <a href="javascript:void(0);" onclick="fileFavourite({{ $report->id }})"
                                        id="fileFav{{ $report->id }}">
                                        @if ($report->favourites == 1)
                                            <img src="{{ asset('backend/img') }}/thumbs1.png" style="height: 20px"
                                                alt="logo">
                                        @elseif ($report->favourites == 2)
                                            <img src="{{ asset('backend/img') }}/thumbs2.png" style="height: 20px"
                                                alt="logo">
                                        @endif
                                    </a>
                                </div>
                            </td>
                            <td class="p-0"><span title="{{ $report->file_name }}">{{ \Illuminate\Support\Str::words($report->file_name, 5, ' ...') }}</span>
                            <td class="p-1">
                                <div id="urgent-icon-{{ $report->id }}">
                                    @if ($report->urgent == 1)
                                        <img src="{{ asset('backend/img/emergency-icon.png') }}" style="height: 25px" alt="Urgent">
                                    @endif
                                </div>
                            </td>
                            </td>
                            <td class="p-0">{{ $report->created_at->format('d-m-Y') ?? null }}</td>
                            <td>
                                <div class="d-flex flex-wrap">
                                    <a class="btn btn-info mr-2 mb-1"
                                        href="{{ route('provider.fileopen', ['id' => $report->id]) }}"
                                        onclick="window.open(this.href, 'newwindow', 'width=1400,height=800'); return false;">
                                        Open
                                    </a>

                                    <a class="btn
                                        btn-success mr-2 mb-1"
                                        href="{{ route('provider.filedownload', ['id' => $report->id]) }}">
                                        Download
                                    </a>
                                    <a class="btn btn-danger mr-2 mb-1" href="{{ route('provider.filedelete',['id' => $report->id]) }}">
                                        Delete
                                    </a>
                                    <a class="btn btn-secondary mr-2 mb-1 edit_name_modal" href="#" data-id="{{ $report->id }}" data-toggle="modal" data-target="#update_name">
                                        Rename
                                    </a>
                                    @if ($report->urgent == 2)
                                    <a class="btn btn-warning" id="urgent-btn-{{ $report->id }}" onclick="toggleUrgent({{ $report->id }}, 'urgent')" href="javascript:void(0);">
                                        Urgent
                                    </a>
                                    @elseif ($report->urgent == 1)
                                    <a class="btn btn-success" id="urgent-btn-{{ $report->id }}" onclick="toggleUrgent({{ $report->id }}, 'remove-urgent')" href="javascript:void(0);">
                                        Remove Urgent
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- modal --}}
<div class="ui-modal-box">
    <div class="modal-box d-flex justify-content-between">
        <!-- edit name modal -->
        <div class="modal sign-up-modal fade" id="update_name" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="font-semibold">Update File Name</h2>
                        <div class="close-btn">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="{{ route('provider.fileupdatename') }}" class="login-form">
                            @csrf
                            <div class="row gutters-15">
                                <input type="hidden" value="" name="id" id="nameId">
                                <div class="form-group col-12">
                                    <label for="name">File Name</label>
                                    <input type="name" id="old_name" name="name" class="form-control" data-position="bottom right" value="" required>
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
        <!-- edit name modal -->
    </div>
</div>
 {{-- modal --}}
