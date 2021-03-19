@extends('main')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Products</h2>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="float-left">
            <a class="btn btn-success" href="/product/create"> Create New Product</a>
        </div>
        <div class="float-right">
            <a class="btn btn-success" href="/product?export=pdf"> Download Product List</a>
        </div>
    </div>
</div>

<br>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Product ID</th>
            <th scope="col">Product Name</th>
            <th scope="col">Hotkey</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->prodName }}</td>
        <td>{{ $product->hotkey }}</td>
        <td>
            <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('product.show',$product->id) }}"><i class="fa fa-eye"></i></a>

                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('product.edit',$product->id) }}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="return confirm('Are you sure?')"
                    title="Delete" "><i class=" fa fa-times"></i></button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <div class="d-flex justify-content-center">
            {!! $products->render("pagination::bootstrap-4") !!}
        </div>
    </tfoot>
</table>

@endsection