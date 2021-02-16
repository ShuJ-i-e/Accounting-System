@extends('main')
  
@section('content')

<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Show Product</h3>
    </div>
            <!-- /.card-body -->
            <div class="card-body">
                <div class="form-group">
                    <label>Product ID</label>
                    <input type="text" class="form-control" name="id"
                        id="id"placeholder="{{ $resource->id }}" disabled >
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="prodName"
                        id="prodName"placeholder="{{ $resource->prodName }}" disabled >
                </div>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
            <div>
                <a class="btn btn-info" href="{{ route('product.index') }}"> Back</a>
                <a class="btn btn-warning" href="{{ route('product.edit',$resource->id) }}"> Edit</a>
            </div>

            </div>
        </form>
</div>

@endsection