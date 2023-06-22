$(document).ready(function () {

    $(".selectionaperson").select2({
        placeholder: "إختر إسم الخصم",
        allowClear: true
    });

    $(".selectionreg").select2({
        placeholder: "إختر اسم المنطقة",
        allowClear: true
    });

    $(".selectionacccurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectioncar").select2({
        placeholder: "إختر إسم السيارة",
        allowClear: true
    });

    $(".selectioninsname").select2({
        placeholder: "إختر إسم التأمين",
        allowClear: true
    });

    $(".selectiongcurr").select2({
        placeholder: "إختر نوع العملة",
        allowClear: true
    });

    $(".selectionecurr").select2({
        placeholder: "إختر نوع العملة",
        allowClear: true
    });

    $(".selectionhcurr").select2({
        placeholder: "إختر نوع العملة",
        allowClear: true
    });

    $(".selectiontcurr").select2({
        placeholder: "إختر نوع العملة",
        allowClear: true
    });

    $(".selectiongarage").select2({
        placeholder: "إختر إسم الكاراج",
        allowClear: true
    });

    $(".selectionexpert").select2({
        placeholder: "إختر إسم الخبير",
        allowClear: true
    });

    $(".selectionhospital").select2({
        placeholder: "إختر إسم المستشفى",
        allowClear: true
    });

    $(".selectionaccidenttype").select2({
        placeholder: "إختر نوع الحادث",
        allowClear: true
    });

    $(".selectionfollowby").select2({
        placeholder: "إختر إسم الوصي على الملف",
        allowClear: true
    });

    $(".selectionclient").select2({
        placeholder: "إختر إسم الزبون",
        allowClear: true
    });
    fetch_accident_data();

    // $idclients = $('#client option:selected').attr("value");
    // console.log($idclients);

    if ( $('#flag').val() == 1) {
        getinsuranceslist();
        getDatainsname($('#contdet_id').val());
    }

    var role = $("#user_role_create").val();
    var showfields =  role != 6 ? true:false;

    if(showfields == false){
        document.getElementById("rowdetails").hidden = true;
        document.getElementById("rowexpert").hidden = true;
        document.getElementById("rowexpertdet").hidden = true;
        document.getElementById("rowhosp").hidden = true;
        document.getElementById("rowhospdet").hidden = true;
        document.getElementById("rowcompcode").hidden = true;
        document.getElementById("rowtotal").hidden = true;
        document.getElementById("rowhr").hidden = true;
        document.getElementById("rowgdetails").hidden = false;
    }else{
        document.getElementById("rowdetails").hidden = false;
        document.getElementById("rowexpert").hidden = false;
        document.getElementById("rowexpertdet").hidden = false;
        document.getElementById("rowhosp").hidden = false;
        document.getElementById("rowhospdet").hidden = false;
        document.getElementById("rowcompcode").hidden = false;
        document.getElementById("rowtotal").hidden = false;
        document.getElementById("rowhr").hidden = false;
        document.getElementById("rowgdetails").hidden = true;
    }


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

function fetch_accident_data(sqlstr = '',sqlstrstatus='')
{
    var role = $("#user_role").val();
    var showAdminColumns =  role != 6 ? true:false;
    // console.log(role);
    // console.log(showAdminColumns);

    $('#tbaccidents').DataTable({
        // processing: true,
        order: [[ 9 ,"desc" ]],
        pageLength: 10,
        autoWidth : false,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
            url:'/getaccidents',
            Type:'GET',
            data:{
                sqlstr:sqlstr,
                sqlstrstatus:sqlstrstatus,
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'billid', name: 'billid',visible:false},
            {data: 'statusid', name: 'statusid',visible:false},
            {data: 'accbill', name: 'action', orderable: false,"width": "100px",visible : showAdminColumns},
            {data: 'accstatus', name: 'action', orderable: false,className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'accaction', name: 'action', orderable: false, searchable: false,className: 'dt-body-nowrap'},
            {data: 'accaperson', name: 'action', orderable: false, searchable: false,className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'acccode', name: 'acccode',className: 'dt-body-nowrap'},
            {data: 'acctype', name: 'acctype',className: 'dt-body-nowrap'},
            {data: 'accdate', name: 'accdate',className: 'dt-body-nowrap'},
            {data: 'accperson', name: 'accperson',className: 'dt-body-nowrap'},
            {data: 'accinsname', name: 'accinsname',className: 'dt-body-nowrap'},
            {data: 'acccar', name: 'acccar',className: 'dt-body-nowrap'},
            {data: 'accgarage', name: 'accgarage',className: 'dt-body-nowrap'},
            {data: 'accexpert', name: 'accexpert',className: 'dt-body-nowrap'},
            {data: 'acccost', name: 'acccost',className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'acccurr', name: 'acccurr',className: 'dt-body-nowrap',visible : showAdminColumns},
        ]
    });
}

$(document).on('click', '#allbills', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_accident_data(sqlrtr,sqlstrstatus);
});

