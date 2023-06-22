$(document).ready(function () {

    fetch_contract_data();
    fetch_summary_usd();
    fetch_summary_lbp();


});

function fetch_contract_data(sqlstr = '',sqlstrstatus='',sqlstop='')
{
    var role = $("#user_role").val();
    var showAdminColumns =  role != 6 ? true:false;

    // console.log(showAdminColumns);


    $('#tbcontractsummary').DataTable({
        // processing: true,
        order: [[ 13, "desc" ]],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // serverSide: true,
        autoWidth : false,
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/contractssummary',
            Type:'GET',
            data:{
                sqlstr:sqlstr,
                sqlstrstatus:sqlstrstatus,
                sqlstop:sqlstop,
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'billid', name: 'billid',visible:false},
            {data: 'statusid', name: 'statusid',visible:false},
            {data: 'billstatus', name: 'action', orderable: false,className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'instatus', name: 'action', orderable: false,className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'insaction', name: 'action', orderable: false, searchable: false,className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'ccode', name: 'ccode',className: 'dt-body-nowrap'},
            {data: 'cname', name: 'cname',className: 'dt-body-nowrap'},
            {data: 'compname', name: 'compname',className: 'dt-body-nowrap'},
            {data: 'carname', name: 'carname',className: 'dt-body-nowrap'},
            {data: 'maidname', name: 'maidname',className: 'dt-body-nowrap'},
            {data: 'insname', name: 'insname',className: 'dt-body-nowrap'},
            {data: 'sdate', name: 'sdate',className: 'dt-body-nowrap'},
            {data: 'edate', name: 'edate',className: 'dt-body-nowrap'},
            {data: 'days', name: 'days',className: 'dt-body-nowrap'},
            {data: 'totalcost', name: 'totalcost',className: 'dt-body-nowrap',visible : showAdminColumns},
            {data: 'currname', name: 'currname',className: 'dt-body-nowrap',visible : showAdminColumns},
        ]
    });
}

function fetch_summary_usd(sqlstr = '',sqlstrstatus='',sqlstop='') {
    var role = $("#user_role").val();
    var showAdminColumns =  role != 6 ? true:false;
    $.ajax({
        type: 'GET',
        url: '/getsummary_usd',
        data: {
            sqlstr:sqlstr,
            sqlstrstatus:sqlstrstatus,
            sqlstop:sqlstop,
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
                if (showAdminColumns === true){
                    document.getElementById("trusd").innerText = $("#total_bills_usd").val() + ' : ' + data.ramount + ' ' + data.rcurr;
                }
            }
        }
    });

}

function fetch_summary_lbp(sqlstr = '',sqlstrstatus='',sqlstop='') {
    var role = $("#user_role").val();
    var showAdminColumns =  role != 6 ? true:false;
        $.ajax({
        type: 'GET',
        url: '/getsummary_lbp',
        data: {
            sqlstr:sqlstr,
            sqlstrstatus:sqlstrstatus,
            sqlstop:sqlstop,
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
                // console.log(showAdminColumns);
                // console.log(showAdminColumns);
                if (showAdminColumns === true){
                    document.getElementById("trlbp").innerText = $("#total_bills_lbp").val() + ' : ' + data.ramount + ' ' + data.rcurr;
                }
            }
        }
    });

}

$(document).on('click', '#allbills', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#billsclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#billsnotclosed', function(){
    $("#billedvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#allstatus', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#statusclosed', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#statusnotclosed', function(){
    $("#statusvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#allstops', function(){
    $("#stopvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#stopped', function(){
    $("#stopvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
});

$(document).on('click', '#notstopped', function(){
    $("#stopvalue").val($(this).attr('data-id'));
    let sqlrtr = $("#billedvalue").val();
    let sqlstrstatus = $("#statusvalue").val();
    let sqlstop = $("#stopvalue").val();
    fetch_contract_data(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_usd(sqlrtr,sqlstrstatus,sqlstop);
    fetch_summary_lbp(sqlrtr,sqlstrstatus,sqlstop);
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
                fetch_contract_data();
                fetch_summary_usd();
                fetch_summary_lbp();
            }
        }
    });
});

$('#tbcontractsummary').on('click', '.btn-sts', function () {
    let $pid = $(this).attr('data-id');
    let $sts = $(this).attr('data-to');
    console.log($pid);
    console.log($sts);
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
                fetch_contract_data();
                fetch_summary_usd();
                fetch_summary_lbp();
            }
        }
    });
});
