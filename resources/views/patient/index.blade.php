@extends('layouts.app')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>All Patients List</h3>
        <ul>
            <li>
                <a href="">Patients</a>
            </li>
            <li>All Patients</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Fees Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    {{-- <h3>All Patients</h3> --}}
                </div>
                <a class="btn-fill-lmd text-light gradient-dodger-blue" href="{{ route('patient.create') }}">Add New Patient</a>
            </div>
            <form class="mg-b-20 text-right" action="{{ route('patient.index') }}" method="GET">
                <div class="row gutters-8">
                    <div class="col-7-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        {{-- <input type="text" placeholder="Search by Name ..." class="form-control"> --}}
                    </div>
                    <div class="col-2-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <select class="form-control" name="claim">
                            <option value="">Please Select Claim Type</option>
                            <option value="Workers Comp" @selected(request('claim') == 'Workers Comp')>Workers Comp</option>
                            <option value="No Fault" @selected(request('claim') == 'No Fault')>No Fault</option>
                            <option value="Labour Law" @selected(request('claim') == 'Labour Law')>Labour Law</option>
                            <option value="Slip and Fall" @selected(request('claim') == 'Slip and Fall')>Slip and Fall</option>
                            <option value="Subbed" @selected(request('claim') == 'Subbed')>Subbed</option>
                            <option value="Lien" @selected(request('claim') == 'Lien')>Lien</option>
                        </select>
                    </div>
                    <div class="col-2-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                                    <label class="form-check-label">Case</label>
                                </div>
                            </th>
                            <th class="text-center">Claiment</th>
                            <th>Document</th>
                            <th>Claim Type</th>
                            <th>Facility</th>

                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input">
                                        <label class="form-check-label">{{ $patient->id }}</label>
                                    </div>
                                </td>
                                <td class="text-center"><span class="font-weight-bold">{{ $patient->last_name}}</span><br>{{ $patient->first_name }}</td>
                                <td><a href="{{ route('patient.view',['id'=>$patient->id]) }}" onclick="window.open('{{ route('patient.view',['id'=>$patient->id]) }}','newwindow','width=1600,height=800'); return false;">OPEN</a></td>
                                <td>{{$patient->claim_type}}</td>
                                <td>{{$patient->provider->name ?? null}}</td>

                                <td class="text-center">
                                    <div class="d-flex">
                                        <a class="dropdown-item text-success p-0" href="{{ route('patient.edit', ['id' => $patient->id]) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a class="dropdown-item text-danger p-0" href="{{ route('patient.delete',['id' => $patient->id]) }}">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{-- {{ $patients->links() }} --}}
                {{ $patients->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- Fees Table Area End Here -->
@endsection
