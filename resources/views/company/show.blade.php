@extends('main')

@section('js')
<script>
$(document).ready(function() {
    $('#enableEditBtn').click(function() {
        $('#editBtn').show();

    });

    $('#editForm').submit(function(event) {
        event.preventDefault();
        if ($('#companyName').val().length === 0) {
            $('#companyNameError').show();
        } 
        if ($('#companyAddress').val().length === 0) {
            $('#companyAddError').show();
        } 
        if ($('#companyPhone').val().length === 0) {
            $('#companyPhoneError').show();
        } 
        if(!($('#companyPhone').val().length === 0) && !($('#companyAddress').val().length === 0) && !($('#companyPhone').val().length != 0)) 
        {
            $(this).unbind('submit').submit()
        }
    });

});
</script>
@stop

@section('content')
<form method="POST" action="{{route('company.update', [$resource->id])}}" enctype="multipart/form-data" id="editForm">
    @method('put')
    @csrf

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <div class="input-group">
                <label>
                    <h3>Company Information</h3>
                </label>
                <div class="input-group-btn">
                    <a class="btn btn-default" href="{{ route('company.edit',$resource->id) }}">
                        <i id="enableEditBtn" class="fa fa-edit"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" class="form-control" name="companyName" id="companyName"
                    value="{{ $resource->companyName }}" @if (!isset($edit)) disabled @endif>
                <span class="error invalid-feedback" id="companyNameError">Company Name field is required</span>
            </div>
            <div class="form-group">
                <label>Company Address</label>
                <input type="text" class="form-control" name="companyAddress" id="companyAddress"
                    value="{{ $resource->companyAddress }}" @if (!isset($edit)) disabled @endif>
                    <span class="error invalid-feedback" id="companyAddError">Company Address field is required</span>

            </div>
            <div class="form-group">
                <label>Company Phone</label>
                <input type="text" class="form-control" name="companyPhone" id="companyPhone"
                    value="{{ $resource->companyPhone }}" @if (!isset($edit)) disabled @endif>
                    <span class="error invalid-feedback" id="companyPhoneError">Company Phone field is required</span>

            </div>
            <div class="form-group">
                <label>Total (RM)</label>
                <input type="text" class="form-control" name="total" id="total" value="{{ $resource->total }}"
                    disabled>
            </div>
        </div>
        <!-- /.card-footer -->
        <div class="card-footer">
            <div>
                <a class="btn btn-info" href="{{ route('company.index') }}"> Back</a>
                <button class="btn btn-warning" id="editBtn" @if (!isset($edit)) style="display:none"
                    @endif>Edit</button>
            </div>

        </div>
</form>
</div>

@stop