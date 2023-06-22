$(document).ready(function () {

    $(".selectpaymenttype").select2({
        placeholder: "إختر طريقة الدفع",
        allowClear: true
    });

    $(".selectcurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectfollowby").select2({
        placeholder: "إختر إسم معقب المعاملة",
        allowClear: true
    });

    $(".selectbrokername").select2({
        placeholder: "إختر إسم الوسيط",
        allowClear: true
    });

    $(".selectbanks").select2({
        placeholder: "إختر إسم البنك",
        allowClear: true
    });

    $(".selectamountfor").select2({
        placeholder: "إختر نوع الدفعة",
        allowClear: true
    });

    $(".selectfromaccount").select2({
        placeholder: "إختر نوع الحساب",
        allowClear: true
    });

    // $(".selectpaymentstatus").select2({
    //     placeholder: "إخنر نوع عملية الدفع",
    //     allowClear: true
    // });
    document.getElementById("discount").disabled = true;
    // console.log($('#client_id').val())

    var now = new Date();
    var month = (now.getMonth() + 1);
    var day = now.getDate();
    if (month < 10)
        month = "0" + month;
    if (day < 10)
        day = "0" + day;
    var today = now.getFullYear() + '-' + month + '-' + day;
    $('#fromdate').val(today);
    $('#todate').val(today);


    var now1 = new Date();
    var month1 = (now1.getMonth() + 1);
    var day1 = now1.getDate();
    if (month1 < 10)
        month1 = "0" + month1;
    if (day1 < 10)
        day1 = "0" + day1;
    var today1 = now1.getFullYear() + '-' + month1 + '-' + day1;
    $('#checkdate').val(today1);

    document.getElementById("banks-div").hidden = true;
    document.getElementById("banks-lbl").hidden = true;
    document.getElementById("checkdate").hidden = true;
    document.getElementById("checkdate-lbl").hidden = true;
    document.getElementById("checknum").hidden = true;
    document.getElementById("checknum-lbl").hidden = true;

    fetch_contract_data();
    fetch_contract_data_payment_usd();
    fetch_contract_data_payment_lbp();

    fetch_payments_data();
    fetch_data_payment_usd();
    fetch_data_payment_lbp();
    //
    // getpayments($('#client_id').val());

    // getsum();
});

$('#tablepayments').on('click', '.edit-btn-payment', function(){
    clearpayment();
    $('#cflag').val('1');
    $('#payment_id').val($(this).data('id'));
    $('#savepayment').text("تعديل البيانات");
    $('#paymentdate').val($(this).data('paydate'));
    $('#checkdate').val($(this).data('paycheckdate'));
    $('#paymenttype').select2('data', {id: $(this).data('paytypeid'), a_key: $(this).data('paytype')}).change();
    $('#banks').select2('data', {id: $(this).data('paybankid'), a_key: $(this).data('paybankname')}).change();
    $('#checkdiscount').prop("checked", $(this).data('checkdiscount') == '1');
    if ($('input[name=checkdiscount]').prop('checked')){
        document.getElementById("discount").disabled = false;
    }else{
        document.getElementById("discount").disabled = true;
    }
    $('#amount').val($(this).data('payamount'));
    $('#discount').val($(this).data('discount'));
    $('#dueamount').val($(this).data('dueamount'));
    $('#contid').val($(this).data('contid'));
    $('#ccode').val($(this).data('ccode'));
    $('#brokerid').val($(this).data('broker'));
    $('#followbyid').val($(this).data('followby'));
    $('#checknum').val($(this).data('paychecknum'));
    $('#curr').select2('data', {id: $(this).data('paycurrid'), a_key: $(this).data('paycurr')}).change();
    $('#fromaccount').select2('data', {id: $(this).data('payfromaccountid'), a_key: $(this).data('payfromaccount') + ' - ' + $(this).data('payfromaccounttype')}).change();
    $('#amountfor').select2('data', {id: $(this).data('payamountforid'), a_key: $(this).data('payamountfor')}).change();
    document.getElementById('pdetails').value =$(this).data('paydetails');
    // $('#paymentstatus').select2('data', {id: $(this).data('paystatusid'), a_key: $(this).data('paystatus')}).change();
});

