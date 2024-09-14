@extends('layouts.app')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Linked Doctor</h3>
        <ul>
            <li>
                <a href="">Providers</a>
            </li>
            <li>Linked Doctor List</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Fees Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <form class="mg-b-20 text-right">
                <div class="row gutters-8">
                    <div class="col-6-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        {{-- <input type="text" placeholder="Search by Name ..." class="form-control"> --}}
                    </div>
                    <div class="col-2-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <select class="form-control">
                            <option value="">Select Type...</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                            <option value="option3">Option 3</option>
                        </select>
                    </div>
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <input type="text" placeholder="Search..." class="form-control">
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
                                    <label class="form-check-label">SN</label>
                                </div>
                            </th>
                            <th>Provider Name</th>
                            <th>Doctor Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sn = 1;
                        @endphp
                        @foreach ($providers as $provider)
                            @foreach ($provider->doctors as $doctor)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input">
                                            <label class="form-check-label">{{ $sn++ }}</label>
                                        </div>
                                    </td>

                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $doctor->name }}</td>

                                    <td>
                                        <div class="d-flex">
                                            {{-- <a class="dropdown-item text-success p-0" href="">
                                                <i class="fas fa-edit"></i> Edit
                                            </a> --}}
                                            <a class="dropdown-item text-danger p-0" href="#">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                {{ $providers->links() }}
            </div>
        </div>
    </div>
    <!-- Fees Table Area End Here -->
@endsection
