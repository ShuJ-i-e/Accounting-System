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
                    <th scope="col">Company ID</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Total Due(RM)</th>
                    <th scope="col">Total Balance(RM)</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->id }}</td>
                    <td>{{ $company->companyName }}</td>
                    <td>{{ $company->companyDebt }}</td>
                    <td>{{ $company->companyBalance }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>

</body>

</html>