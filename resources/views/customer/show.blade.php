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
            <label type="text" class="form-control" id="compName[0]" name="compName[0]" readonly="readonly">{{ $invoices->companyName }}</label>
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
                        <td><label id="prodName[0]" name="prodName[0]" value="">{{ $order->prodName }}</label>
                        </td>
                        <td><label id="price[0]" name="price[0]" onkeyup="calcTotal(0)"
                                value="">{{ $order->weight }}</label>
                        </td>

                        <td><label id="weight[0]" name="weight[0]" onkeyup="calcTotal(0)">{{ $order->weight }}</label>
                        </td>
                        <td><label id="Mweight[0]" name="Mweight[0]"
                                onkeyup="calcTotal(0)">{{ $order->Mweight }}</label>
                        </td>
                        <td><label id="remarks[0]" name="remarks[0]">{{ $order->remarks }}</label>
                        </td>
                        <td><label type="text" class="form-control form-total" id="total[0]"
                                name="total[0]" readonly="readonly">{{ $order->total }}</label>
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
                                    class="form-control {{ $errors->has('invTotal') ? 'is-invalid' :'' }}" id="invTotal"
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
            <a class="btn btn-success" href="/customer/{{$invoices->id}}?export=pdf"> Download Product List</a>

            </div>
@stop