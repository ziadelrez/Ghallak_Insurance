$(document).ready(function () {
    $('#fromdateS').hide();
       fetch_bookings_data($('#clientname').val(),$('#carname').val(),$('#brname').val());
       // fetch_bookings_data();
});

$(document).on('click', '#searchupcomingtoday', function(){
    var now = new Date();
    var month = (now.getMonth() + 1);
    var day = now.getDate();
    if (month < 10)
        month = "0" + month;
    if (day < 10)
        day = "0" + day;
    var today = now.getFullYear() + '-' + month + '-' + day;
    $('#fromdateS').val(today);
    fetch_bookings_data($('#clientname').val(),$('#carname').val(),$('#brname').val(),$('#fromdateS').val());
});

$(document).on('click', '#searchexp', function(){
    fetch_bookings_data($('#clientname').val(),$('#carname').val(),$('#brname').val());
});


function fetch_bookings_data(cname1='',caname1='',brname='',uptoday='')
{
    $('#bootstrap-data-table').DataTable({
        order: [[ 8, 'asc' ]],
        processing: true,
        serverSide: true,
        AutoWidth: false,
        bDestroy: true,
        bPaginate: true,
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
            url:'/getupcomingcarslist',
            Type:'GET',
            data: {
                clientname:cname1,
                carname:caname1,
                brname:brname,
                uptoday:uptoday
            },
        },

        columns: [
            {data: 'contid', name: 'contid',Width:"50px"},
            {data: 'brname', name: 'brname',Width:"200px"},
            {data: 'contractdate', name: 'contractdate',Width:"100px"},
            {data: 'clientname', name: 'clientname',Width:"100px"},
            {data: 'carname', name: 'carname',Width:"200px"},
            {data: 'cardays', name: 'cardays',Width:"50px"},
            {data: 'takendate', name: 'takendate',Width:"100px"},
            {data: 'takentime', name: 'takentime',Width:"50px"},
            {data: 'returndate', name: 'returndate',Width:"100px"},
            {data: 'returntime', name: 'returntime',Width:"50px"},
        ]

    });
}


