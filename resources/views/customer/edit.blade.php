@extends('main')

@section('js')
<script>
$(document).ready(function() {
    var count = 0;
    document.getElementById("rowNum").value = count;
    $(".add-row").click(function() {
        count += 1;
        var row = '<tr>' +
            '<td><button type="button" class="btn btn-danger btn-sm delete-row"> <i class="fa fa-trash"></i></button></td>' +
            '<td><select class="form-control" name="product[' + count + ']" id="product[' + count +']">' +
            '<option disabled selected>select product</option>' +
            '@foreach($products as $product)' +
            '<option value="{{ $product->id }}">{{ $product->prodName }}</option>' +
            '@endforeach' +
            '</select></td>' +
            '<td><input type="text" class="form-control" id="price[' + count + ']" name="price[' + count + ']" onkeyup="calcTotal(' + count + ')"/></td>' +
            '<td><input type="text" class="form-control" id="weight[' + count + ']" name="weight[' + count + ']" onkeyup="calcTotal(' + count + ')"/></td>' +
            '<td><input type="text" class="form-control" id="quantity[' + count + ']" name="quantity[' + count + ']" onkeyup="calcTotal(' + count + ')"/></td>' +
            '<td><input type="text" class="form-control" id="Mweight[' + count + ']" name="Mweight[' + count + ']" onkeyup="calcTotal(' + count + ')"/></td>' +
            '<td><input type="text" class="form-control" id="remarks[' + count + ']" name="remarks[' + count + ']" value="-"/></td>' +
            '<td><input type="text" class="form-control form-total" id="total[' + count + ']" name="total[' + count + ']" readonly="readonly" value="0.00"/></td>' +
            '</tr>';
        $("tbody").append(row);
        document.getElementById("rowNum").value = count;
    });

    $(document).on("click", ".delete-row", function() {
        $(this).parents("tr").remove();
        //recalculate grantTotal on delete
        var grantTotal=0;
        $('.form-total').each(function(){
            grantTotal += parseInt($(this).val());
        });
        document.getElementById("invTotal").value = grantTotal.toFixed(2);
    });

});

function calcTotal(index) {
    var grantTotal=0;
    var weight = document.getElementById("weight[" + index + "]").value;
    var price = document.getElementById("price[" + index + "]").value;
    var Mweight = document.getElementById("Mweight[" + index + "]").value;
    var quantity = document.getElementById("quantity[" + index + "]").value;
    document.getElementById("total[" + index + "]").value = (((weight * quantity) - Mweight) * price).toFixed(2);
    $('.form-total').each(function(){
        grantTotal += parseInt($(this).val());
    });
    document.getElementById("invTotal").value = grantTotal.toFixed(2);
}

</script>
@stop
@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Invoice {{ $invoices->id }}</h3>
    </div>
    <!-- form content -->
    <form method="POST" name="form" id="form" action="{{route('customer.update',$invoices->id)}}"
        enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="company">Company Name</label>
                <input type="text" class="form-control" id="compName" name="compName" readonly="readonly"
                    value="{{ $invoices->companyName }}"></input>
                <br>
                <button type="button" class="btn btn-success btn-sm float-right add-row"> <i
                        class="fa fa-plus-circle"></i> Add</button>
                <br>
                <br>
                <table class="table" name="table1">
                    <thead>
                        <tr>
                        <th>&nbsp</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price per KG (RM)</th>
                                <th scope="col">Weight per box(kg)</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">-KG</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Total(RM)</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($orders as $order)

                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-row"> <i
                                        class="fa fa-trash"></i></button>
                            </td>

                            <td><select class="form-control" id="product[{{$loop->index}}]" name="product[{{$loop->index}}]">
                                    <option disabled selected>select product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" @if ($product->prodName==$order->prodName)
                                        selected='selected' @endif>{{ $product->prodName }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" class="form-control" id="price[{{$loop->index}}]"
                                    name="price[{{$loop->index}}]" onkeyup="calcTotal(0)" value="{{ $order->price }}" />
                            </td>

                            <td><input type="text" class="form-control" id="weight[{{$loop->index}}]"
                                    name="weight[{{$loop->index}}]" onkeyup="calcTotal(0)"
                                    value="{{ $order->weight }}"></input>
                            </td>
                            <td><input type="text" class="form-control" id="quantity[{{$loop->index}}]"
                                    name="quantity[{{$loop->index}}]" onkeyup="calcTotal(0)"
                                    value="{{ $order->quantity }}"></input>
                            </td>
                            <td><input type="text" class="form-control" id="Mweight[{{$loop->index}}]"
                                    name="Mweight[{{$loop->index}}]" onkeyup="calcTotal(0)"
                                    value="{{ $order->Mweight }}"></input>
                            </td>
                            <td><input type="text" class="form-control" id="remarks[{{$loop->index}}]"
                                    name="remarks[{{$loop->index}}]" onkeyup="calcTotal(0)"
                                    value="{{ $order->remarks }}"></input>
                            </td>
                            <td><input type="text" class="form-control form-total" id="total[{{$loop->index}}]"
                                    name="total[{{$loop->index}}]" readonly="readonly"
                                    value="{{ $order->total }}"></input>
                                    <input type="hidden" id="orderId[{{$loop->index}}]" name="orderId[{{$loop->index}}]"
                                value="{{ $order->id }}">

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h4>Grand Total(RM):<h4>
                            </td>
                            <td>
                                <h4><input type="text"
                                        class="form-control {{ $errors->has('invTotal') ? 'is-invalid' :'' }}"
                                        id="invTotal" name="invTotal" readonly="readonly"
                                        value="{{ $invoices->invTotal }}"></input></h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <input type="hidden" id="rowNum" name="rowNum">
                <input type="hidden" id="initialTotal" name="initialTotal" value="{{ $invoices->invTotal }}">
                <input type="hidden" id="compId" name="compId" value="{{ $invoices->companyId }}">
            </div>

        </div>
        <!-- /.card-footer -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Invoice {{ $invoices->id }}</button>
        </div>
    </form>
</div>
@stop