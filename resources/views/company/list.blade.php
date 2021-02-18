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
        <div class="pull-right">
            <a class="btn btn-success" href="/company/create"> Create New Company</a>
        </div>
    </div>
</div>

<br>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Company ID</th>
            <th scope="col">Company Name</th>
            <th scope="col">Company Phone</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($companies as $company)
    <tr>
        <td>{{ $company->id }}</td>
        <td>{{ $company->companyName }}</td>
        <td>{{ $company->companyPhone }}</td>
        <td>
            <form action="{{ route('company.destroy',$company->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('company.show',$company->id) }}"><i class="fa fa-eye"></i></a>

                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit" value="1"
                    href="{{ route('company.edit',$company->id) }}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger btn-sm" data-toggle="tooltip" onclick="return confirm('Are you sure?')"
                    title="Delete" "><i class=" fa fa-times"></i></button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <div class="d-flex justify-content-center">
            {!! $companies->render("pagination::bootstrap-4") !!}
        </div>
    </tfoot>
</table>


@endsection