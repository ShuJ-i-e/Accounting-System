@extends('main')

@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Insert New Product</h3>
    </div>
    <!-- form content -->
    @if(isset($resource))
    <form method="POST" action="{{route('product.update', [$resource->id])}}" enctype="multipart/form-data">
        @method('put')
        @else
        <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
            @endif
            @csrf
            <!-- /.card-body -->
            <div class="card-body">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control {{ $errors->has('prodName') ? 'is-invalid' :'' }}" name="prodName"
                        id="prodName" value="{{ old('prodName', isset($resource) ? $resource->prodName : '') }}" placeholder="">
                    @error('prodName')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
                <button type="submit"
                    class="btn btn-primary">{{ isset($resource) ? 'Add New Product' : 'Insert New Product' }}</button>
            </div>
        </form>
</div>
@stop