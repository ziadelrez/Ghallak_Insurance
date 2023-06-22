$(document).ready(function () {
    $(".selectioncurrcost").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selection").select2({
        placeholder: "إختر المنطقة",
        allowClear: true
    });

    $(".selectioninsname").select2({
        placeholder: "إختر إسم التأمين",
        allowClear: true
    });
});
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details_compname').hide()
    $('#err_details_contactperson').hide()
    $('#err_details_region').hide()
    $('#err_details_adr').hide()
    $('#err_details_mob').hide()
    $('#err_details_land').hide()
    $('#err_details_fax').hide()
    $('#err_details_email').hide()
    $('#err_details_website').hide()
    $('#create #compname').val('');
    $('#create #contactperson').val('-');
    $('#create #adr').val('-');
    $('#create #region').val('').trigger('change');
    $('#create #mob').val('');
    $('#create #land').val('');
    $('#create #fax').val('-');
    $('#create #email').val('-');
    $('#create #website').val('-');
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة شركة تأمين جديدة');
    $('#compname').focus();
});
$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/addcompany',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'compname': $('input[name=compname]').val(),
            'contactperson': $('input[name=contactperson]').val(),
            'adr': $('input[name=adr]').val(),
            'region': $('#region option:selected').attr("value"),
            'mob': $('input[name=mob]').val(),
            'land': $('input[name=land]').val(),
            'fax': $('input[name=fax]').val(),
            'email': $('input[name=email]').val(),
            'website': $('input[name=website]').val()
        },
        success: function(data){
            // console.log(data)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#err_details_compname').remove()
                $('#err_details_contactperson').remove()
                $('#err_details_region').remove()
                $('#err_details_adr').remove()
                $('#err_details_mob').remove()
                $('#err_details_land').remove()
                $('#err_details_fax').remove()
                $('#err_details_email').remove()
                $('#err_details_website').remove()
                $('#table').append('<tr class="brrows' + data.id +'">'+
                    '<td style="display:none;">' + data.id + '</td>'+
                    '<td>' + data.compname  + '</td>'+
                    '<td class="text-center" >' +
                    '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.compname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.compname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '<td class="text-center" >' +
                    '<a href="'+ $('#inslist').val() + "/" + data.id +'" class="btn btn-primary btn-sm" data-id='+ data.id + ' data-title=' + data.compname + ' ><i class="fa fa-shield-alt"></i> </a>' + '</td>'+
                    '</tr>');
                $('#compname').val('');
                $('#contactperson').val('-');
                $('#adr').val('-');
                $('#create #region').val('').trigger('change');
                $('#mob').val('');
                $('#land').val('');
                $('#fax').val('-');
                $('#email').val('-');
                $('#website').val('-');
                $('#compname').focus();
            }
        },
    });
});

// function Edit POST
$(document).on('click', '.edit-modal', function() {
    $('#myModal #editcompname').val('');
    $('#myModal #editcontactperson').val('');
    $("#myModal #editregion").val('').trigger('change')
    $('#myModal #editadr').val('');
    $('#myModal #editmob').val('');
    $('#myModal #editland').val('');
    $('#myModal #editfax').val('');
    $('#myModal #editemail').val('');
    $('#myModal #editwebsite').val('');
    $('#footer_action_button').text(" تعديل");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('تعديل معلومات شركة التأمين');
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
        url: '/editcompany/'+ $("#fid").val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $("#fid").val(),
            'compname': $('input[name=editcompname]').val(),
            'contactperson': $('input[name=editcontactperson]').val(),
            'region': $('#myModal #editregion option:selected').attr("value"),
            'adr': $('input[name=editadr]').val(),
            'mob': $('input[name=editmob]').val(),
            'land': $('input[name=editland]').val(),
            'fax': $('input[name=editfax]').val(),
            'email': $('input[name=editemail]').val(),
            'website': $('input[name=editwebsite]').val(),
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
                        '<td>' + data.compname  + '</td>'+
                        '<td class="text-center" >' +
                        '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.compname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                        '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.compname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                        '<td class="text-center" >' +
                        '<a href="'+ $('#inslist').val() + "/" + data.id +'" class="btn btn-primary btn-sm" data-id='+ data.id + ' data-title=' + data.compname + ' ><i class="fa fa-shield-alt"></i> </a>' + '</td>'+
                        '</tr>');
                $('#create').modal('hide');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف شركة الـتأمين");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('حذف شركة التأمين');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deletecompany',
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
        url: '/getcompanydetails/'+ gid,
        success: function(data) {
            // console.log(data.locationdb);
            $('#myModal #editcompname').val(data.compname);
            $('#myModal #editcontactperson').val(data.contactperson);
            $('#myModal #editregion').select2('data', {id: data.region, a_key: data.regionname}).change();
            $('#myModal #editadr').val(data.adr);
            $('#myModal #editmob').val(data.mob);
            $('#myModal #editland').val(data.land);
            $('#myModal #editfax').val(data.fax);
            $('#myModal #editemail').val(data.email);
            $('#myModal #editwebsite').val(data.website);
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

