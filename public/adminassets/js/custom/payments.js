$(document).ready(function () {
    $(".selectpaymenttype").select2({
        placeholder: "إختر طريقة الدفع",
        allowClear: true
    });

    $(".selectcurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectamountfor").select2({
        placeholder: "إختر نوع الدفعة",
        allowClear: true
    });

    $(".selectpaymentstatus").select2({
        placeholder: "إخنر نوع عملية الدفع",
        allowClear: true
    });

    getpayments($('#client_id').val());
    getsum();
});

$(document).on('click', '.edit-btn', function(){
    clearpayment();
    $('#cflag').val('1');
    $('#payment_id').val($(this).data('id'));
    $('#savepayment').text("تعديل البيانات");
    $('#paymentdate').val($(this).data('paydate'));
    $('#paymenttype').select2('data', {id: $(this).data('paytypeid'), a_key: $(this).data('paytype')}).change();
    $('#amount').val($(this).data('payamount'));
    $('#checknum').val($(this).data('paychecknum'));
    $('#curr').select2('data', {id: $(this).data('paycurrid'), a_key: $(this).data('paycurr')}).change();
    $('#amountfor').select2('data', {id: $(this).data('payamountforid'), a_key: $(this).data('payamountfor')}).change();
    $('#paymentstatus').select2('data', {id: $(this).data('paystatusid'), a_key: $(this).data('paystatus')}).change();
});

$('#tablepayments').on('click', '.delete-btn', function () {
    // $('#payment_id').val($(this).data('id'));
    var $fid = $(this).attr('data-id')
    bootbox.confirm({
        message: $("#del_msg").val(),
        title: $("#CONFIRM").val(),
        buttons:
            {
                'confirm': {
                    label: '<i class="fa fa-check"></i> ' + $("#YES").val(),
                    className: 'btn-danger'
                },
                'cancel': {
                    label: '<i class="fa fa-times"></i> ' + $("#CANCEL").val(),
                    className: 'btn-default'
                }
            },
        callback: function (result) {
            if (result) {
                // console.log($fid);
                $.ajax({
                    type: 'POST',
                    url: '/deletepayment',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            getpayments($('#client_id').val())
                            getsum();
                            clearpayment();
                        }
                    }
                });
            }
        }
    });
});

// $(document).on('click', '.delete-btn', function() {
//     $('#payment_id').val($(this).data('id'));
//     console.log( $('#payment_id').val());
//     $.ajax({
//         type: 'POST',
//         url: '/deletepayment',
//         data: {
//             '_token': $('meta[name="csrf-token"]').attr('content'),
//             'id': $('input[name=payment_id]').val()
//         },
//         success: function(data){
//             getpayments($('#client_id').val())
//             clearpayment();
//         }
//     });
// });

$(document).on('click', '#clearpayment', function(){
    clearpayment();
});

$(document).on('click', '#savepayment', function(){
    var cflag = $('#cflag').val();
    if (cflag == "0") {
        // console.log($('#client_id').val());
        $.ajax({
            type: 'POST',
            url: '/storepayment',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'client': $('#client_id').val(),
                'paymentdate': $('input[name=paymentdate]').val(),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'amount': $('input[name=amount]').val(),
                'checknum': $('input[name=checknum]').val(),
                'curr': $('#curr option:selected').attr("value"),
                'amountfor': $('#amountfor option:selected').attr("value"),
                'paymentstatus': $('#paymentstatus option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_paymentdate').remove()
                    $('#err_details_paymenttype').remove()
                    $('#err_details_amount').remove()
                    $('#err_details_curr').remove()
                    $('#err_details_amountfor').remove()
                    $('#err_details_paymentstatus').remove()
                    getpayments($('#client_id').val());
                    getsum();
                    clearpayment();
                }
            }
        });
    }else if (cflag == "1") {
        // console.log($('input[name=payment_id]').val());
        var $fid = $('#payment_id').val();
        $.ajax({
            type: 'POST',
            url: '/editpayment',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $fid,
                'paymentdate': $('input[name=paymentdate]').val(),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'amount': $('input[name=amount]').val(),
                'checknum': $('input[name=checknum]').val(),
                'curr': $('#curr option:selected').attr("value"),
                'amountfor': $('#amountfor option:selected').attr("value"),
                'paymentstatus': $('#paymentstatus option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_paymentdate').remove()
                    $('#err_details_paymenttype').remove()
                    $('#err_details_amount').remove()
                    $('#err_details_curr').remove()
                    $('#err_details_amountfor').remove()
                    $('#err_details_paymentstatus').remove()
                    getpayments($('#client_id').val());
                    getsum();
                    clearpayment();
                }
            }
        });
    }
});