$('#tablepayments').on('click', '.delete-btn-payment', function () {
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
                            fetch_payments_data();
                            fetch_data_payment_usd();
                            fetch_data_payment_lbp();
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
    if ($('input[name=checkdiscount]').prop('checked')){
        $chk_discount = "1";
    }else{
        $chk_discount = "0";
    }
    if (cflag == "0") {
        // console.log($('#client_id').val());
        $.ajax({
            type: 'POST',
            url: '/storepayment',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'person': $('#client_id').val(),
                'paymentdate': $('input[name=paymentdate]').val(),
                'checkdate': $('input[name=checkdate]').val(),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'checkdiscount': $chk_discount,
                'amount': $('input[name=amount]').val(),
                'discount': $('input[name=discount]').val(),
                'dueamount': $('input[name=dueamount]').val(),
                'contid': $('input[name=contid]').val(),
                'ccode': $('input[name=ccode]').val(),
                'brokerid': $('input[name=brokerid]').val(),
                'followbyid': $('input[name=followbyid]').val(),
                'checknum': $('input[name=checknum]').val(),
                'curr': $('#curr option:selected').attr("value"),
                'amountfor': $('#amountfor option:selected').attr("value"),
                'bank': $('#banks option:selected').attr("value"),
                'fromaccount': $('#fromaccount option:selected').attr("value"),
                'pdetails': document.getElementById('pdetails').value,
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_paymentdate').remove()
                    $('#err_details_checkdate').remove()
                    $('#err_details_paymenttype').remove()
                    $('#err_details_amount').remove()
                    $('#err_details_discount').remove()
                    $('#err_details_dueamount').remove()
                    $('#err_details_contid').remove()
                    $('#err_details_ccode').remove()
                    $('#err_details_curr').remove()
                    $('#err_details_amountfor').remove()
                    $('#err_details_bank').remove()
                    $('#err_details_fromaccount').remove()
                    $('#err_details_pdetails').remove()

                    fetch_payments_data();
                    fetch_data_payment_usd();
                    fetch_data_payment_lbp();
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
                'checkdate': $('input[name=checkdate]').val(),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'checkdiscount': $chk_discount,
                'amount': $('input[name=amount]').val(),
                'discount': $('input[name=discount]').val(),
                'dueamount': $('input[name=dueamount]').val(),
                'contid': $('input[name=contid]').val(),
                'ccode': $('input[name=ccode]').val(),
                'brokerid': $('input[name=brokerid]').val(),
                'followbyid': $('input[name=followbyid]').val(),
                'checknum': $('input[name=checknum]').val(),
                'curr': $('#curr option:selected').attr("value"),
                'amountfor': $('#amountfor option:selected').attr("value"),
                'bank': $('#banks option:selected').attr("value"),
                'fromaccount': $('#fromaccount option:selected').attr("value"),
                'pdetails': document.getElementById('pdetails').value,
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_paymentdate').remove()
                    $('#err_details_checkdate').remove()
                    $('#err_details_paymenttype').remove()
                    $('#err_details_amount').remove()
                    $('#err_details_discount').remove()
                    $('#err_details_dueamount').remove()
                    $('#err_details_contid').remove()
                    $('#err_details_ccode').remove()
                    $('#err_details_curr').remove()
                    $('#err_details_amountfor').remove()
                    $('#err_details_bank').remove()
                    $('#err_details_fromaccount').remove()
                    $('#err_details_pdetails').remove()

                    fetch_payments_data();
                    fetch_data_payment_usd();
                    fetch_data_payment_lbp();
                    clearpayment();
                }
            }
        });
    }
});

