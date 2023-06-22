$(document).ready(function () {
    $(".selection").select2({
        placeholder: "إختر فئة التأمين",
        allowClear: true
    });
});
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details_instype').hide()
    $('#err_details_insname').hide()
    $('#err_details_details').hide()
    $('#create #insname').val('');
    $('#create #instype').val('').trigger('change');
    $('#create #details').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة تأمين جديد');
    $('#brname').focus();
});
$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/addinsname',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'insname': $('input[name=insname]').val(),
            'instype': $('#instype option:selected').attr("value"),
            'details': $('input[name=details]').val(),
        },
        success: function(data){
            // console.log(data)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#err_details_insname').remove()
                $('#err_details_instype').remove()
                $('#err_details_details').remove()
                $('#table').append('<tr class="brrows' + data.id +'">'+
                    '<td style="display:none;">' + data.id + '</td>'+
                    '<td>' + data.instype  + '</td>'+
                    '<td>' + data.insname  + '</td>'+
                    '<td class="text-center" >' +
                    '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.insname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.insname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '</tr>');
                $('#insname').val('');
                $("#create #instype").val('').trigger('change')
                $('#details').val('');
                $('#instype').focus();
            }
        },
    });
});

// function Edit POST
$(document).on('click', '.edit-modal', function() {
    $('#myModal #editinsname').val('');
    $("#myModal #editinstype").val('').trigger('change')
    $('#myModal #editdetails').val('');
    $('#footer_action_button').text(" تعديل");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('تعديل معلومات التأمين');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    // console.log($(this).data('id'));
    $('#fid').val($(this).data('id'));
    getData($(this).data('id'));
    $('#myModal').modal('show');
    // console.log($('#fid').val())
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'POST',
        url: '/editinsname/'+ $("#fid").val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $("#fid").val(),
            'insname': $('input[name=editinsname]').val(),
            'instype': $('#myModal #editinstype option:selected').attr("value"),
            'details': $('input[name=editdetails]').val()
        },
        success: function(data) {
            if ((data.errors)) {
                // console.log(data);
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                // console.log($('#userlist').val());
                $('.brrows' + data.id).replaceWith(" " +
                        '<tr class="brrows' + data.id +'">'+
                        '<td style="display:none;">' + data.id + '</td>'+
                        '<td>' + data.instype  + '</td>'+
                        '<td>' + data.insname  + '</td>'+
                        '<td class="text-center" >' +
                        '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.insname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                        '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.insname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                        '</tr>');
                $('#create').modal('hide');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف التأمين");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('حذف التأمين');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deleteinsname',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text(),
            'flag':''
        },
        success: function(data){
            if(data.flag == "0") {
                $('.brrows' + $('.id').text()).remove();
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
        url: '/getinsdetails/'+ gid,
        success: function(data) {
            // console.log(data.locationdb);
            $('#myModal #editinsname').val(data.insname);
            $('#myModal #editinstype').select2('data', {id: data.instypeid, a_key: data.instype}).change();
            // $('#myModal #editlocation').val(data.locname);
            $('#myModal #editdetails').val(data.details);
            // $("#myModal .btn-success").attr("gid",gid)
        }
    });
}

function go(a, b, e, elt) {


    var $parent_form = $('#' + e).closest('.form-group');
    // var parent_id = $parent_form.attr('data-label');

    // console.log($parent_form);

    $.ajax({
        type: "POST",
        url: $("#general_def_quick").val(),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#photo").change(function(){
    readURL(this);
});

// $('#myModal.select2').select2();

