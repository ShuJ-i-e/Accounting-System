@extends('main')
  
@section('content')

<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Show Company</h3>
    </div>
            <!-- /.card-body -->
            <div class="card-body">
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control" name="companyName"
                        id="companyName"placeholder="{{ $resource->companyName }}" disabled >
                </div>
                <div class="form-group">
                    <label>Company Address</label>
                    <input type="text" class="form-control" name="companyAddress"
                        id="companyAddress"placeholder="{{ $resource->companyAddress }}" disabled >
                </div>
                <div class="form-group">
                    <label>Company Phone</label>
                    <input type="text" class="form-control" name="companyPhone"
                        id="companyPhone"placeholder="{{ $resource->companyPhone }}" disabled >
                </div>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
            <div>
                <a class="btn btn-info" href="{{ route('company.index') }}"> Back</a>
                <a class="btn btn-warning" href="{{ route('company.edit',$resource->id) }}"> Edit</a>
            </div>

            </div>
        </form>
</div>

@endsection