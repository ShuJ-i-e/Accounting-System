<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <h2 class="mb-3">Customer List</h2>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Product ID</th>
            <th scope="col">Product Name</th>
            <th scope="col">Remarks</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->prodName }}</td>
        <td>{{ $product->remarks }}</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>

</body>

</html>