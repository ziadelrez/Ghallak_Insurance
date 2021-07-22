$(document).ready(function () {
    $(".selectcar").select2({
        placeholder: "إختر السيارة",
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
    $('#fromdateS').val(today);
    $('#todateS').val(today);

    fetch_bookings_data($('#fromdateS').val(),$('#todateS').val());
    // getsum();
});
$('#bootstrap-data-table').on('click', '.btn-sts', function () {
    let $pid = $(this).attr('data-id');
    let $sts = $(this).attr('data-to');
    // console.log($pid);
    // console.log($sts);
    // console.log($("#change_status_booking").val());
    $.ajax({
        type: 'POST',
        url: $("#change_status_booking").val(),
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
                fetch_bookings_data($('#fromdateS').val(),$('#todateS').val());
            }
        }
    });
});

$(document).on('click', '.edit-btn', function(){
    clearpayment();
    $('#cflag').val('1');
    $('#booking_id').val($(this).data('id'));
    $('#savepayment').text("تعديل البيانات");
    $('#fromdate').val($(this).data('fromdate'));
    $('#todate').val($(this).data('todate'));
    $('#car').select2('data', {id: $(this).data('carid'), a_key: $(this).data('carname') + ' - ' + $(this).data('carnumber') + ' , ' + $(this).data('carcolor') + ' , ' + $(this).data('carmodel')}).change();
    $('#pname').val($(this).data('pname'));
    $('#mobile').val($(this).data('mobile'));
    $('#ndays').val($(this).data('ndays'));
    $('#branch').select2('data', {id: $(this).data('branchid'), a_key: $(this).data('branch')}).change();
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
                    url: '/deletebooking',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            fetch_bookings_data($('#fromdateS').val(),$('#todateS').val());
                            clearpayment();
                        }
                    }
                });
            }
        }
    });
});

$(document).on('click', '#searchexp', function(){
    fetch_bookings_data($('#fromdateS').val(),$('#todateS').val());
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
            url: '/storebooking',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'fromdate': $('input[name=fromdate]').val(),
                'todate': $('input[name=todate]').val(),
                'car': $('#car option:selected').attr("value"),
                'pname': $('input[name=pname]').val(),
                'mobile': $('input[name=mobile]').val(),
                'ndays': $('input[name=ndays]').val(),
                'branch': $('#branch option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_fromdate').remove()
                    $('#err_details_todate').remove()
                    $('#err_details_car').remove()
                    $('#err_details_pname').remove()
                    $('#err_details_mobile').remove()
                    $('#err_details_ndays').remove()
                    $('#err_details_branch').remove()
                    fetch_bookings_data($('#fromdateS').val(),$('#todateS').val());
                    clearpayment();
                }
            }
        });
    }else if (cflag == "1") {
        // console.log($('input[name=payment_id]').val());
        var $fid = $('#booking_id').val();
        $.ajax({
            type: 'POST',
            url: '/editbooking',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $fid,
                'fromdate': $('input[name=fromdate]').val(),
                'todate': $('input[name=todate]').val(),
                'car': $('#car option:selected').attr("value"),
                'pname': $('input[name=pname]').val(),
                'mobile': $('input[name=mobile]').val(),
                'ndays': $('input[name=ndays]').val(),
                'branch': $('#branch option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_fromdate').remove()
                    $('#err_details_todate').remove()
                    $('#err_details_car').remove()
                    $('#err_details_pname').remove()
                    $('#err_details_mobile').remove()
                    $('#err_details_ndays').remove()
                    $('#err_details_branch').remove()
                    fetch_bookings_data($('#fromdateS').val(),$('#todateS').val());
                    clearpayment();
                }
            }
        });
    }
});

function clearpayment(){
    $('#err_details_fromdate').hide()
    $('#err_details_todate').hide()
    $('#err_details_car').hide()
    $('#err_details_pname').hide()
    $('#err_details_mobile').hide()
    $('#err_details_ndays').hide()
    $('#err_details_branch').hide()

    $('#car').val('').trigger('change');
    $('#branch').val('').trigger('change');
    $("#fromdate").val('');
    $("#todate").val('');
    $('#pname').val('');
    $('#mobile').val('');
    $('#ndays').val('0');
    $('#cflag').val('0');
    $('#savepayment').text("حفظ البيانات");
}

function fetch_bookings_data(fromdate = '',todate = '')
{
    $('#bootstrap-data-table').DataTable({
        processing: true,
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
            url:'/getbookinglist',
            Type:'GET',
            data:{
                fromdate:fromdate,
                todate:todate
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'pname', name: 'pname'},
            {data: 'fromdate', name: 'fromdate'},
            {data: 'todate', name: 'todate'},
            {data: 'carname', name: 'carname'},
            {data: 'bookingstatus', name: 'action', orderable: false, searchable: false},
            {data: 'bookingaction', name: 'action', orderable: false, searchable: false}
        ]
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

$(document).on('focusout', '#fromdate', function(){
    let start = new Date($('#fromdate').val());
    let end = new Date($('#todate').val());

    let Difference_In_Time = end.getTime() - start.getTime();

    let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    $('#ndays').val(Difference_In_Days);
});


$(document).on('focusout', '#todate', function(){
    let start = new Date($('#fromdate').val());
    let end = new Date($('#todate').val());

    let Difference_In_Time = end.getTime() - start.getTime();

    let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    $('#ndays').val(Difference_In_Days);
});

// $('#myModal.select2').select2();

