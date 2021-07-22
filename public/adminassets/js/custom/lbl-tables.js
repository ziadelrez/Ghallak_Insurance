$(document).ready(function(){
    $('#table').dataTable({
        // "pagingType" : "full_numbers",
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
        }

    });
});
