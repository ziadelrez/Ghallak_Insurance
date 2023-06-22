$(document).ready(function () {
    $(".selectexptype").select2({
        placeholder: "إختر نوع المصروف",
        allowClear: true
    });

    $(".selectcurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectpaymenttype").select2({
        placeholder: "إختر طريقة الدفع",
        allowClear: true
    });

    $(".selectbanks").select2({
        placeholder: "إختر إسم البنك",
        allowClear: true
    });

   $(".selectbranch").select2({
        placeholder: "إخنر الفرع",
        allowClear: true
    });
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

    fetch_expenses_data($('#fromdate').val(),$('#todate').val());
    // getsum();
});

$(document).on('change', '#paymenttype', function(){
    var stext = $('#paymenttype option:selected').attr("value");
    if(stext == "22"){
        document.getElementById("banks-div").hidden = false;
    }else if(stext == ""){
        document.getElementById("banks-div").hidden = true;
        $('#banks').val('1').trigger('change');
        $("#checknum").val('-');
    }else{
        document.getElementById("banks-div").hidden = true;
        $('#banks').val('1').trigger('change');
        $("#checknum").val('-');
    }
});

$(document).on('click', '.edit-btn', function(){
    clearpayment();
    $('#cflag').val('1');
    $('#exp_id').val($(this).data('id'));
    $('#savepayment').text("تعديل البيانات");
    $('#expdate').val($(this).data('expdate'));
    $('#checkdate').val($(this).data('checkdate'));
    $('#exptype').select2('data', {id: $(this).data('exptypeid'), a_key: $(this).data('exptype')}).change();
    $('#amount').val($(this).data('expamount'));
    $('#curr').select2('data', {id: $(this).data('expcurrid'), a_key: $(this).data('expcurr')}).change();
    $('#banks').select2('data', {id: $(this).data('bankid'), a_key: $(this).data('bankname')}).change();
    $('#branch').select2('data', {id: $(this).data('expbranchid'), a_key: $(this).data('expbranch')}).change();
    $('#paymenttype').select2('data', {id: $(this).data('paytypeid'), a_key: $(this).data('paytype')}).change();
    $('#checknum').val($(this).data('checknum'));
});

$('#bootstrap-data-table').on('click', '.delete-btn', function () {
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
                    url: '/deleteexp',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            fetch_expenses_data($('#fromdate').val(),$('#todate').val());
                            clearpayment();
                        }
                    }
                });
            }
        }
    });
});

$(document).on('click', '#searchexp', function(){
    fetch_expenses_data($('#fromdate').val(),$('#todate').val());
    fetch_expenses_usd($('#fromdate').val(),$('#todate').val());
    fetch_expenses_lbp($('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#clearpayment', function(){
    clearpayment();
});

$(document).on('click', '#savepayment', function(){
    var cflag = $('#cflag').val();
    if (cflag == "0") {
        // console.log($('#client_id').val());
        $.ajax({
            type: 'POST',
            url: '/storeexp',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'expdate': $('input[name=expdate]').val(),
                'checkdate': $('input[name=checkdate]').val(),
                'exptype': $('#exptype option:selected').attr("value"),
                'amount': $('input[name=amount]').val(),
                'curr': $('#curr option:selected').attr("value"),
                'branch': $('#branch option:selected').attr("value"),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'checknum': $('input[name=checknum]').val(),
                'bank': $('#banks option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_expdate').remove()
                    $('#err_details_checkdate').remove()
                    $('#err_details_exptype').remove()
                    $('#err_details_amount').remove()
                    $('#err_details_curr').remove()
                    $('#err_details_bank').remove()
                    $('#err_details_branch').remove()
                    $('#err_details_paymenttype').remove()
                    fetch_expenses_data($('#fromdate').val(),$('#todate').val());
                    clearpayment();
                }
            }
        });
    }else if (cflag == "1") {
        // console.log($('input[name=payment_id]').val());
        var $fid = $('#exp_id').val();
        $.ajax({
            type: 'POST',
            url: '/editexp',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $fid,
                'expdate': $('input[name=expdate]').val(),
                'checkdate': $('input[name=checkdate]').val(),
                'exptype': $('#exptype option:selected').attr("value"),
                'amount': $('input[name=amount]').val(),
                'curr': $('#curr option:selected').attr("value"),
                'branch': $('#branch option:selected').attr("value"),
                'paymenttype': $('#paymenttype option:selected').attr("value"),
                'checknum': $('input[name=checknum]').val(),
                'bank': $('#banks option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_expdate').remove()
                    $('#err_details_checkdate').remove()
                    $('#err_details_exptype').remove()
                    $('#err_details_amount').remove()
                    $('#err_details_curr').remove()
                    $('#err_details_bank').remove()
                    $('#err_details_branch').remove()
                    $('#err_details_paymenttype').remove()
                    fetch_expenses_data($('#fromdate').val(),$('#todate').val());
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

    $('#err_details_expdate').hide()
    $('#err_details_checkdate').hide()
    $('#err_details_exptype').hide()
    $('#err_details_amount').hide()
    $('#err_details_curr').hide()
    $('#err_details_bank').hide()
    $('#err_details_branch').hide()
    $('#err_details_paymenttype').hide()

    $('#exptype').val('').trigger('change');
    $('#branch').val('').trigger('change');
    $('#banks').val('1').trigger('change');
    $('#paymenttype').val('').trigger('change');
    $("#checknum").val('-');
    $("#expdate").val('');
    $('#amount').val('0');
    $('#curr').val('').trigger('change');
    $('#cflag').val('0');
    $('#savepayment').text("حفظ البيانات");
}

function fetch_expenses_data(fromdate = '',todate = '')
{
    $('#bootstrap-data-table').DataTable({
        // processing: true,
        order: [[ 1, "desc" ]],
        serverSide: true,
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
            url:'/getexplist',
            Type:'GET',
            data:{
                fromdate:fromdate,
                todate:todate
            },
        },
        columns: [
            {data: 'expid', name: 'expid'},
            {data: 'expdate', name: 'expdate'},
            {data: 'exptype', name: 'exptype'},
            {data: 'amount', name: 'amount'},
            {data: 'curr', name: 'curr'},
            {data: 'brname', name: 'brname'},
            {data: 'expaction', name: 'action', orderable: false, searchable: false}
        ]
    });
}

function fetch_expenses_usd(fromdate = '',todate = '') {
    $.ajax({
        type: 'GET',
        url: '/getexpenses_usd',
        data: {
            fromdate:fromdate,
            todate:todate,
            ramount:'',
            rcurr:''
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

function fetch_expenses_lbp(fromdate = '',todate = '') {
    $.ajax({
        type: 'GET',
        url: '/getexpenses_lbp',
        data: {
            fromdate:fromdate,
            todate:todate,
            ramount:'',
            rcurr:''
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



// $('#myModal.select2').select2();

