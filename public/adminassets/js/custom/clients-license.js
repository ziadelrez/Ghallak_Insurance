$(document).ready(function () {
    $(".selection").select2({
        placeholder: "إختر مكان الاصدار",
        allowClear: true
    });
});
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details_driver').hide()
    $('#err_details_linum').hide()
    $('#err_details_place').hide()
    $('#err_details_lidate').hide()
    $('#driver').val('');
    // $('#clid').val('');
    // $('#clid').val($('input[name=clid]').val());
    $('#linum').val('');
    $('#place').val('');
    $('#lidate').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة رخصة قيادة');
    $('#driver').focus();
});
$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/addlicense',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'drivername': $('input[name=driver]').val(),
            'client': $('input[name=clid]').val(),
            'lnum': $('input[name=linum]').val(),
            'place': $('#place option:selected').attr("value"),
            'dateend': $('input[name=lidate]').val()
        },
        success: function(data){
            // console.log(data)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#err_details_driver').remove()
                $('#err_details_linum').remove()
                $('#err_details_place').remove()
                $('#err_details_lidate').remove()
                // console.log(data)
                $('#table').append('<tr class="lirows' + data.id +'">'+
                    '<td style="display:none;">' + data.id + '</td>'+
                    '<td>' + data.drivername + '</td>'+
                    '<td>' + data.lnum + '</td>'+
                    '<td>' + data.place + '</td>'+
                    '<td>' + data.dateend + '</td>'+
                    '<td class="text-center" >' +
                    '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.drivername + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.drivername + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '</tr>');
                $('#driver').val('');
                $("#create #place").val('').trigger('change')
                $('#linum').val('');
                $('#lidate').val('');
                $('#driver').focus();
            }
        },
    });
});

// function Edit POST
$(document).on('click', '.edit-modal', function() {
    $('#myModal #editdriver').val('');
    $("#myModal #editplace").val('').trigger('change')
    $('#myModal #editlinum').val('');
    $('#myModal #editlidate').val('');
    $('#footer_action_button').text(" تعديل");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('تعديل معلومات رخص القيادة');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    // console.log($(this).data('id'));
    $('#editliid').val($(this).data('id'));
    getData($(this).data('id'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'POST',
        url: '/editlicense/'+ $("#editliid").val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $("#editliid").val(),
            'drivername': $('input[name=editdriver]').val(),
            'lnum': $('input[name=editlinum]').val(),
            'place': $('#myModal #editplace option:selected').attr("value"),
            'dateend': $('input[name=editlidate]').val(),
        },
        success: function(data) {
            if ((data.errors)) {
                // console.log(data);
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                // console.log( $('.lirows' + data.id));
                $('.lirows' + data.id).replaceWith(" " +
                        '<tr class="lirows' + data.id +'">'+
                        '<td style="display:none;">' + data.id + '</td>'+
                        '<td>' + data.drivername + '</td>'+
                        '<td>' + data.lnum + '</td>'+
                        '<td>' + data.place + '</td>'+
                        '<td>' + data.dateend + '</td>'+
                        '<td class="text-center" >' +
                        '<button class="edit-modal btn btn-warning btn-sm" title="تعديل بيانات رخصة القيادة" data-id='+ data.id + ' data-title=' + data.drivername + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                        '<button class="delete-modal btn btn-danger btn-sm" title="حذف بيانات رخصة القيادة" data-id='+ data.id + ' data-title=' + data.drivername + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                        '</tr>');
                $('#create').modal('hide');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف رخصة القيادة");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text(" حذف رخصة القيادة");
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deletelicense/'+ $('.id').text(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text()
        },
        success: function(data){
            $('.lirows' + $('.id').text()).remove();
            // console.log($('.id').text());
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
// $.ajax({
//     type: 'GET',
//     url: '/getbrdetails/'+ $(this).data('id'),
//     success: function(data) {
//         console.log(data.brname);
//         $("input[name='editbrname']").val(data.brname);
//         $("input[name='editlocation']").val(data.locname);
//         // $("#editbrname").html(data.brname);
//         // $("#editlocation").html(data.locname);
//         // $("#editlandline").html(data.brlandline);
//         // $("#editmobile").html(data.brmobile);
//         $("input[name='editlandline']").val(data.brlandline);
//         $("input[name='editmobile']").val(data.brmobile);
//     }
// });
function getData(gid) {
    $.ajax({
        type: 'GET',
        url: '/getlicensedetails/'+ gid,
        success: function(data) {
            $('#myModal #editdriver').val(data.drivername);
            $('#myModal #editliid').val(data.id);
            $('#myModal #editlinum').val(data.lnum);
            $('#myModal #editplace').select2('data', {id: data.placeid, a_key: data.placename}).change();
            $('#myModal #editlidate').val(data.dateend);
            // $("#myModal .btn-success").attr("gid",gid)
        }
    });
}

function go(a, b, e, elt) {


    var $parent_form = $('#' + e).closest('.form-group');
    // var parent_id = $(#myModal #parent_form).attr('data-label');

    // console.log($parent_form);

    $.ajax({
        type: "POST",
        url: $("#def_quick_add_place").val(),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            // tid: parent_id,
            description: b,
        },
        beforeSend: function () {
            $(a).html('جاري التنفيذ .....');
        },
    }).done(function (data) {
        // console.log(data.id + ' , ' + b);
        $parent_form.children('select').append("<option value='" + data.id + "'>" + b + "</option>")
        $parent_form.children('select').select2("destroy");
        $parent_form.children('select').select2();
        $parent_form.children('select').select2("val", data.id);
        $parent_form.children('select').select2("close");
        $parent_form.children('select').select2("close");
        $(a).html('<i class="fa fa-plus-circle"></i> أضافة جديدة');
    });

}

// $('#myModal.select2').select2();

