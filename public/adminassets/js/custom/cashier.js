$(document).ready(function () {
    $(".selectpartners").select2({
        placeholder: "إختر نوع الشريك",
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

    fetch_expenses_data($('#fromdate').val(),$('#todate').val());
    // getsum();
});

$(document).on('click', '#searchexp', function(){
    fetch_expenses_data($('#fromdate').val(),$('#todate').val(),$('#partners option:selected').attr("value"));
    fetch_cashier_usd($('#fromdate').val(),$('#todate').val(),$('#partners option:selected').attr("value"));
    fetch_cashier_lbp($('#fromdate').val(),$('#todate').val(),$('#partners option:selected').attr("value"));
});

function fetch_expenses_data(fromdate = '',todate = '',partnerid = '')
{
    $('#bootstrap-data-table').DataTable({
        // processing: true,
        order: [[ 2, "desc" ]],
        serverSide: true,
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
            url:'/gettransactioncashierlist',
            Type:'GET',
            data:{
                fromdate:fromdate,
                todate:todate,
                partnerid:partnerid
            },
        },
        columns: [
            {data: 'trid', name: 'trid',visible:false},
            {data: 'trbranch', name: 'trbranch',className: 'dt-body-nowrap'},
            {data: 'trdate', name: 'trdate',className: 'dt-body-nowrap'},
            {data: 'trname', name: 'trname',className: 'dt-body-nowrap'},
            {data: 'trclient', name: 'trclient',className: 'dt-body-nowrap'},
            {data: 'tramountin', name: 'tramountin',className: 'dt-body-nowrap'},
            {data: 'tramountout', name: 'tramountout',className: 'dt-body-nowrap'},
            {data: 'trcurr', name: 'trcurr',className: 'dt-body-nowrap'},
            {data: 'trtype', name: 'trtype',className: 'dt-body-nowrap'},
            {data: 'trcheck', name: 'trcheck',className: 'dt-body-nowrap'},
            {data: 'trbank', name: 'trbank',className: 'dt-body-nowrap'},
            {data: 'trdetails', name: 'trdetails',className: 'dt-body-nowrap'},
        ]
    });
}

function fetch_cashier_usd(fromdate = '',todate = '',partnerid = '')
{
    $.ajax({
        type: 'GET',
        url: '/getcashier_usd',
        data: {
            fromdate:fromdate,
            todate:todate,
            partnerid:partnerid,
            ramountin:'',
            ramountout:'',
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
                document.getElementById("trusdin").innerText =  $("#total_bills_usd_in").val() + ' : '+ data.ramountin + ' ' + data.rcurr;
                document.getElementById("trusdout").innerText =  $("#total_bills_usd_out").val() + ' : '+ data.ramountout + ' ' + data.rcurr;
            }
        }
    });

}

function fetch_cashier_lbp(fromdate = '',todate = '',partnerid = '') {
    $.ajax({
        type: 'GET',
        url: '/getcashier_lbp',
        data: {
            fromdate:fromdate,
            todate:todate,
            partnerid:partnerid,
            ramountin:'',
            ramountout:'',
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
                document.getElementById("trlbpin").innerText = $("#total_bills_lbp_in").val() + ' : '+ data.ramountin + ' ' + data.rcurr;
                document.getElementById("trlbpout").innerText = $("#total_bills_lbp_out").val() + ' : '+ data.ramountout + ' ' + data.rcurr;
            }
        }
    });

}

