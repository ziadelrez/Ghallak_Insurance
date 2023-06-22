$(document).ready(function () {

    $(".selectfollowby").select2({
        placeholder: "إختر إسم معقب المعاملة",
        allowClear: true
    });

    $(".selectbrokername").select2({
        placeholder: "إختر إسم الوسيط",
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

    fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());

    // fetch_contract_data_all();
    fetch_balance_data();
    $("#msg_id").val($("#smsrenew_id").val());

});

function openremindersclientsprintout() {
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
        window.open(
            $("#clientsrouteid").val() + '/' + fdates, "_blank");

    }else if(filtervalue == 1){
        window.open(
            $("#bclientsrouteid").val() + '/' + cbofollowby + '/' + filtervalue + '/' + fdates, "_blank");

    }else if(filtervalue == 2){
        window.open(
            $("#bclientsrouteid").val() + '/' + cbobroker + '/' + filtervalue+ '/' + fdates, "_blank");
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

$(document).on('click', '#clientssearchby', function(){
    document.getElementById("allbills").checked = true;
    $("#billedvalue").val("");
    fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());
});

function fetch_contract_data(sqlstr = '',sqlstrstatus='',fromdate = '',todate = '')
{
    $('#tbcontractsummary').DataTable({
        // processing: true,
        order: [[ 12, "asc" ]],
        pageLength: 10,
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
            url:'/reminders-results',
            Type:'GET',
            data:{
                sqlstr:sqlstr,
                sqlstrstatus:sqlstrstatus,
                msgtype:$("#msgtype").val(),
                fromdate:fromdate,
                todate:todate
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'status', name: 'status',visible:false},
            {data: 'sendaction', name: 'action', orderable: false, searchable: false,className: 'dt-body-nowrap'},
            {data: 'ccode', name: 'ccode',className: 'dt-body-nowrap'},
            {data: 'cname', name: 'cname',className: 'dt-body-nowrap'},
            {data: 'cmob', name: 'cname',className: 'dt-body-nowrap'},
            {data: 'compname', name: 'compname',className: 'dt-body-nowrap'},
            {data: 'carname', name: 'carname',className: 'dt-body-nowrap'},
            {data: 'maidname', name: 'maidname',className: 'dt-body-nowrap'},
            {data: 'insname', name: 'insname',className: 'dt-body-nowrap'},
            {data: 'sdate', name: 'sdate',className: 'dt-body-nowrap'},
            {data: 'edate', name: 'edate',className: 'dt-body-nowrap'},
            {data: 'days', name: 'days',className: 'dt-body-nowrap'},
            {data: 'totalcost', name: 'totalcost',className: 'dt-body-nowrap'},
            {data: 'currname', name: 'currname',className: 'dt-body-nowrap'},
        ]
    });
}

function fetch_contract_data_all(sqlstr = '',sqlstrstatus='')
{
    $('#tbcontractsummary').DataTable({
        // processing: true,
        order: [[ 0, "desc" ]],
        pageLength: 10,
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
            url:'/reminders-results-all',
            Type:'GET',
            data:{
                sqlstr:sqlstr,
                sqlstrstatus:sqlstrstatus,
                msgtype:$("#msgtype").val(),
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'status', name: 'status',visible:false},
            {data: 'sendaction', name: 'action', orderable: false, searchable: false,className: 'dt-body-nowrap'},
            {data: 'ccode', name: 'ccode',className: 'dt-body-nowrap'},
            {data: 'cname', name: 'cname',className: 'dt-body-nowrap'},
            {data: 'cmob', name: 'cname',className: 'dt-body-nowrap'},
            {data: 'compname', name: 'compname',className: 'dt-body-nowrap'},
            {data: 'carname', name: 'carname',className: 'dt-body-nowrap'},
            {data: 'maidname', name: 'maidname',className: 'dt-body-nowrap'},
            {data: 'insname', name: 'insname',className: 'dt-body-nowrap'},
            {data: 'sdate', name: 'sdate',className: 'dt-body-nowrap'},
            {data: 'edate', name: 'edate',className: 'dt-body-nowrap'},
            {data: 'days', name: 'days',className: 'dt-body-nowrap'},
            {data: 'totalcost', name: 'totalcost',className: 'dt-body-nowrap'},
            {data: 'currname', name: 'currname',className: 'dt-body-nowrap'},
        ]
    });
}


