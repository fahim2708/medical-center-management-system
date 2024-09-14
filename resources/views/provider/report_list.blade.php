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