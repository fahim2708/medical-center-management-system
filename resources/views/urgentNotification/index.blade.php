@extends('layouts.app')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Urgent Notifications</h3>
        <ul>
            <li>
                <a href="">Notifications</a>
            </li>
            <li>Urgent Notifications</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Fees Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Message</th>
                            <th>File Name</th>
                            <th>Date</th>
                            <th>Sent by:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notification->id }} </td>
                                <td>{{ $notification->message }} in folder : <strong>{{ $notification->folder->folder_name }}</strong></td>
                                <td>{{ $notification->file->file_name }} </td>
                                <td>{{ $notification->created_at->format('d-m-Y') }}</td>
                                <td>{{ $notification->user_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
    <!-- Fees Table Area End Here -->
@endsection
