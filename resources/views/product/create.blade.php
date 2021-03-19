@extends('main')

@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Insert New Product</h3>
    </div>
    <!-- form content -->
        @method('put')
        <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
            @csrf
            <!-- /.card-body -->
            <div class="card-body">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control {{ $errors->has('prodName') ? 'is-invalid' :'' }}" name="prodName"
                        id="prodName" value="" placeholder="">
                    @error('prodName')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label>Product Hotkey</label>
                    <input type="text" class="form-control {{ $errors->has('hotkey') ? 'is-invalid' :'' }}" name="hotkey"
                        id="hotkey" value="" placeholder="">
                    @error('hotkey')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
                <button type="submit"
                    class="btn btn-primary">Insert New Product</button>
            </div>
        </form>
</div>
@stop