function fetch_balance_data()
{
        $.ajax({
            type: 'GET',
            url: 'https://www.bestsmsbulk.com/bestsmsbulkapi/getbalance.php?username=ghallak&&password=HallakInsurance@2022',
            success: function(data){
                document.getElementById("gbalance").innerHTML = data;
            },
            error: function(error){
                alert("خطأ في جمع البيانات عن حساب الرسائل")
            }

    });
}

$(document).on('click', '#allbills', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#billsclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,$('#fromdate').val(),$('#todate').val());
});


$(document).on('click', '#billsnotclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#allstatus', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#statusclosed', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#statusnotclosed', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#smsrenew', function(){
    $("#msg_id").val($("#smsrenew_id").val());
    $("#msgtype").val("1");
    fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#smspayment', function(){
    $("#msg_id").val($("#smspayment_id").val());
    $("#msgtype").val("1");
    fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());
});

$(document).on('click', '#welcomemsg', function(){
    $("#msgtype").val("0");
    fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());
});

$('#tbcontractsummary').on('click', '.btn-bill', function () {
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
                fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());
            }
        }
    });
});


$('#tbcontractsummary').on('click', '.btn-sts', function () {
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
                fetch_contract_data('','',$('#fromdate').val(),$('#todate').val());
            }
        }
    });
});


function send(event , mobile){
    event.stopPropagation();
    // let mssg = " حضرة السيد/ة "+person+" نود اعلامكم بان عقد بوليصة التأمين رقم "+contract+" ينتهي بتاريخ "+date;
    ( function($) {
        $(document).ready( function() {
            $.ajax({
                url: 'https://www.bestsmsbulk.com/bestsmsbulkapi/sendSmsAPI.php?username=ghallak&&password=HallakInsurance@2022&&message='+$("#msg_id").val()+'&&senderid=G.ELHALLAK&&destination='+mobile,
                type: 'get',
                success: function () {
                    // bootbox.alert("تم إرسال الرسالة بنجاح");
                    bootbox.alert({
                        size: "small",
                        title: "تأكيد عملية الإرسال",
                        message: "تم إرسال الرسالة بنجاح الى الزبون",
                        callback: function(){ /* your callback code */ }
                    })
                    fetch_balance_data();
                },
                error: function () {
                    alert("خطأ في إرسال الرسالة! يرجى التحقق من الرقم")
                }
            })
        })
    } ) ( jQuery );
}

function sendwelcome(event , mobile,pname){
    event.stopPropagation();
    // let mssg = " حضرة السيد/ة "+person+" نود اعلامكم بان عقد بوليصة التأمين رقم "+contract+" ينتهي بتاريخ "+date;
    ( function($) {
        $(document).ready( function() {
            $.ajax({
                url: 'https://www.bestsmsbulk.com/bestsmsbulkapi/sendSmsAPI.php?username=ghallak&&password=HallakInsurance@2022&&message='+$("#msgcontent1").val()+pname+' '+$("#msgwelcomearea").val()+'&&senderid=G.ELHALLAK&&destination='+mobile,
                type: 'get',
                success: function () {
                    // bootbox.alert("تم إرسال الرسالة بنجاح");
                    bootbox.alert({
                        size: "small",
                        title: "تأكيد عملية الإرسال",
                        message: "تم إرسال الرسالة بنجاح الى الزبون",
                        callback: function(){ /* your callback code */ }
                    })
                    fetch_balance_data();
                },
                error: function () {
                    alert("خطأ في إرسال الرسالة! يرجى التحقق من الرقم")
                }
            })
        })
    } ) ( jQuery );
}
