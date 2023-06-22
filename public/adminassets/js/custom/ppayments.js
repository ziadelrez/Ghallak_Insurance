$(document).ready(function () {

    $(".selectpaymenttype").select2({
        placeholder: "إختر طريقة الدفع",
        allowClear: true
    });

    $(".selectcurr").select2({
        placeholder: "إختر العملة",
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

    $(".selectpartners").select2({
        placeholder: "إختر نوع الشريك",
        allowClear: true
    });

    $(".selectpartnersname").select2({
        placeholder: "إختر إسم الشريك",
        allowClear: true
    });

    // $(".selectpaymentstatus").select2({
    //     placeholder: "إخنر نوع عملية الدفع",
    //     allowClear: true
    // });

    // console.log($('#client_id').val())

    // fetch_contract_data();
    //
    // fetch_payments_data();
    //
    // getpayments($('#client_id').val());

    // getsum();

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

    // let cid = $('#partnersname option:selected').attr("value");
    // let tbid = $('#tbname').val();
    // let sqlrtr = $("#billedvalue").val();
    // document.getElementById("printstatements").innerHTML='<a href="'+$("#routeid").val()+'/'+cid+'/'+tbid+'/'+sqlrtr+'">launch</a>';

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

$('#tablepayments').on('click', '.edit-btn-payment', function(){
    clearpayment();
    $('#cflag').val('1');
    $('#payment_id').val($(this).data('id'));
    $('#savepayment').text("تعديل البيانات");
    $('#paymentdate').val($(this).data('paydate'));
    $('#checkdate').val($(this).data('paycheckdate'));
    $('#paymenttype').select2('data', {id: $(this).data('paytypeid'), a_key: $(this).data('paytype')}).change();
    $('#banks').select2('data', {id: $(this).data('paybankid'), a_key: $(this).data('paybankname')}).change();
    $('#amount').val($(this).data('payamount'));
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
                    url: '/pdeletepayment',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            fetch_payments_data($('#fromdate').val(),$('#todate').val());
                            fetch_data_payment_usd($('#fromdate').val(),$('#todate').val());
                            fetch_data_payment_lbp($('#fromdate').val(),$('#todate').val());
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
            url: '/pstorepayment',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'person': $('#partnersname option:selected').attr("value"),
                'tbid' : $('#tbname').val(),
                'paymentdate': $('input[name=paymentdate]').val(),
                'checkdate': $('input[name=checkdate]').val(),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'amount': $('input[name=amount]').val(),
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
                    $('#err_details_curr').remove()
                    $('#err_details_amountfor').remove()
                    $('#err_details_bank').remove()
                    $('#err_details_fromaccount').remove()
                    $('#err_details_pdetails').remove()

                    fetch_payments_data($('#fromdate').val(),$('#todate').val());
                    fetch_data_payment_usd($('#fromdate').val(),$('#todate').val());
                    fetch_data_payment_lbp($('#fromdate').val(),$('#todate').val());
                    clearpayment();
                }
            }
        });
    }else if (cflag == "1") {
        // console.log($('input[name=payment_id]').val());
        var $fid = $('#payment_id').val();
        $.ajax({
            type: 'POST',
            url: '/peditpayment',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $fid,
                'paymentdate': $('input[name=paymentdate]').val(),
                'checkdate': $('input[name=checkdate]').val(),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'amount': $('input[name=amount]').val(),
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
                    $('#err_details_curr').remove()
                    $('#err_details_amountfor').remove()
                    $('#err_details_bank').remove()
                    $('#err_details_fromaccount').remove()
                    $('#err_details_pdetails').remove()

                    fetch_payments_data($('#fromdate').val(),$('#todate').val());
                    fetch_data_payment_usd($('#fromdate').val(),$('#todate').val());
                    fetch_data_payment_lbp($('#fromdate').val(),$('#todate').val());
                    clearpayment();
                }
            }
        });
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
    document.getElementById('pdetails').value = '';
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

