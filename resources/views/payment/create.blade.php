@extends('main')

@section('js')
<script>
$(document).ready(function() {

    $('#nextBtn').click(function() {
        var companyId = $("#company option:selected").val();
        if ($('#option1').is(':selected')) {
            $('#companyError').show();
        } else {
            $.ajax({
                url: "/payment/" + companyId,
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    id: companyId,
                },
                success: function(result) {
                    console.log(result);
                    $("#company").attr('disabled', 'disabled');
                    $('#backDiv').show();
                    $('#paymentDiv').show();
                    $('#nextBtn').hide();
                    let total = result.resource
                    if (!document.getElementById('totalDiv')) {
                        $(".card-body").append(`
                        <div id="totalDiv">
                        <h3>Due(RM): <label id="total">` + total + `</label></h3>
                        <h3>Pay (RM):</h3>
                        <input type="text" class="form-control" id="payment" name="payment"/>
                        <span class="error invalid-feedback" id="paymentError">Payment field is required.</span>
                        </div>`
                        );
                    } else {
                        $('#total').text(total);
                    }
                },
                error: function(data, textStatus, errorThrown) {
                    console.log(data);
                }
            });
        }
    });

    $('#company').click(function() {
        $('#companyError').hide();
    });

    $('#backBtn').click(function() {
        $("#company").removeAttr('disabled');
        $('#totalDiv').remove();
        $('#paymentDiv').hide();
        $('#nextBtn').show();

    });

    $('#form').submit(function(event) {
        event.preventDefault();
        if( $('#payment').val().length === 0 )
        {
            $('#paymentError').show().delay(3000).fadeOut();
        }
        else
        {
            var finalTotal = $('#total').text() - $('#payment').val();
            $.ajax({
                url: "/payment",
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    companyId: $("#company option:selected").val(),
                    payment: $("#payment").val(),
                    finalTotal: finalTotal,
                }
            });

        }
    });

});
</script>
@stop

@section('content')
<!-- form content -->
<form method="POST" name="form" id="form" action="{{route('payment.store')}}" enctype="multipart/form-data">
@csrf
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3>Create New Payment</h3>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <div class="form-group">

                <label for="company">Company Name</label>
                <select class="form-control" name=" company" id="company">
                    <option id="option1" disabled selected>select company</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}" id="{{ $company->id }}">{{ $company->companyName }}</option>
                    @endforeach
                </select>
                <span class="error invalid-feedback" id="companyError">Select a company</span>
                <br>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a class="btn btn-primary" id="nextBtn">NEXT</a>
            </div>
            <div class="float-right" style="display:none" id="paymentDiv">

            <button type="submit" class="btn btn-primary" id="paymentBtn">Proceed To Payment</button>
                    </div>
            <div class="float-left" style="display:none" id="backDiv">
                <a class="btn btn-primary" id="backBtn" >BACK</a>
            </div>
        </div>

</form>
@stop