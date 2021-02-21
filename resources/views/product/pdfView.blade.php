<table class="table">
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
