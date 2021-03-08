@extends('main')

@section('js')
<script>
$(document).ready(function() {
    $('#enableEditBtn').click(function() {
        $('#editBtn').show();

    });

    $('#editForm').submit(function(event) {
        event.preventDefault();
        if($('#prodName').val().length === 0)
        {
            $('#prodNameError').show();
        }
        else
        {
            $(this).unbind('submit').submit()
        }
    });

});
</script>
@stop

@section('content')
<form method="POST" action="{{route('product.update', [$resource->id])}}" enctype="multipart/form-data" id="editForm">
    @method('put')
    @csrf
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3>Show Product</h3>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <div class="form-group">
                <label>Product ID</label>
                <input type="text" class="form-control" name="id" id="id" placeholder="{{ $resource->id }}" disabled />
            </div>
            <div class="form-group">
                <label>Product Name</label>

                <div class="input-group">
                    <input type="text" class="form-control {{ $errors->has('prodName') ? 'is-invalid' :'' }}"
                        value="{{ $resource->prodName }}" id="prodName" name="prodName" @if (!isset($edit)) disabled
                        @endif />

                    <div class="input-group-btn">
                        <a class="btn btn-default" href="{{ route('product.edit',$resource->id) }}">
                            <i id="enableEditBtn" class="fa fa-edit"></i>
                        </a>
                    </div>
                    <span class="error invalid-feedback" id="prodNameError">Product Name field is required</span>
                </div>
            </div>
        </div>
        <!-- /.card-footer -->
        <div class="card-footer">
            <div>
                <a class="btn btn-info" href="{{ route('product.index') }}"> Back</a>
                <button class="btn btn-warning" id="editBtn" @if (!isset($edit)) style="display:none" @endif>Edit</button>
            </div>

        </div>
</form>
</div>

@stop