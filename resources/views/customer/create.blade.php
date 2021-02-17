@extends('main')

@section('js')
<script>
$(document).ready(function() {
    var count = 0;

    $(".add-row").click(function() {
        count++;
        var row = '<tr>' +
            '<td><button type="button" class="btn btn-danger btn-sm delete-row"> <i class="fa fa-trash"></i></button></td>' +
            '<td><select class="form-control" name="product[' + count + ']" id="product[' + count + ']">' +
            '<option disabled selected>select product</option>' +
            '@foreach($products as $product)' +
            '<option value="{{ $product->id }}">{{ $product->prodName }}</option>' +
            '@endforeach' +
            '</select></td>' +
            '<td><input type="text" class="form-control" id="price[' + count + ']" name="price[' + count + ']" onkeyup="calcGrantTotal(' + count +')"/></td>' +
            '<td><input type="text" class="form-control" id="weight[' + count + ']" name="weight[' + count + ']" onkeyup="calcGrantTotal(' + count +')"/></td>' +
            '<td><input type="text" class="form-control" id="Mweight[' + count + ']" name="Mweight[' + count + ']" onkeyup="calcGrantTotal(' + count +')"/></td>' +
            '<td><input type="text" class="form-control" id="remarks[' + count + ']" name="remarks[' + count + ']"/></td>' +
            '<td><input type="text" class="form-control" id="total[' + count + ']" name="total[' + count + ']" readonly="readonly" value="0.00"/></td>' +
            '</tr>';
        $("tbody").append(row);
        document.getElementById("rowNum").value = count;
        console.log(count);
    });

    $(document).on("click", ".delete-row", function() {
        count--;
        $(this).parents("tr").remove();
        document.getElementById("rowNum").value = count;
        console.log(count);
    });

});

function calcGrantTotal(index)
  {
    var rowCount = $('.table >tbody >tr').length;
    var grantTotal = 0;
    var weight = document.getElementById("weight[" + index + "]").value;
    var price = document.getElementById("price[" + index + "]").value;
    var Mweight = document.getElementById("Mweight[" + index + "]").value;
    document.getElementById("total[" + index + "]").value = ((weight-Mweight)*price).toFixed(2);
    for(var x = 0; x < rowCount; x++)
    {
        grantTotal += parseInt(document.getElementById("total[" + x + "]").value);
    }

    document.getElementById("invTotal").value = grantTotal.toFixed(2);

  }

</script>
@stop
@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Insert New Invoice</h3>
    </div>
    <!-- form content -->
    <!-- /.card-body -->
        <form method="POST" action="{{route('customer.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="company">Company Name</label>
                <select class="form-control" name="company">
                    <option disabled selected>select company</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}" id="{{ $company->id }}">{{ $company->companyName }}</option>
                    @endforeach
                </select>
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
                            <th scope="col">Price(RM)</th>
                            <th scope="col">Weight(kg)</th>
                            <th scope="col">-KG</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Total(RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-row"> <i
                                        class="fa fa-trash"></i></button>
                            </td>
                            <td> 
                            <select class="form-control" id="product[0]" name="product[0]">
                                <option disabled selected>select product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->prodName }}</option>
                                @endforeach
                            </select>
                            </td>
                            <td><input type="text" class="form-control" id="price[0]" name="price[0]" onkeyup="calcGrantTotal(0)"/></td>
                            <td><input type="text" class="form-control" id="weight[0]" name="weight[0]" onkeyup="calcGrantTotal(0)"/></td>
                            <td><input type="text" class="form-control" id="Mweight[0]" name="Mweight[0]" onkeyup="calcGrantTotal(0)"/></td>
                            <td><input type="text" class="form-control" id="remarks[0]" name="remarks[0]"/></td>
                            <td><input type="text" class="form-control" id="total[0]" name="total[0]" readonly="readonly" value="0.00"/></td>

                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h4>Grand Total(RM):<h4>
                            </td>
                            <td><h4><input type="text" class="form-control" id="invTotal" name="invTotal" readonly="readonly"></input></h4></td>
                        </tr>
                    </tfoot>
                </table>
                <input type="hidden" id="rowNum" name="rowNum" >            
            </div>

        </div>
        <!-- /.card-footer -->

        <div class="card-footer">
            <button type="submit"
                class="btn btn-primary">{{ isset($resource) ? 'Update Invoice' : 'Create New Invoice' }}</button>
        </div>
    </form>
</div>
@stop