function getsumamounts(){
    var totalamount = 0;


    $("#tablecontract tbody tr").each(function() {
        var value = $(this).find(" td:nth-child(5)").html();
        var stval = parseFloat(value);
        totalamount += isNaN(stval) ? 0 : stval;
        // console.log(value);
    });

    $("#totalamounts").val(totalamount);

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
//     }else{
//         $("#checknum").val('');
//     }
// });

// $(document).on('change', '#partnersname', function(){

$(document).on('click', '#searchpayments', function(){
    document.getElementById("allbills").checked = true;
    $("#billedvalue").val("");
    if(document.getElementById("partnersname").selectedIndex > 0){
        // console.log("ziad");
        // document.getElementById("allbills").checked = true;
        // $("#allbills").attr("checked","checked");
        fetch_contract_data('',$('#fromdate').val(),$('#todate').val());
        fetch_contract_data_payment_usd('',$('#fromdate').val(),$('#todate').val());
        fetch_contract_data_payment_lbp('',$('#fromdate').val(),$('#todate').val());
        fetch_payments_data($('#fromdate').val(),$('#todate').val());
        fetch_data_payment_usd($('#fromdate').val(),$('#todate').val());
        fetch_data_payment_lbp($('#fromdate').val(),$('#todate').val());
    }
});

// $(document).on('click', '#printstatements', function(){
//     if(document.getElementById("partnersname").selectedIndex > 0){
//         console.log("ziad");
//         let cid = $('#partnersname option:selected').attr("value");
//         let tbid = $('#tbname').val();
//         let sqlrtr = $("#billedvalue").val();
//         document.getElementById("printstatements").innerHTML='<a href="'+$("#routeid").val()+'/'+cid+'/'+tbid+'/'+sqlrtr+'">launch</a>';
//     }
// });

function openprintout() {
    if(document.getElementById("partners").selectedIndex > 0){
        let partnertype = $('#partners option:selected').attr("value");
        // console.log(partnertype);
        if(partnertype < "4"){
            if(document.getElementById("partnersname").selectedIndex > 0){
                // console.log($("#billedvalue").val());
                let cid = $('#partnersname option:selected').attr("value");
                let tbid = $('#tbname').val();
                let sqlrtr = $("#billedvalue").val();
                let fdates = $('#fromdate').val()+'_'+$('#todate').val();
                if(sqlrtr == "") {
                    // console.log("no option");
                    window.open(
                        $("#routeid").val() + '/' + cid + '/' + tbid + '/' + fdates, "_blank");
                }else{
                    // console.log("with option");
                    window.open(
                        $("#routeidopt").val() + '/' + cid + '/' + tbid + '/' + sqlrtr + '/' + fdates, "_blank");
                }
            }
        }else{
            // console.log("this garage");
            if(document.getElementById("partnersname").selectedIndex > 0){
                // console.log($("#billedvalue").val());
                let cid = $('#partnersname option:selected').attr("value");
                let tbid = $('#tbname').val();
                let sqlrtr = $("#billedvalue").val();
                let fdates = $('#fromdate').val()+'_'+$('#todate').val();
                if(sqlrtr == "") {
                    // console.log("no option");
                    window.open(
                        $("#routeid").val() + '/' + cid + '/' + tbid + '/' + fdates, "_blank");
                }else{
                    // console.log("with option");
                    window.open(
                        $("#routeidopt").val() + '/' + cid + '/' + tbid + '/' + sqlrtr + '/' + fdates, "_blank");
                }
            }
            // if(document.getElementById("partnersname").selectedIndex > 0){
            //     // console.log($("#billedvalue").val());
            //     let cid = $('#partnersname option:selected').attr("value");
            //     let tbid = $('#tbname').val();
            //     let sqlrtr = $("#billedvalue").val();
            //     let fdates = $('#fromdate').val()+'_'+$('#todate').val();
            //     if(sqlrtr == "") {
            //         // console.log("no option");
            //         window.open(
            //             $("#routeid").val() + '/' + cid + '/' + tbid + '/' + fdates, "_blank");
            //     }else{
            //         // console.log("with option");
            //         window.open(
            //             $("#routeidopt").val() + '/' + cid + '/' + tbid + '/' + sqlrtr + '/' + fdates, "_blank");
            //     }
            // }
        }

    }

}

function openpaymentsprintout() {
    if(document.getElementById("partners").selectedIndex > 0){
        let partnertype = $('#partners option:selected').attr("value");
        if(partnertype < "4"){
            if(document.getElementById("partnersname").selectedIndex > 0){
                // console.log($("#billedvalue").val());
                let cid = $('#partnersname option:selected').attr("value");
                let tbid = $('#tbname').val();
                let fdates = $('#fromdate').val()+'_'+$('#todate').val();
                window.open(
                    $("#routeidpayments").val() + '/' + cid + '/' + tbid + '/' + fdates, "_blank");
            }
        }else{
            if(document.getElementById("partnersname").selectedIndex > 0){
                // console.log($("#billedvalue").val());
                let cid = $('#partnersname option:selected').attr("value");
                let tbid = $('#tbname').val();
                let fdates = $('#fromdate').val()+'_'+$('#todate').val();
                window.open(
                    $("#routeidpayments").val() + '/' + cid + '/' + tbid + '/' + fdates, "_blank");
            }
        }
    }

}

$("#partnersname").on("change",function(){
    // fetch_contract_data();
    // fetch_payments_data();
});

function fetch_payments_data(fromdate = '',todate = '')
{
    let cid = $('#partnersname option:selected').attr("value");
    let tbid = $('#tbname').val();
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
            url:'/pgetpaymentslist',
            Type:'GET',
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                cid:cid,
                tbid:tbid,
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
        ]
    });
}