$(document).on('change', '#paymenttype', function(){
    var stext = $('#paymenttype option:selected').attr("value");
    if(stext == "22"){
        document.getElementById("banks-div").hidden = false;
        document.getElementById("banks-lbl").hidden = false;
        document.getElementById("checkdate").hidden = false;
        document.getElementById("checkdate-lbl").hidden = false;
        document.getElementById("checknum").hidden = false;
        document.getElementById("checknum-lbl").hidden = false;
    }else if(stext == ""){
        document.getElementById("banks-div").hidden = true;
        document.getElementById("banks-lbl").hidden = true;
        document.getElementById("checkdate").hidden = true;
        document.getElementById("checkdate-lbl").hidden = true;
        document.getElementById("checknum").hidden = true;
        document.getElementById("checknum-lbl").hidden = true;
        $('#banks').val('1').trigger('change');
        $("#checknum").val('-');
    }else{
        document.getElementById("banks-div").hidden = true;
        document.getElementById("banks-lbl").hidden = true;
        document.getElementById("checkdate").hidden = true;
        document.getElementById("checkdate-lbl").hidden = true;
        document.getElementById("checknum").hidden = true;
        document.getElementById("checknum-lbl").hidden = true;
        $('#banks').val('1').trigger('change');
        $("#checknum").val('-');
    }
});

function clearpayment(){

    var now = new Date();
    var month = (now.getMonth() + 1);
    var day = now.getDate();
    if (month < 10)
        month = "0" + month;
    if (day < 10)
        day = "0" + day;
    var today = now.getFullYear() + '-' + month + '-' + day;
    $('#checkdate').val(today);

    $('#err_details_paymentdate').hide()
    $('#err_details_checkdate').hide()
    $('#err_details_paymenttype').hide()
    $('#err_details_amount').hide()
    $('#err_details_discount').hide()
    $('#err_details_dueamount').hide()
    $('#err_details_contid').hide()
    $('#err_details_ccode').hide()
    $('#err_details_curr').hide()
    $('#err_details_amountfor').hide()
    $('#err_details_bank').hide()
    $('#err_details_fromaccount').hide()
    $('#err_details_pdetails').hide()
    // $('#err_details_paymentstatus').hide()

    $('#paymenttype').val('').trigger('change');
    $('#amountfor').val('').trigger('change');
    $('#banks').val('1').trigger('change');
    $('#fromaccount').val('').trigger('change');
    // $('#paymentstatus').val('').trigger('change');
    $("#paymentdate").val('');
    // $("#checkdate").val('');
    document.getElementById('pdetails').value = '';
    $("#checknum").val('-');
    document.getElementById("checkdiscount").checked = false;
    $('#amount').val('0');
    $('#discount').val('0');
    document.getElementById("discount").disabled = true;
    $('#dueamount').val('0');
    $('#contid').val('');
    $('#ccode').val('');
    $('#brokerid').val('');
    $('#followbyid').val('');
    $('#curr').val('').trigger('change');
    $('#cflag').val('0');
    $('#savepayment').text("حفظ البيانات");
    // $('#followby').val('').trigger('change');
    // $('#brokername').val('').trigger('change');
}

$(document).on('change', '#checkdiscount', function(){
    if ($('input[name=checkdiscount]').prop('checked')){
        document.getElementById("discount").disabled = false;
    }else{
        $('#discount').val('0');
        $('#dueamount').val( $('#amount').val());
        document.getElementById("discount").disabled = true;
    }
});

$(document).on('change', '#discount', function(){
    caldiscount();
});

$(document).on('change', '#amount', function(){
    $('#dueamount').val( $('#amount').val());
});

function caldiscount(){
    $sum = 0;
    let ramount = parseFloat($('#amount').val());
    let rdiscount = parseFloat($('#discount').val());
    $sum = ramount - rdiscount;
    $('#dueamount').val($sum);
}

