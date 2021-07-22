$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف بيانات الزبون");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text(" حذف بيانات الزبون");
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


