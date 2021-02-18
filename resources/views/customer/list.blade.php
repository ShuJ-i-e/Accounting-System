@extends('main')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Invoices</h2>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="pull-right">
            <a class="btn btn-success" href="/customer/create"> Create New Invoice</a>
        </div>
    </div>
</div>

<br>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Invoice ID</th>
            <th scope="col">Company Name</th>
            <th scope="col">Invoice Total</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($invoices as $invoice)
    <tr>
        <td>{{ $invoice->id }}</td>
        <td>{{ $invoice->companyName }}</td>
        <td>{{ $invoice->invTotal }}</td>
        <td>
            <form action="{{ route('customer.destroy',$invoice->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('customer.show',$invoice->id) }}"><i class="fa fa-eye"></i></a>

                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('customer.edit',$invoice->id) }}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="return confirm('Are you sure?')"
                    title="Delete" "><i class=" fa fa-times"></i></button>
            </form>
        </td>
    </tr>
    </tbody>
    @endforeach
    <tfoot>
        <div class="d-flex justify-content-center">
            {!! $invoices->render("pagination::bootstrap-4") !!}
        </div>
    </tfoot>
</table>
@endsection