function getsum(){
    var totaldep = 0;
    var totalamount = 0;
    var totalreceived = 0;
    var totalremain = 0;


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

function openclientsprintout() {
        // console.log($("#billedvalue").val());
        let cid = $('#client_id').val();
        let sqlrtr = $("#billedvalue").val();
        let filtervalue = $("#filterbyvalue").val();
        let fdates = $('#fromdate').val()+'_'+$('#todate').val();

        let cbofollowby = $('#followby option:selected').attr("value")+'_'+$('#followby option:selected').text();
        let cbobroker = $('#brokername option:selected').attr("value")+'_'+$('#brokername option:selected').text();

        let followbyid = $('#followby option:selected').attr("value");
        let followbyname = $('#followby option:selected').text();
        let brokerid = $('#brokername option:selected').attr("value");
        let brokername = $('#brokername option:selected').text();

        if(filtervalue == 0){
            if(sqlrtr == "") {
                // console.log("no option");
                window.open(
                    $("#clientsrouteid").val() + '/' + cid + '/' + fdates, "_blank");
            }else{
                // console.log("with option");
                window.open(
                    $("#clientsrouteidopt").val() + '/' + cid + '/' + sqlrtr+ '/' + fdates, "_blank");
            }
        }else if(filtervalue == 1){
            if(sqlrtr == "") {
                // console.log("no option");
                window.open(
                    $("#bclientsrouteid").val() + '/' + cid + '/' + cbofollowby + '/' + filtervalue + '/' + fdates, "_blank");
            }else{
                // console.log("with option");
                window.open(
                    $("#bclientsrouteidopt").val() + '/' + cid + '/' + sqlrtr + '/' + cbofollowby + '/' + filtervalue + '/' + fdates, "_blank");
            }
        }else if(filtervalue == 2){
            if(sqlrtr == "") {
                // console.log("no option");
                window.open(
                    $("#bclientsrouteid").val() + '/' + cid + '/' + cbobroker + '/' + filtervalue+ '/' + fdates, "_blank");
            }else{
                // console.log("with option");
                window.open(
                    $("#bclientsrouteidopt").val() + '/' + cid + '/' + sqlrtr + '/' + cbobroker + '/' + filtervalue + '/' + fdates, "_blank");
            }
        }

}

function openclientspaymentsprintout() {
        let cid = $('#client_id').val();
        let filtervalue = $("#filterbyvalue").val();
        let fdates = $('#fromdate').val()+'_'+$('#todate').val();

        let cbofollowby = $('#followby option:selected').attr("value")+'_'+$('#followby option:selected').text();
        let cbobroker = $('#brokername option:selected').attr("value")+'_'+$('#brokername option:selected').text();

        let followbyid = $('#followby option:selected').attr("value");
        let followbyname = $('#followby option:selected').text();
        let brokerid = $('#brokername option:selected').attr("value");
        let brokername = $('#brokername option:selected').text();

        if(filtervalue == 0) {
            window.open(
                $("#clientsrouteidpayments").val() + '/' + cid + '/' + fdates, "_blank");
        }else if(filtervalue == 1) {
            window.open(
                $("#bclientsrouteidpayments").val() + '/' + cid + '/' + cbofollowby + '/' + filtervalue + '/' + fdates, "_blank");
        }else if(filtervalue == 2) {
            window.open(
                $("#bclientsrouteidpayments").val() + '/' + cid + '/' + cbobroker + '/' + filtervalue + '/' + fdates, "_blank");
        }
}

$(document).on('click', '#allfilterby', function(){
    $("#filterbyvalue").val($(this).attr('data-id'));
});

$(document).on('click', '#filterbyfollowby', function(){
    $("#filterbyvalue").val($(this).attr('data-id'));
});

$(document).on('click', '#filterbybroker', function(){
    $("#filterbyvalue").val($(this).attr('data-id'));
});

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

// $(document).on('change', '#paymenttype', function(){
//     $typeval = $('#paymenttype option:selected').attr("value");
//     if($typeval == "1"){
//         $("#checknum").val('-');
//     }else if($typeval == "3"){
//         $("#checknum").val('-');
//     }
// });

function checkcontid(contid=''){
    var $fid = contid
    $.ajax({
        type: 'POST',
        url: '/checkcontpayments',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contid': $fid,
            'flag':''
        },
        success: function(data){
            // console.log(data.flag);
            if(data.flag == "0") {
                // $('.corrows' + $('.id').text()).remove();
            }else if(data.flag == "1"){
                var str = $("#ccode").val();
                $("#cont_duplicate_modal_body").html(str);
                $('#duplicatecontractModal').modal('show');
            }
        }
    });
}