$(document).on('click', '#billsclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_accident_data(sqlrtr,sqlstrstatus);
});

$(document).on('click', '#billsnotclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_accident_data(sqlrtr,sqlstrstatus);
});

$(document).on('click', '#allstatus', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_accident_data(sqlrtr,sqlstrstatus);
});

$(document).on('click', '#statusclosed', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_accident_data(sqlrtr,sqlstrstatus);
});

$(document).on('click', '#statusnotclosed', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_accident_data(sqlrtr,sqlstrstatus);
});

$('#tbaccidents').on('click', '.btn-bill', function () {
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
                fetch_accident_data();
            }
        }
    });
});

$('#tbaccidents').on('click', '.btn-sts', function () {
    let $pid = $(this).attr('data-id');
    let $sts = $(this).attr('data-to');
    // console.log($pid);
    // console.log($sts);
    // console.log($("#change_status_booking").val());
    $.ajax({
        type: 'POST',
        url: $("#change_status_ins").val(),
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
                fetch_accident_data();
            }
        }
    });
});

$('#tbaccidents').on('click', '.delete-btn-accident', function () {
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
                    url: '/deleteaccident',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            fetch_accident_data();
                        }
                    }
                });
            }
        }
    });
});

$(document).on('change', '#car', function(){
    $('#err_carvalidation').hide()
    $('#err_insnotexist').hide()
    document.getElementById("accsavebtn").disabled = false;
    $idcar = $('#car option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getcarvalide',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'carid': $idcar,
            'status': '',
            'flag': ''
        },
        success: function(data) {
            if ((data.errors)) {
                // console.log(data.errors)
                $('#err_carvalidation').hide()
                $('#err_insnotexist').hide()
            } else {
                if($idcar > "1") {
                    // console.log($idcar)
                    // console.log(data.flag)
                    if ((data.flag == "0")) {
                        $('#err_insnotexist').show()
                        document.getElementById("accsavebtn").disabled = true;
                    } else {
                        // console.log(data.status)
                        if ((data.status == "1")) {
                            $('#err_carvalidation').show()
                            document.getElementById("accsavebtn").disabled = true;
                        }
                    }
                }
                // else if($idcar == "undefined"){
                //     $('#err_carvalidation').hide()
                //     $('#err_insnotexist').hide()
                // }

            }

        }
    });
});

$(document).on('click','.create-modal', function() {
    // $('#tablemodal').empty();
    $('#create').modal('show');
    clearaperson();
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة بيانات الخصم في الحادث');
    $('#accident_id_1').val($(this).data('id'));
    $('#lblcocode').val($(this).data('code'));
    fetch_aperson_data();
});


function clearaperson(){
    $('#err_details_aperson').hide()
    $('#err_details_accost').hide()
    $('#err_details_acccurr').hide()
    $('#err_details_adetails').hide()

    $('#create #aperson').val('').trigger('change');
    $('#create #accost').val('');
    $('#create #acccurr').val('').trigger('change');
    document.getElementById('adetails').value = '';
    $('#cflag').val('0');
    $('#aperson').focus();
    $('#saveaperson').text("حفظ البيانات");
}

$(document).on('click', '#saveaperson', function(){
    var cflag = $('#cflag').val();
    if (cflag == "0") {
        // console.log(cflag);
        $.ajax({
            type: 'POST',
            url: '/addaperson',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'accident': $('input[name=accident_id_1]').val(),
                'aperson': $('#aperson option:selected').attr("value"),
                'accost': $('input[name=accost]').val(),
                'acccurr': $('#acccurr option:selected').attr("value"),
                'adetails': document.getElementById('adetails').value,
            },
            success: function (data) {
                if ((data.errors)) {
                    // console.log(data.errors);
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_aperson').remove()
                    $('#err_details_accost').remove()
                    $('#err_details_acccurr').remove()
                    $('#err_details_adetails').remove()
                    fetch_aperson_data();
                    clearaperson();
                }
            }
        });
    }else if (cflag == "1") {
        // console.log($('input[name=payment_id]').val());
        var $fid = $('#apersonid').val();
        $.ajax({
            type: 'POST',
            url: '/editaperson',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $fid,
                'aperson': $('#aperson option:selected').attr("value"),
                'accost': $('input[name=accost]').val(),
                'acccurr': $('#acccurr option:selected').attr("value"),
                'adetails': document.getElementById('adetails').value,
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_aperson').remove()
                    $('#err_details_accost').remove()
                    $('#err_details_acccurr').remove()
                    $('#err_details_adetails').remove()
                    fetch_aperson_data();
                    clearaperson();
                }
            }
        });
    }
});

