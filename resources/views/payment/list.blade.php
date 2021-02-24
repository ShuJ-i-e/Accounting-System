@extends('main')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Customer Payment History</h2>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="pull-right">
            <a class="btn btn-success" href="/payment/create"> Create New Payment</a>
        </div>
    </div>
</div>

<br>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Payment ID</th>
            <th scope="col">Company Name</th>
            <th scope="col">Payment (RM)</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($payments as $payment)
    <tr>
        <td>{{ $payment->id }}</td>
        <td>{{ $payment->companyName }}</td>
        <td>{{ $payment->payment }}</td>
        <td>
            <form action="{{ route('payment.destroy',$payment->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('payment.show',$payment->id) }}"><i class="fa fa-eye"></i></a>

                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('payment.edit',$payment->id) }}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="return confirm('Are you sure?')"
                    title="Delete" "><i class=" fa fa-times"></i></button>
            </form>
        </td>
    </tr>
    </tbody>
    @endforeach
    <tfoot>
        <div class="d-flex justify-content-center">
            {!! $payments->render("pagination::bootstrap-4") !!}
        </div>
    </tfoot>
</table>
@endsection