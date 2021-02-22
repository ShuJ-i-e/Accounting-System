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
                    id: $("#company option:selected").val(),
                },
                success: function(result) {
                    console.log(result);
                    $("#company").attr('disabled', 'disabled');
                    $('#backBtn').show();
                    $('#nextBtn').html("Proceed to Payment");
                    let total = result.resource
                    if (!document.getElementById('totalDiv')) {
                        $(".card-body").append(`
                        <div id="totalDiv">
                        <h3>RM: <label id="total">` + total + `</label><h3>
                        </div>`);
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

    $('select').click(function() {
        $('#companyError').hide();
    });

    $('#backBtn').click(function() {
        $("#company").removeAttr('disabled');
        $('#totalDiv').remove();
    });

});
</script>
@stop

@section('content')
<!-- form content -->
<form method="POST">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3>Create New Payment</h3>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                    style="width:30%">
                </div>
            </div>
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
            <div class="float-left">
                <a class="btn btn-primary" id="backBtn" style="display:none">BACK</a>
            </div>
        </div>

</form>
@stop