function fetch_contract_data(sqlstr = '',fromdate = '',todate = '')
{
    let cid = $('#client_id').val();
    let followby = $('#followby option:selected').attr("value");
    let brokername = $('#brokername option:selected').attr("value");

    $('#tablecontract').DataTable({
        // "footerCallback": function ( row, data, start, end, display ) {
        //     var api = this.api();
        //
        //     // Remove the formatting to get integer data for summation
        //     var intVal = function ( i ) {
        //         return typeof i === 'string' ?
        //             i.replace(/[\$,]/g, '')*1 :
        //             typeof i === 'number' ?
        //                 i : 0;
        //     };
        //
        //     // Total over all pages
        //     rectotal = api
        //         .column( 5 )
        //         .data()
        //         .reduce( function (a, b) {
        //             return intVal(a) + intVal(b);
        //         }, 0 );
        //
        //     // Total over this page
        //     pageTotal = api
        //         .column( 5, { page: 'current'} )
        //         .data()
        //         .reduce( function (a, b) {
        //             return intVal(a) + intVal(b);
        //         }, 0 );
        //
        //     // Update footer
        //     // $( api.column( 6 ).footer() ).html(
        //     //     '$'+pageTotal +' ( $'+ total +' total)'
        //     // );
        //     $( api.column( 6 ).footer() ).html(
        //         $("#total_bills").val() +' : '+ rectotal + ' USD '
        //          // $("#totalamounts").val(total)
        //     );
        //     $("#totalamounts").val(rectotal)
        // },
        // processing: true,
        order: [[ 1, "asc" ]],
        pageLength: 5,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        // serverSide: true,
        bDestroy: true,
        "language" :{
            "decimal":        "",
            "emptyTable":     "لا توجد بيانات متوفرة لعرضها في الجدول",
            "info":            "عرض المدخلات _START_ الى _END_ , من أصل _TOTAL_ إجمالي المدخلات",
            "infoEmpty":      "العدد الاجمالي : 0",
            "infoFiltered":   "",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "أظهر _MENU_ إدخالات",
            "loadingRecords": "جار التحميل ...",
            "processing":     "جار المعالجة ...",
            "search":         "إبحث : ",
            "zeroRecords":    "لم يتم العثور على أي بيانات مطابقة لعملية البحث",
            "paginate": {
                "first":      "الاول",
                "last":       "الاخير",
                "next":       "التالي",
                "previous":   "السابق"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax : {
            url:'/getcontractinslist',
            Type:'GET',
            data:{
                cid:cid,
                sqlstr:sqlstr,
                followby:followby,
                brokername:brokername,
                fromdate:fromdate,
                todate:todate
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'billid', name: 'billid',visible:false},
            {data: 'billstatus', name: 'action', orderable: false,"width": "100px"},
            {data: 'ccode', name: 'action', orderable: false,"width": "100px"},
            {data: 'insname', name: 'insname'},
            {data: 'totalcost', name: 'totalcost'},
            {data: 'currname', name: 'currname',"width": "80px"},
            {data: 'insaction', name: 'action', orderable: false, searchable: false}
        ]
    });
}

function fetch_contract_data_payment_usd(sqlstr = '',fromdate = '',todate = '') {
    let cid = $('#client_id').val();
    let followby = $('#followby option:selected').attr("value");
    let brokername = $('#brokername option:selected').attr("value");
    $.ajax({
        type: 'GET',
        url: '/getcontractlistpayment_usd',
        data: {
            cid: cid,
            sqlstr: sqlstr,
            ramount:'',
            rcurr:'',
            followby:followby,
            brokername:brokername,
            fromdate:fromdate,
            todate:todate
        },
        success: function (data) {
            if (data.errors) {
                $.each(data.errors, function (key, value) {
                    alert(value);
                });
            } else {
                // console.log(data.ramount);
                // console.log(sqlstr);
                document.getElementById("trusd").innerText =  $("#total_bills_usd").val() + ' : '+ data.ramount + ' ' + data.rcurr;
            }
        }
    });

}

function fetch_contract_data_payment_lbp(sqlstr = '',fromdate = '',todate = '') {
    let cid = $('#client_id').val();
    let followby = $('#followby option:selected').attr("value");
    let brokername = $('#brokername option:selected').attr("value");
    $.ajax({
        type: 'GET',
        url: '/getcontractlistpayment_lbp',
        data: {
            cid: cid,
            sqlstr: sqlstr,
            ramount:'',
            rcurr:'',
            followby:followby,
            brokername:brokername,
            fromdate:fromdate,
            todate:todate
        },
        success: function (data) {
            if (data.errors) {
                $.each(data.errors, function (key, value) {
                    alert(value);
                });
            } else {
                // console.log(data.ramount);
                // console.log(sqlstr);
                document.getElementById("trlbp").innerText = $("#total_bills_lbp").val() + ' : '+ data.ramount + ' ' + data.rcurr;
            }
        }
    });

}

function fetch_payments_data(fromdate = '',todate = '')
{
    let cid = $('#client_id').val();
    let followby = $('#followby option:selected').attr("value");
    let brokername = $('#brokername option:selected').attr("value");
    $('#tablepayments').DataTable({
        // processing: true,
        order: [[ 3, "desc" ]],
        pageLength: 5,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        // serverSide: true,
        autoWidth: false,
        bDestroy: true,
        "language" :{
            "decimal":        "",
            "emptyTable":     "لا توجد بيانات متوفرة لعرضها في الجدول",
            "info":            "عرض المدخلات _START_ الى _END_ , من أصل _TOTAL_ إجمالي المدخلات",
            "infoEmpty":      "العدد الاجمالي : 0",
            "infoFiltered":   "",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "أظهر _MENU_ إدخالات",
            "loadingRecords": "جار التحميل ...",
            "processing":     "جار المعالجة ...",
            "search":         "إبحث : ",
            "zeroRecords":    "لم يتم العثور على أي بيانات مطابقة لعملية البحث",
            "paginate": {
                "first":      "الاول",
                "last":       "الاخير",
                "next":       "التالي",
                "previous":   "السابق"
            },
            "aria": {
                "sortAscending":  ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        },
        ajax : {
            url:'/getpaymentslist',
            Type:'GET',
            data:{
                cid:cid,
                followby:followby,
                brokername:brokername,
                fromdate:fromdate,
                todate:todate
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'payactions', name: 'action', orderable: false, searchable: false},
            {data: 'receipt', name: 'receipt'},
            {data: 'paydate', name: 'paydate'},
            {data: 'payamount', name: 'payamount'},
            // {data: 'payfor', name: 'payfor'},
            // {data: 'paytype', name: 'paytype'},
            // {data: 'accounttype', name: 'accounttype'}
        ]
    });
}

function fetch_data_payment_usd(fromdate = '',todate = '') {
    let cid = $('#client_id').val();
    let followby = $('#followby option:selected').attr("value");
    let brokername = $('#brokername option:selected').attr("value");
    $.ajax({
        type: 'GET',
        url: '/getpayments_usd',
        data: {
            cid: cid,
            ramount:'',
            rcurr:'',
            followby:followby,
            brokername:brokername,
            fromdate:fromdate,
            todate:todate
        },
        success: function (data) {
            if (data.errors) {
                $.each(data.errors, function (key, value) {
                    alert(value);
                });
            } else {
                // console.log(data.ramount);
                // console.log(sqlstr);
                document.getElementById("trpusd").innerText =  $("#total_bills_usd").val() + ' : '+ data.ramount + ' ' + data.rcurr;
            }
        }
    });

}

function fetch_data_payment_lbp(fromdate = '',todate = '') {
    let cid = $('#client_id').val();
    let followby = $('#followby option:selected').attr("value");
    let brokername = $('#brokername option:selected').attr("value");
    $.ajax({
        type: 'GET',
        url: '/getpayments_lbp',
        data: {
            cid: cid,
            ramount:'',
            rcurr:'',
            followby:followby,
            brokername:brokername,
            fromdate:fromdate,
            todate:todate
        },
        success: function (data) {
            if (data.errors) {
                $.each(data.errors, function (key, value) {
                    alert(value);
                });
            } else {
                // console.log(data.ramount);
                // console.log(sqlstr);
                document.getElementById("trplbp").innerText =  $("#total_bills_lbp").val() + ' : '+ data.ramount + ' ' + data.rcurr;
            }
        }
    });

}


$(document).on('click', '#allbills', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    fetch_contract_data(sqlrtr,$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_usd(sqlrtr,$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_lbp(sqlrtr,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#billsclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    fetch_contract_data(sqlrtr,$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_usd(sqlrtr,$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_lbp(sqlrtr,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#billsnotclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    fetch_contract_data(sqlrtr,$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_usd(sqlrtr,$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_lbp(sqlrtr,$('#fromdate').val(),$('#todate').val());
});

$('#tablecontract').on('click', '.btn-sts', function () {
    let $pid = $(this).attr('data-id');
    let $sts = $(this).attr('data-to');
    // console.log($pid);
    // console.log($sts);
    // console.log($("#change_status_booking").val());
    $.ajax({
        type: 'POST',
        url: $("#change_status_billing").val(),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            bid: $pid,
            sts: $sts
        },
        success: function (data) {
            if (data.errors) {
                $.each(data.errors, function (key, value) {
                    alert(value);
                });
            } else {
                // $('#table').ajax.reload();
                // $('#table').ajax.reload(null, false );
                fetch_contract_data();
                fetch_contract_data_payment_usd();
                fetch_contract_data_payment_lbp();
            }
        }
    });
});

$('#tablecontract').on('click', '.btn-code', function () {
    let $str = $(this).attr('data-id');
    let $ctid = $(this).attr('data-contid');
    let $sts = $(this).attr('data-to');

    // console.log($str & " " & $ctid);

    document.getElementById('contid').value = $ctid;
    checkcontid($ctid);
    document.getElementById('ccode').value = $str;
    document.getElementById('brokerid').value = $(this).attr('data-brokerid');
    document.getElementById('followbyid').value = $(this).attr('data-followby');

    var TextSearch = document.getElementById("pdetails").value;

    if ($str.length > 0 && TextSearch.indexOf($str) > -1) {

    } else {
        var stext = $('#amountfor option:selected').text() + " , ";
        document.getElementById('pdetails').value = stext + '\r\n' + $str;
        // document.getElementById('pdetails').value += $str + '\r\n';
        // document.getElementById('pdetails').value = $str + '\r\n';
    }

    // document.getElementById('pdetails').textContent += $str;


    // var myText = document.getElementById("myText");
    // var s = myText.value; // This will now contain text of textarea
});

$(document).on('change', '#amountfor', function(){
    var stext = $('#amountfor option:selected').text() + " , ";
    document.getElementById('pdetails').value = stext + '\r\n';
    // document.getElementById('pdetails').value = $("#billfor").val() + stext + '\r\n';
});

$(document).on('click', '#clientssearchby', function(){
    document.getElementById("allbills").checked = true;
    $("#billedvalue").val("");
    fetch_contract_data('',$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_usd('',$('#fromdate').val(),$('#todate').val());
    fetch_contract_data_payment_lbp('',$('#fromdate').val(),$('#todate').val());

    fetch_payments_data($('#fromdate').val(),$('#todate').val());
    fetch_data_payment_usd($('#fromdate').val(),$('#todate').val());
    fetch_data_payment_lbp($('#fromdate').val(),$('#todate').val());
});
