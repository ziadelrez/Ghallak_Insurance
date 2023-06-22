$(document).ready(function () {
    $(".selection").select2({
        placeholder: "إختر مكان الفرع",
        allowClear: true
    });

    $(".selectionbrtype").select2({
        placeholder: "إختر نوع الفرع",
        allowClear: true
    });

});
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details_brname').hide()
    $('#err_details_location').hide()
    $('#err_details_landline').hide()
    $('#err_details_mobile').hide()
    $('#err_details_brtype').hide()
    $('#create #brname').val('');
    // $('#create #location').val('');
    $('#create #location').val('').trigger('change');
    $('#create #brtype').val('').trigger('change');
    $('#create #landline').val('');
    $('#create #mobile').val('');
    // $('#create #photo').val('');
    // document.getElementById('blah').src = "/files/images/no-photo.jpg";
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة فرع جديد');
    $('#brname').focus();
});
$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/addbranch',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'brname': $('input[name=brname]').val(),
            'location': $('#location option:selected').attr("value"),
            'landline': $('input[name=landline]').val(),
            'mobile': $('input[name=mobile]').val(),
            'brtype': $('#brtype option:selected').attr("value")
        },
        success: function(data){
            // console.log(data)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#err_details_brname').remove()
                $('#err_details_location').remove()
                $('#err_details_landline').remove()
                $('#err_details_mobile').remove()
                $('#err_details_brtype').remove()
                $('#table').append('<tr class="brrows' + data.id +'">'+
                    '<td style="display:none;">' + data.id + '</td>'+
                    '<td>' + data.brname  + '</td>'+
                    '<td>' + data.location + '</td>'+
                    '<td>' + data.brtype + '</td>'+
                    '<td class="text-center" >' +
                    '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.brname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.brname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '<td class="text-center" >' +
                    '<a href="'+ $('#userlist').val() + "/" + data.id +'" class="btn btn-info btn-sm" data-id='+ data.id + ' data-title=' + data.brname + ' ><i class="fa fa-users"></i> </a>' + '</td>'+
                    '</tr>');
                $('#brname').val('');
                $("#create #location").val('').trigger('change')
                $('#landline').val('');
                $('#mobile').val('');
                $("#create #brtype").val('').trigger('change')
                $('#brname').focus();
            }
        },
    });
});

// function Edit POST
$(document).on('click', '.edit-modal', function() {
    $('#myModal #editbrname').val('');
    $("#myModal #editlocation").val('').trigger('change')
    $('#myModal #editlandline').val('');
    $('#myModal #editmobile').val('');
    $("#myModal #editbrtype").val('').trigger('change')
    $('#footer_action_button').text(" تعديل");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('تعديل معلومات الفرع');
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
        url: '/editbranches/'+ $("#fid").val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $("#fid").val(),
            'brname': $('input[name=editbrname]').val(),
            'location': $('#myModal #editlocation option:selected').attr("value"),
            'landline': $('input[name=editlandline]').val(),
            'mobile': $('input[name=editmobile]').val(),
            'brtype': $('#myModal #editbrtype option:selected').attr("value"),
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
                        '<td>' + data.brname  + '</td>'+
                        '<td>' + data.location + '</td>'+
                        '<td>' + data.brtype + '</td>'+
                        '<td class="text-center" >' +
                        '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.brname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                        '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.brname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                        '<td class="text-center" >' +
                        '<a href="'+ $('#userlist').val() + "/" + data.id +'" class="btn btn-info btn-sm" data-id='+ data.id + ' data-title=' + data.brname + ' ><i class="fa fa-users"></i> </a>' + '</td>'+
                        '</tr>');
                $('#create').modal('hide');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف الفرع");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('حذف الفرع');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deletebr',
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
        url: '/getbrdetails/'+ gid,
        success: function(data) {
            // console.log(data.locationdb);
            $('#myModal #editbrname').val(data.brname);
            $('#myModal #editlocation').select2('data', {id: data.brlocid, a_key: data.brlocname}).change();
            // $('#myModal #editlocation').val(data.locname);
            $('#myModal #editlandline').val(data.brlandline);
            $('#myModal #editmobile').val(data.brmobile);
            $('#myModal #editbrtype').select2('data', {id: data.brtypeid, a_key: data.brtype}).change();
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