function clearpayment(){
    $('#err_details_paymentdate').hide()
    $('#err_details_paymenttype').hide()
    $('#err_details_amount').hide()
    $('#err_details_curr').hide()
    $('#err_details_amountfor').hide()
    $('#err_details_paymentstatus').hide()

    $('#paymenttype').val('').trigger('change');
    $('#amountfor').val('').trigger('change');
    $('#paymentstatus').val('').trigger('change');
    $("#paymentdate").val('');
    $("#checknum").val('-');
    $('#amount').val('0');
    $('#curr').val('').trigger('change');
    $('#cflag').val('0');
    $('#savepayment').text("حفظ البيانات");
}

function getsum(){
    var totaldep = 0;
    var totalamount = 0;
    var totalreceived = 0;
    var totalremain = 0;

    $("#tablecontract tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(3)").html();
        var stval = parseFloat(value);
        totaldep += isNaN(stval) ? 0 : stval;
    });
    // console.log(totaldep);
    $("#totaldeposits").val(totaldep);

    $("#tablecontract tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(6)").html();
        var stval = parseFloat(value);
        totalamount += isNaN(stval) ? 0 : stval;
    });
    // console.log(totalamount);
    $("#totalamounts").val(totalamount);

    $("#tablepayments tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(6)").html();
        var stval = parseFloat(value);
        totalreceived += isNaN(stval) ? 0 : stval;
    });
    // console.log(totalreceived);
    $("#totalreceived").val(totalreceived);

    totalremain = totalamount - totalreceived;
    $("#totalremain").val(totalremain);

}

function getsumpayments(){
    $("#tablepayments tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(6)").html();
        var stval = parseFloat(value);
        totalreceived += isNaN(stval) ? 0 : stval;
    });
    // console.log(totalreceived);
    $("#totalreceived").val(totalreceived);
}

function getpayments(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getpaymentslist',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'clientid' : ccid
        },
        dataType:'json',
        success: function(data){
            // console.log(data.length)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    // console.log(val[0]);
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#tablepayments').html(data.payment_data);
                getsum();
                if(data.rflagpayment == "1"){
                    document.getElementById("noresultpayment").style.display = "none";
                }
            }
        },
    });
}

function go(a, b, e, elt) {


    var $parent_form = $('#' + e).closest('.form-group');
    var parent_id = $parent_form.attr('data-label');

    // console.log($parent_form);

    $.ajax({
        type: "POST",
        url: $("#def_quick_add").val(),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            tid: parent_id,
            description: b,
        },
        beforeSend: function () {
            $(a).html('جاري التنفيذ .....');
        },
    }).done(function (data) {
        // console.log(data.id + ' , ' + b);
        $parent_form.children('select').append("<option value='" + data.id + "'>" + b + "</option>")
        $parent_form.children('select').select2("destroy");
        $parent_form.children('select').select2();
        $parent_form.children('select').select2("val", data.id);
        $parent_form.children('select').select2("close");
        $parent_form.children('select').select2("close");
        $(a).html('<i class="fa fa-plus-circle"></i> أضافة جديدة');
    });

}

$(document).on('change', '#paymenttype', function(){
    $typeval = $('#paymenttype option:selected').attr("value");
    if($typeval == "1"){
        $("#checknum").val('-');
    }else if($typeval == "3"){
        $("#checknum").val('-');
    }
});

// $('#myModal.select2').select2();

