@extends('main')

@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Insert New Company</h3>
    </div>
    <!-- form content -->
    @if(isset($resource))
    <form method="POST" action="{{route('company.update', [$resource->id])}}" enctype="multipart/form-data">
        @method('put')
        @else
        <form method="POST" action="{{route('company.store')}}" enctype="multipart/form-data">
            @endif
            @csrf
            <!-- /.card-body -->
            <div class="card-body">
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control {{ $errors->has('companyName') ? 'is-invalid' :'' }}" name="companyName"
                        id="companyName" value="{{ old('companyName', isset($resource) ? $resource->companyName : '') }}" placeholder="">
                    @error('companyName')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label>Company Address</label>
                    <input type="text" class="form-control {{ $errors->has('companyAddress') ? 'is-invalid' :'' }}" name="companyAddress"
                        id="companyAddress" value="{{ old('companyAddress', isset($resource) ? $resource->companyAddress : '') }}" placeholder="">
                    @error('companyAddress')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label>Company Phone Number</label>
                    <input type="text" class="form-control {{ $errors->has('companyPhone') ? 'is-invalid' :'' }}" name="companyPhone"
                        id="companyPhone" value="{{ old('companyPhone', isset($resource) ? $resource->companyPhone : '') }}" placeholder="">
                    @error('companyPhone')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
                <button type="submit"
                    class="btn btn-primary">{{ isset($resource) ? 'Update Company' : 'Insert New Company' }}</button>
            </div>
        </form>
</div>
@stop