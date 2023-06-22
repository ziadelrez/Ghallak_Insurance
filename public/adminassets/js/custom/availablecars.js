$(document).ready(function () {
       fetch_bookings_data($('#brname').val());
       // fetch_bookings_data();
});



$(document).on('click', '#searchexp', function(){
    fetch_bookings_data($('#brname').val());
});


function fetch_bookings_data(brname='')
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
            url:'/getavailablecarslist',
            Type:'GET',
            data: {
                brname:brname
            },
        },

        columns: [
            {data: 'carid', name: 'carid'},
            {data: 'carname', name: 'carname'},
            {data: 'brname', name: 'brname'},
        ]

    });
}


