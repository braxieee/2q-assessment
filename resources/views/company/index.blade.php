@extends('layouts.app')

@section('content')
<section>
    <div class="container py-5">
        <div class="w-75 center border rounded px-3 py-3 mx-auto">
            @if(session('msg'))
                <div class="alert alert-{{session('color')}} alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row mb-4">
                <div class="col">
                    <h5>Companies</h5>
                </div>
                <div class="col">
                    <div class="d-grid d-md-flex justify-content-md-end">
                        <a href="{{ route('logout') }}">
                            <button class="btn btn-primary px-5" type="button" name="logout">Logout</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <a href="{{ route('company.create') }}">
                        <button type="button" class="btn btn-warning">Add New Company</button>
                    </a>
                </div>
            </div>
            <div>
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($companies) > 0)
                            @foreach($companies as $company)
                            <tr class="align-middle">
                                <td>
                                    <img src="{{ url($company->logo) }}" alt="image"/>
                                    &nbsp;{{ $company->name }}
                                </td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->website }}</td>
                                <td class="text-center">
                                    <a href="{{ route('company.edit', $company->id) }}">
                                        <button class="btn btn-info px-5" type="button" name="edit">Edit</button>
                                    </a>
                                    <a href="{{ route('company.delete', $company->id) }}">
                                        <button class="btn btn-danger px-5" type="button" name="delete">Delete</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No Record Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection