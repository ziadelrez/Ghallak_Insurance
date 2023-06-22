$(document).ready(function () {

    order_data();
});

$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف بيانات الشخص");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text(" حذف بيانات الشخص");
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deleteclient',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text(),
            'flag':''
        },
        success: function(data){
            if(data.flag == "0") {
                $('.clrows' + $('.id').text()).remove();
            }else if(data.flag == "1"){
                var str = $("#deleteconfid").val();
                $("#modal_body").html(str);
                $('#exampleModal').modal('show');
            }
        }
    });
});

// $("#table tbody tr").each(function() {
//     var value = $(this).find(" td:nth-child(1)").html();
//     // console.log(value);
//     $.ajax({
//         type: 'POST',
//         url: '/checkcontract',
//         data: {
//             '_token': $('meta[name="csrf-token"]').attr('content'),
//             'clientid': value,
//             'rflag':''
//         },
//         success: function (data) {
//             if ((data.errors)) {
//
//             } else {
//                 console.log(data.rflag)
//             }
//         }
//     });
// });

function order_data()
{

    $('#table').DataTable({
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/fecthdataclients',
            type:'GET',
            data:{
                sqlstr:"",
                sqlstrstatus:"",
                sqlstop:"",
            },
        },
        columns: [
            {data: 'id', name: 'id',visible:false},
            {data: 'eval', name: 'eval',className: 'dt-body-nowrap'},
            {data: 'clientname', name: 'clientname',className: 'dt-body-nowrap'},
            {data: 'followby', name: 'followby',className: 'dt-body-nowrap'},
            {data: 'mobile', name: 'mobile',className: 'dt-body-nowrap'},
            {data: 'branch', name: 'branch',className: 'dt-body-nowrap'},
            {data: 'clientaction', name: 'action', orderable: false,className: 'dt-body-nowrap'},
            {data: 'contractaction', name: 'action', orderable: false, searchable: false,className: 'dt-body-nowrap'},
        ]

    });
}