function fetch_data_payment_usd(fromdate = '',todate = '') {
    let cid = $('#partnersname option:selected').attr("value");
    let tbid = $('#tbname').val();
    $.ajax({
        type: 'GET',
        url: '/getpaymentslist_usd',
        data: {
            cid:cid,
            tbid:tbid,
            ramount:'',
            rcurr:'',
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
    let cid = $('#partnersname option:selected').attr("value");
    let tbid = $('#tbname').val();
    $.ajax({
        type: 'GET',
        url: '/getpaymentslist_lbp',
        data: {
            cid:cid,
            tbid:tbid,
            ramount:'',
            rcurr:'',
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

function fetch_contract_data(sqlstr = '',fromdate = '',todate = '')
{
    let cid = $('#partnersname option:selected').attr("value");
    let tbid = $('#tbname').val();
    $('#tablecontract').DataTable({
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
            url:'/getpartnerslist',
            Type:'GET',
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                cid:cid,
                tbid:tbid,
                sqlstr:sqlstr,
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
        ],
    });
}

function fetch_contract_data_payment_usd(sqlstr = '',fromdate = '',todate = '') {
    let cid = $('#partnersname option:selected').attr("value");
    let tbid = $('#tbname').val();
    $.ajax({
        type: 'GET',
        url: '/getpartnerslist_usd',
        data: {
            cid:cid,
            tbid:tbid,
            sqlstr: sqlstr,
            ramount:'',
            rcurr:'',
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
    let cid = $('#partnersname option:selected').attr("value");
    let tbid = $('#tbname').val();
    $.ajax({
        type: 'GET',
        url: '/getpartnerslist_lbp',
        data: {
            cid:cid,
            tbid:tbid,
            sqlstr: sqlstr,
            ramount:'',
            rcurr:'',
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
                document.getElementById("trlbp").innerText =  $("#total_bills_lbp").val() + ' : '+ data.ramount + ' ' + data.rcurr;
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
    let $tbid = $('#tbname').val();
    // console.log($pid);
    // console.log($sts);
    // console.log($("#change_status_booking").val());
    $.ajax({
        type: 'POST',
        url: $("#change_status_billing").val(),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            bid: $pid,
            tbid: $tbid,
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
                fetch_contract_data('',$('#fromdate').val(),$('#todate').val());
                fetch_contract_data_payment_usd('',$('#fromdate').val(),$('#todate').val());
                fetch_contract_data_payment_lbp('',$('#fromdate').val(),$('#todate').val());
            }
        }
    });
});

$('#tablecontract').on('click', '.btn-code', function () {
    let $str = $(this).attr('data-id');
    let $sts = $(this).attr('data-to');

    var TextSearch = document.getElementById("pdetails").value;

    if ($str.length > 0 && TextSearch.indexOf($str) > -1) {

    } else {
        document.getElementById('pdetails').value += $str + '\r\n';
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

$(document).on('change', '#partners', function(){
    // $('#partnersname').empty();
    // $('#partnersname option:selected').remove();
    // $('#fromaccount').empty();

    if(document.getElementById("partners").selectedIndex <= 0){
        clearpayment();
        $('#partnersname').empty();
        $('#partnersname').append("<option></option>");
        // console.log("ziadeeeee");
        $('#partnersname').val('').trigger('change');
    }else {


        $idpartners = $('#partners option:selected').attr("value");
        $('#tbname').val($idpartners);

        // console.log($idpartners);
        // switch ($idpartners) {
        //     case "1":
        //         $('#tbname').val('0');
        //         break;
        // }


        $.ajax({
            type: 'POST',
            url: '/getpartnersname',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'idpartners': $idpartners,
                'id': '',
                'defname': '',
                'tid': '',
                'transtype': '',
                'type': '',
            },
            success: function (data) {
                if ((data.errors)) {
                    $('#partnersname').empty();
                    $('#fromaccount').empty();
                } else {
                    // $('#insname').empty();
                    clearpayment();
                    $('#partnersname').empty();
                    $('#partnersname').append("<option></option>");
                    var submenus = data.alist;
                    for (var i = 0; i < submenus.length; i++) {
                        $('#partnersname').append("<option value='" + submenus[i].id + "'>" + submenus[i].defname + "</option>");
                        $('#partnersname').val('').trigger('change');
                    }

                    $('#fromaccount').empty();
                    $('#fromaccount').append("<option></option>");
                    var submenus1 = data.accountype;
                    for (var ii = 0; ii < submenus1.length; ii++) {
                        $('#fromaccount').append("<option value='" + submenus1[ii].tid + "'>" + submenus1[ii].transtype + ' - ' + submenus1[ii].type + "</option>");
                        $('#fromaccount').val('').trigger('change');
                    }
                }
            }
        });
    }
});
