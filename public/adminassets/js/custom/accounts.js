$(document).ready(function () {
    $('#table').on('click', '.btn-sts', function () {
        let $pid = $(this).attr('data-id');
        let $sts = $(this).attr('data-to');
        $.ajax({
            type: 'POST',
            url: $("#change_status").val(),
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                uid: $pid,
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
                    $("#table").load(window.location + " #table");
                }
            }
        });
    });
});

$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف المستخدم");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('حذف المستخدم');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: $("#delete_user").val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text(),
            'flag':''
        },
        success: function(data){
            // console.log(data.flag);
            if(data.flag == "0") {
                $('.data-entry-id' + $('.id').text()).remove();
            }else if(data.flag == "1"){
                var str = $("#deleteconfid").val();
                $("#modal_body").html(str);
                $('#exampleModal').modal('show');
            }
        }
    });
});


