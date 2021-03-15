<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <h2 class="mb-3">Invoice {{ $invoices->id }}</h2>
    <label for="company">{{ $invoices->companyName}}</label>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Price(RM)</th>
                <th scope="col">Weight(kg)</th>
                <th scope="col">-KG</th>
                <th scope="col">Remarks</th>
                <th scope="col">Total(RM)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->prodName }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->weight }}</td>
                <td>{{ $order->Mweight }}</td>
                <td>{{ $order->remarks }}</td>
                <td>{{ $order->total }}</td>

            </tr>
            @endforeach
        </tbody>
        <tfoot>
        <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            Grand Total(RM):
                        </td>
                        <td>{{ $invoices->invTotal}}
                        </td>
        </tfoot>
    </table>

</body>

</html>