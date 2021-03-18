@extends('main')

@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3>Invoice {{ $invoices->id }}</h3>

    </div>

    <div class="card-body">
        <div class="form-group">
            <label for="company">Company Name</label>
            <label type="text" class="form-control" id="compName" name="compName" readonly="readonly">{{ $invoices->companyName }}</label>
            <br>
            <br>
            <br>
            <table class="table" name="table1">
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
                        <td><label id="prodName[{{$loop->index}}]" name="prodName[{{$loop->index}}]" value="">{{ $order->prodName }}</label>
                        </td>
                        <td><label id="price[{{$loop->index}}]" name="price[{{$loop->index}}]">{{ $order->weight }}</label>
                        </td>

                        <td><label id="weight[{{$loop->index}}]" name="weight[{{$loop->index}}]">{{ $order->weight }}</label>
                        </td>
                        <td><label id="Mweight[{{$loop->index}}]" name="Mweight[{{$loop->index}}]">{{ $order->Mweight }}</label>
                        </td>
                        <td><label id="remarks[{{$loop->index}}]" name="remarks[{{$loop->index}}]">{{ $order->remarks }}</label>
                        </td>
                        <td><label type="text" class="form-control form-total" id="total[0]"
                                name="total[{{$loop->index}}]" readonly="readonly">{{ $order->total }}</label>
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
                        <td>
                            Grand Total(RM):
                        </td>
                        <td>
                            <h4><input type="text"
                                    class="form-control" id="invTotal"
                                    name="invTotal" readonly="readonly" value="{{ $invoices->invTotal }}"></input></h4>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" id="rowNum" name="rowNum">
        </div>

    </div>
    <!-- /.card-footer -->

    <div class="card-footer">
        <a class="btn btn-primary"  href="{{ route('customer.index') }}">Back</a>
            <a class="btn btn-success" href="/customer/{{$invoices->id}}?export=pdf"> Download Invoice</a>

            </div>
@stop