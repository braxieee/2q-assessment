@extends('layouts.app')

@section('content')
<section>
    <div class="container py-5">
        <form action="{{ route('company.update', $companyData->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-75 center border rounded px-5 py-5 mx-auto">
                @if(session('msg'))
                    <div class="alert alert-{{session('color')}} alert-dismissible fade show" role="alert">
                        {{ session('msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row mb-5">
                    <div class="col">
                        <h5 class="mb-3">Edit Company</h5>
                    </div>
                    <div class="col">
                        <div class="d-grid d-md-flex justify-content-md-end">
                            <button class="btn btn-secondary px-5" type="button" name="cancel" onclick="window.history.back()">Cancel</button>&nbsp;
                            <button class="btn btn-primary px-5" type="submit" name="update">Update</button>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-secondary">COMPANY INFORMATION</p>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="{{ $companyData->name }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" value="{{ $companyData->email }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" accept="image/jpeg" id="logo" name="logo">
                        <br>
                        <img src="{{ url($companyData->logo) }}" alt="image"/>
                        @error('logo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="website" class="form-label">Website</label>
                        <input type="text" class="form-control" id="website" name="website" autocomplete="off" value="{{ $companyData->website }}">
                        @error('website')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection