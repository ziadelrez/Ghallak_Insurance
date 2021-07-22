$(document).ready(function(){
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#startDate').datepicker({
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        minDate: today,
        maxDate: function () {
            return $('#endDate').val();
        }
    });
    $('#endDate').datepicker({
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        minDate: function () {
            return $('#startDate').val();
        }
    });
    fetch_customer_data();
});
$('#bootstrap-data-table').on('click', '.btn-danger', function () {
    var $fid = $(this).attr('data-id')
    // console.log($fid);
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
                $.ajax({
                    type: 'POST',
                    url: '/deletecars',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: $fid,
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            // console.log("success");
                            fetch_customer_data();
                        }
                    }
                });
            }
        }
    });
});
function fetch_customer_data(query = '',sqlstr = '')
{
     var table = $('#bootstrap-data-table').DataTable({
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
                url:'/carsaction',
                Type:'GET',
                data:{query:query,sqlstr:sqlstr},
            },
        columns: [
            {data: 'car_id', name: 'car_id'},
            {data: 'car_name', name: 'car_name'},
            {data: 'car_number', name: 'car_number'},
            {data: 'car_type', name: 'car_type'},
            {data: 'car_color', name: 'car_color'},
            {data: 'car_model', name: 'car_model'},
            {data: 'car_rates', name: 'car_rates'},
            {data: 'car_photo', name: 'car_photo'},
            {data: 'car_action', name: 'action', orderable: false, searchable: false}
        ]
    });
}

$(document).on('keyup', '#search', function(){
        let query = $(this).val();
        let sqlrtr = $("#taken").val();
        fetch_customer_data(query, sqlrtr);
    // console.log(sqlrtr);
});

$(document).on('click', '#allcars', function(){
    $("#taken").val($(this).attr('data-id'));
    let query = $("#search").val();
    let sqlrtr = $("#taken").val();
    fetch_customer_data(query,sqlrtr);
    // console.log($("#taken").val());
    // console.log($("#search").val());
});

$(document).on('click', '#takenyes', function(){
    $("#taken").val($(this).attr('data-id'));
    let query = $("#search").val();
    let sqlrtr = $("#taken").val();
    fetch_customer_data(query,sqlrtr);
    // console.log($("#taken").val());
    // console.log($("#search").val());
});

$(document).on('click', '#takenno', function(){
    $("#taken").val($(this).attr('data-id'));
    let query = $("#search").val();
    let sqlrtr = $("#taken").val();
    fetch_customer_data(query,sqlrtr);
    // console.log($("#taken").val());
    // console.log($("#search").val());
});




