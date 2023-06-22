$(document).ready(function () {
    $(".selectioncurrcost").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectioninsname").select2({
        placeholder: "إختر إسم التأمين",
        allowClear: true
    });

    fetch_bookings_data($('#companyid').val());
    CountRows();
    // getsum();
});

$(document).on('click', '.edit-btn', function(){
    clearpayment();
    $('#cflag').val('1');
    $('#company_ins_id').val($(this).data('id'));
    $('#saveins').text("تعديل البيانات");
    $('#insname').select2('data', {id: $(this).data('insid'), a_key: $(this).data('insname')}).change();
    $('#cost').val($(this).data('cost'));
    $('#currcost').select2('data', {id: $(this).data('currid'), a_key: $(this).data('currname')}).change();

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
                    url: '/deletecompanyins',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            fetch_bookings_data($('#companyid').val());
                            // CountRows();
                            clearpayment();
                        }
                    }
                });
            }
        }
    });
});

$(document).on('click', '#saveins', function(){
    var cflag = $('#cflag').val();
    // console.log(cflag);
    if (cflag == "0") {
        // console.log(cflag);
        $.ajax({
            type: 'POST',
            url: '/addcompanyins',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'insname': $('#insname option:selected').attr("value"),
                'cost': $('input[name=cost]').val(),
                'currcost': $('#currcost option:selected').attr("value"),
                'compid': $('input[name=companyid]').val(),
                'flag':''
            },
            success: function (data) {
                if ((data.errors)) {
                    // console.log(data.errors);
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    if(data.flag == "1"){
                        var str = $("#duplicateconfid").val();
                        $("#duplicate_modal_body").html(str);
                        $('#duplicateModal').modal('show');
                        clearpayment();
                    }else {
                        $('#err_details_insname').remove()
                        $('#err_details_cost').remove()
                        $('#err_details_currcost').remove()
                        fetch_bookings_data($('#companyid').val());
                        // CountRows();
                        clearpayment();
                    }
                }
            }
        });
    }else if (cflag == "1") {
        // console.log($('input[name=payment_id]').val());
        var $fid = $('#company_ins_id').val();
        $.ajax({
            type: 'POST',
            url: '/editcompanyins',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $fid,
                'insname': $('#insname option:selected').attr("value"),
                'cost': $('input[name=cost]').val(),
                'currcost': $('#currcost option:selected').attr("value"),
                'compid':$('input[name=companyid]').val(),
                'flag':''
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    if(data.flag == "1"){
                        var str = $("#duplicateconfid").val();
                        $("#duplicate_modal_body").html(str);
                        $('#duplicateModal').modal('show');
                        clearpayment();
                    }else {
                        $('#err_details_insname').remove()
                        $('#err_details_cost').remove()
                        $('#err_details_currcost').remove()
                        fetch_bookings_data($('#companyid').val());
                        // CountRows();
                        clearpayment();
                    }
                }
            }
        });
    }
});

$(document).on('click', '#clearins', function(){
    clearpayment();
});

function clearpayment(){
    $('#err_details_insname').hide()
    $('#err_details_cost').hide()
    $('#err_details_currcost').hide()

    $('#insname').val('').trigger('change');
    $('#currcost').val('').trigger('change');
    $("#cost").val('');
    $('#saveins').text("حفظ البيانات");
    $('#cflag').val("0");
}

function CountRows() {
     // rowCount = document.getElementById("bootstrap-data-table").rows.length;
    // rowCount = $('#tbid tr').length;
    var totalRowCount = 0 ;
    var rowCount = 0 ;
    var table = document.getElementById("bootstrap-data-table");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length ; i++) {
        totalRowCount++;
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount++;
        }
    }
    //  rowCount = $('#bootstrap-data-table tr').length;
    // console.log(rowCount);
    // var message = "Total Row Count: " + totalRowCount;
    // message += "\nRow Count: " + rowCount;
    // alert(message);
    document.getElementById('total_records').innerHTML = totalRowCount;
    // $('#total_records').val(rowCount);
}

function fetch_bookings_data(ccid = '')
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
            url:'/getcompanydetailsins',
            Type:'GET',
            data:{
                ccid:ccid,
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'insname', name: 'insname'},
            {data: 'cost', name: 'cost'},
            {data: 'currcost', name: 'currcost'},
            {data: 'cinsaction', name: 'action', orderable: false, searchable: false}
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

