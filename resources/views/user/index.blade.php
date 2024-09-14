@extends('layouts.app')
@section('content')
<!-- Breadcubs Area Start Here -->
<div class="breadcrumbs-area">
    <h3>All Users</h3>
    <ul>
        <li>
            <a href="">User Management</a>
        </li>
        <li>All Users</li>
    </ul>
</div>
<!-- Breadcubs Area End Here -->
<!-- Fees Table Area Start Here -->
<div class="card height-auto">
    <div class="card-body">
        <form class="mg-b-20 text-right" action="{{ route('user.index') }}" method="GET">
            <div class="row gutters-8">
                <div class="col-6-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    {{-- <input type="text" placeholder="Search by Name ..." class="form-control"> --}}
                </div>
                <div class="col-2-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <select class="form-control" name="type">
                        <option value="">Select User Type...</option>
                        <option value="admin" @selected(request('type') == 'admin')>Admin</option>
                        <option value="provider" @selected(request('type') == 'provider')>Facility</option>
                        <option value="doctor" @selected(request('type') == 'doctor')>Doctor</option>
                    </select>
                </div>
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <input type="text" placeholder="Search..." class="form-control" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table data-table text-nowrap">
                <thead>
                    <tr>
                        <th> 
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input checkAll">
                                <label class="form-check-label">ID</label>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Username</th>
                        <th>Type</th>
                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label">#{{ $user->id }}</label>
                            </div>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->type }}</td>
                        <td>
                            {{-- <div class="d-flex"> --}}
                                @if($user->type != "superadmin")
                                <a class="dropdown-item text-success p-0" href="{{ route('user.edit', ['id' => $user->id]) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- <a class="dropdown-item text-danger p-0" href="#">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a> --}}
                                @endif
                            {{-- </div> --}}
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $users->links() }} --}}
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
<!-- Fees Table Area End Here -->
@endsection