function fetch_aperson_data()
{
    let accid = $('#accident_id_1').val();
    $('#tablemodal').DataTable({
        // processing: true,
        order: [[ 0, "desc" ]],
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
            url:'/getapesonacclist',
            Type:'GET',
            data:{
                accid:accid,
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'closedactions', name: 'action', orderable: false, searchable: false},
            {data: 'aperson', name: 'aperson'},
            {data: 'acost', name: 'acost'},
            {data: 'acurr', name: 'acurr'},
            {data: 'apersonactions', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$('#tablemodal').on('click', '.edit-btn-aperson', function(){
    clearaperson();
    $('#cflag').val('1');
    $('#apersonid').val($(this).data('id'));
    $('#saveaperson').text("تعديل البيانات");
    $('#aperson').select2('data', {id: $(this).data('apersonid'), a_key: $(this).data('apersonname')}).change();
    $('#accost').val($(this).data('accost'));
    $('#acccurr').select2('data', {id: $(this).data('acccurr'), a_key: $(this).data('currname')}).change();
    document.getElementById('adetails').value =$(this).data('adetails');
});

$('#tablemodal').on('click', '.delete-btn-aperson', function () {
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
                    url: '/deleteaperson',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $fid
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            fetch_aperson_data();
                            clearaperson();
                        }
                    }
                });
            }
        }
    });
});

$('#tablemodal').on('click', '.btn-sts', function () {
    let $pid = $(this).attr('data-id');
    let $sts = $(this).attr('data-to');
    // console.log($pid);
    // console.log($sts);
    // console.log($("#change_status_booking").val());
    $.ajax({
        type: 'POST',
        url: $("#change_status_aperson").val(),
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
                fetch_aperson_data();
            }
        }
    });
});


$(document).on('change', '#client', function(){
    $('#insname').empty();
    $idclients = $('#client option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getinsurancecode',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idclient':$idclients,
            'contid': '',
            'ccode': '',
            'insname': ''
        },
        success: function(data) {
            if ((data.errors)) {
                $('#insname').empty();
            } else {
                // $('#insname').empty();
                var submenus = data.insname;
                for(var i=0; i<submenus.length; i++) {
                    $('#insname').append("<option value='"+submenus[i].id+"'>" +submenus[i].ccode + ' , ' +submenus[i].insname+"</option>");
                    $('#insname').val('').trigger('change');
                }
            }
        }
    });
});

function getDatainsname(gid) {
    $.ajax({
        type: 'GET',
        url: '/getinsnamecode/'+ gid,
        data: {
            'contdetid':'',
            'insname':'',
            'ccode':'',
        },
        success: function(data) {
            // console.log(data.insname   + data.contdetid +data.ccode+"ddddd");
            $('#insname').select2('data', {id: data.contdetid, text: data.ccode + ' , ' + data.insname}).change();
            // $('#fromaccount').select2('data', {id: $(this).data('payfromaccountid'), a_key: $(this).data('payfromaccount') + ' - ' + $(this).data('payfromaccounttype')}).change();
        }
    });
}

function getinsuranceslist(){
    $('#insname').empty();
    $idclients = $('#client option:selected').attr("value");
    // console.log($idclients);
    $.ajax({
        type: 'POST',
        url: '/getinsurancecode',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idclient':$idclients,
            'contid': '',
            'ccode': '',
            'insname': ''
        },
        success: function(data) {
            if ((data.errors)) {
                $('#insname').empty();
            } else {
                // $('#insname').empty();
                var submenus = data.insname;
                for(var i=0; i<submenus.length; i++) {
                    $('#insname').append("<option value='"+submenus[i].id+"'>" +submenus[i].ccode + ' , ' +submenus[i].insname+"</option>");
                    $('#insname').val('').trigger('change');
                }
            }
        }
    });
}
