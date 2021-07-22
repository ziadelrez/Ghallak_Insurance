$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details').hide();
    $('#title').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة تعريف');
    $('#title').focus();
});
$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/addgdef/' + $('input[name=gd_tb]').val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'title': $('input[name=title]').val()
        },
        success: function(data){
            if ((data.errors)) {
                $('#err_details').show()
                $('#err_details').text(data.errors.title);
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.title);
            } else {
                $('#err_details').remove();
                $('#table').append('<tr class="gdrows' + data.id +'">'+
                    '<td style="display:none;">' + data.id + '</td>'+
                    '<td>' + data.title + '</td>'+
                    '<td class="text-center" >' +
                    '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.title + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.title + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '</tr>');
            }
        },
    });
    $('#title').val('');
    $('#title').focus();

});

// function Edit POST
$(document).on('click', '.edit-modal', function() {
    $('#footer_action_button').text(" تعديل التعريف");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('#err_details_up').hide();
    $('.modal-title').text('تعديل التعريف');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    $('#fid').val($(this).data('id'));
    $('#t').val($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'POST',
        url: '/editgdef/'+ $('input[name=gd_tb]').val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $("#fid").val(),
            'title': $('#t').val(),
        },
        success: function(data) {
            if ((data.errors)) {
                $('#err_details_up').show()
                $('#err_details_up').text(data.errors.title);
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.title);
            } else {
                $('.gdrows' + data.id).replaceWith(" " +
                    '<tr class="gdrows' + data.id + '">' +
                    '<td style="display:none;">' + data.id + '</td>' +
                    '<td>' + data.title + '</td>' +
                    '<td class="text-center" >' +
                    '<button  class="edit-modal btn btn-warning btn-sm" data-id=' + data.id + ' data-title=' + data.title + ' >' + '<i class="fa fa-edit"></i> </button>' + ' ' +
                    '<button  class="delete-modal btn btn-danger btn-sm" data-id=' + data.id + ' data-title=' + data.title + ' >' + '<i class="fa fa-trash"></i> </button>' +
                    '</td>' +
                    '</tr>');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف التعريف");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('حذف التعريف');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deletegd/'+ $('input[name=gd_tb]').val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text(),
            'flag':''
        },
        success: function(data){
            if(data.flag == "0") {
                $('.gdrows' + $('.id').text()).remove();
            }else if(data.flag == "1"){
                var str = $("#deleteconfid").val();
                $("#modal_body").html(str);
                $('#exampleModal').modal('show');
            }
        }
    });
});

// Show function
$(document).on('click', '.show-modal', function() {
    $('#show').modal('show');
    $('#i').text($(this).data('id'));
    $('#ti').text($(this).data('title'));
    $('.modal-title').text('Show Post');
});




