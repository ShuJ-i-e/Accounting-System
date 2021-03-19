@extends('main')

@section('js')
<script>
$(document).ready(function() {
    var invoice_length=0;
    var invoice;
    var balance;

    //show related company invoices
    $('#nextBtn').click(function() {
        var companyId = $("#company option:selected").val();
        if ($('#option1').is(':selected')) { //validate company dropdown input
            $('#companyError').show(); 
        } else {
            $.ajax({ //get company invoice using ajax
                url: "/payment/" + companyId,
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    id: companyId,
                },
                success: function(result) { //if ajax success
                    console.log(result);
                    $("#company").attr('disabled', 'disabled'); //diable company dropdown input
                    $('#backDiv').show(); //show back button
                    $('#paymentDiv').show(); //show payment button
                    $('#nextBtn').hide(); //hide nest button
                    let total = result.resource[0].companyDebt
                    balance = result.resource[0].companyBalance //overwrite global variable, value retrieve from database
                    invoice = result.invoice //overwrite global variable, value retrieve from database
                    invoice_length = result.invoice.length //overwrite global variable, value retrieve from database
                    if (!document.getElementById('totalDiv')) { //if totalDiv is not exist
                        $(".card-body").append(`
                        <div id="totalDiv">
                        <div>
                        <h3>Total Due(RM): <label id="total">` + total + `</label></h3>
                        <h3>Initial Balance(RM): <label id="balance">` + balance + `</label></h3>
                        <div id="payDiv">
                        <h3>Pay (RM):</h3>
                        <input type="text" class="form-control" id="payment" name="payment"/>
                        </div>
                        <span class="error invalid-feedback" id="paymentError">Payment field is required.</span>
                        Balance after payment: <label id="balAfter">`+ balance +`</label>
                        </div>
                        <br>
                        <h3 class="text-center">Invoice List</h3>
                        <table class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Invoice ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Invoice Total (RM)</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                        </table>
                        </div>`); //append this to card body
                        for (var i = 0; i < invoice_length; i += 1) {  //append invoice list to table body
                            $("tbody").append(`
                            <tr>
                            <td>
                            <input  class="checkbox" type="checkbox" value="" id="cb` + i + `">
                            </td>
                            <td>` + result.invoice[i].id + `</td>
                            <td>` + result.invoice[i].created_at + `</td>
                            <td>` + result.invoice[i].invTotal + `</td>
                            </tr>`);
                            $('body').on(); //call function to check checkbox on keyup
                        }
                    } 
                },
                error: function(data, textStatus, errorThrown) {
                    console.log(data);
                }
            });
        }
    });

    //hide company error message on click
    $('#company').click(function() {
        $('#companyError').hide();
    });

    //back to original state without refreshing form
    $('#backBtn').click(function() {
        $("#company").removeAttr('disabled'); //enable company dropdown list
        $('#totalDiv').remove(); //remove totalDiv
        $('#paymentDiv').hide(); //hide paymentDiv
        $('#nextBtn').show(); //show nextBtn

    });

    //run function after user finish typing
    //avoid multiple looping to check unrelated checkbox
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms (1 second)

    //on keyup, start the countdown
    $('body').on('keydown', '#payment', function(){
        clearTimeout(typingTimer);
        if ($('#payment').val()) {
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        }
    });

    //user is "finished typing," check and uncheck related checkbox
    function doneTyping () {
        //initialize components
        //hide error message
        $('#pError').hide();

        //clear all checkbox
        var l = 0;
        while(l < invoice_length)
        {
            $(`#cb` + [l]).removeAttr('disabled');
            $(`#cb` + [l]).prop("checked", false);
            l++;
        }

        //find the smallest invoice total among the list
        var payment = $("#payment").val(); //value from payment input
        var bal = parseInt(payment) + parseInt(balance); //initial bal value = value from payment input + initial balance
        var smallest = invoice[0].invTotal;
        for (var i = 0; i < invoice_length - 1; i += 1)
        {
            next=invoice[i+1].invTotal;
            if(next < invoice[i].invTotal)
            {
                smallest=next;
            }
        }

        //disable all checkbox if the payment amount is too small
        if(bal < smallest)
        {
            for (var i = 0; i < invoice_length; i += 1)
            {
                $(`#cb` + [i]).prop('disabled', 'disabled');
                if (!document.getElementById('pDiv')) {
                $("#payDiv").append(
                    `<div id="pDiv">
                    <span class="error invalid-feedback" id="pError">Payment is not enough to pay any invoice</span>
                    </div>`
                );
                $('#pError').show();
                }
            }
        }
        var i = 0;
        var loop = 1;

        //check checkbox if payment is enough
        while(loop == 1 && i < invoice_length)
        {
            if (bal >= parseInt(invoice[i].invTotal)) 
            {
                $(`#cb` + [i]).prop("checked", true);
                bal = bal - invoice[i].invTotal;
            }
            else
            {
                $(`#cb` + [i]).prop("checked", false);
                loop = 0;
            }
            i++;
            
        }
        $("#balAfter").text(bal.toFixed(2)); //balance after payment

    }    

    //on checkbox change, recalculate balance and payment
    $('body').on('change', '.checkbox', function(){
        var payment = 0;
        var bal = 0;

        for (var i = 0; i < invoice_length; i += 1)
        {
            if( $(`#cb` + [i]).is(":checked")) 
            {
                payment = payment + parseInt(invoice[i].invTotal) - balance;
            }
        }
        $("#balAfter").text(bal);
        $("#payment").val(payment);
    });

    //on form submit
    $('#form').submit(function(event) {
        event.preventDefault(); //prevent form submit without validation
        var debtAfter=0;
        var invoiceId = [];
        if ($('#payment').val().length === 0) //validate payment input
        {   
            $('#paymentError').show().delay(3000).fadeOut();
        }
        else 
        {
            for (var i = 0; i < invoice_length; i += 1)
            {
                if(!$(`#cb` + [i]).is(":checked")) 
                {
                    debtAfter = debtAfter + parseInt(invoice[i].invTotal);
                }
                else
                {
                    invoiceId.push(invoice[i].id);
                }
            }
            $.ajax({
                url: "/payment",
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    companyId: $("#company option:selected").val(),
                    payment: $("#payment").val(), //payment amount
                    debtAfter: debtAfter, //remaining company debt
                    balance: $("#balAfter").text(),  //new company balance
                    inoviceIdList: invoiceId,
                },
                success: function(result) { //if ajax success
                    window.location=result.url;
                },
                error: function(data, textStatus, errorThrown) {
                    console.log(data);
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
                <a class="btn btn-primary" id="backBtn">BACK</a>
            </div>
        </div>

</form>
@stop