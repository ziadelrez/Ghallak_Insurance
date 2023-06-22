$(document).ready(function () {
    $('#fromdateS').hide();
       // fetch_bookings_data($('#clientname').val(),$('#carname').val(),$('#brname').val());
       fetch_bookings_data();
    // $('#bootstrap-data-table').hide();
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
    $('#bootstrap-data-table').show();
    fetch_bookings_data($('#clientname').val(),$('#carname').val(),$('#brname').val());
});


function fetch_bookings_data(cname1='',caname1='',brname='')
{
    $('#bootstrap-data-table').DataTable({
        order: [[ 8, 'asc' ]],
        processing: true,
        serverSide: true,
        bDestroy: true,
        bPaginate: true,
        bAutoWidth: false,
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
            url:'/gettransactionscarslist',
            Type:'GET',
            data: {
                clientname:cname1,
                carname:caname1,
                brname:brname
            },
        },

        columns: [
            {data: 'contid', name: 'contid'},
            {data: 'brname', name: 'brname'},
            {data: 'contractdate', name: 'contractdate'},
            {data: 'clientname', name: 'clientname'},
            {data: 'carname', name: 'carname'},
            {data: 'cardays', name: 'cardays'},
            {data: 'takendate', name: 'takendate'},
            {data: 'takentime', name: 'takentime'},
            {data: 'returndate', name: 'returndate'},
            {data: 'returntime', name: 'returntime'},
        ]

    });
}


