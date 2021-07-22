$(document).ready(function () {
    $(".selectionclient").select2({
        placeholder: "إختر إسم الزبون",
        allowClear: true
    });
});
$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#codate').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة عقد إيجار سيارة جديد');
    console.log($('input[name=client_id]').val())
});
$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/addcontract',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'client' : $('input[name=client_id]').val(),
            'cocode': '',
            'codate': $('input[name=codate]').val(),
            'cocars': '',
            'coamount': '',
            'cocurr': ''
        },
        success: function(data){
            // console.log(data)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                // $('#err_details_brname').remove()
                // $('#err_details_location').remove()
                // $('#err_details_landline').remove()
                // $('#err_details_mobile').remove()
                $('#table').append('<tr class="corrows' + data.id +'">'+
                    '<td style="display:none;">' + data.id + '</td>'+
                    '<td class="text-center" style="vertical-align: middle" width="100px">' + data.cocode  + '</td>'+
                    '<td class="text-center" style="vertical-align: middle" width="150px">' + data.codate  + '</td>'+
                    '<td class="text-center" style="vertical-align: middle" width="100px">' + data.cocars  + '</td>'+
                    '<td class="text-center" style="vertical-align: middle" width="150px">' + data.coamount  + '</td>'+
                    '<td class="text-center" style="vertical-align: middle" width="80px">' + data.cocurr  + '</td>'+
                    '<td class="text-center" >' +
                    '<a href="'+ $('#cdetails').val() + "/" + data.id +'" class="btn btn-info btn-sm" title="' + $('#t1').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-car"></i> </a>' + ' ' +
                    '<button class="create-modal-li btn btn-secondary btn-sm" title="' + $('#t2').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-id-card"></i> </button>' + ' ' +
                    '<button class="btn btn-success btn-sm" title="' + $('#t3').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-dollar-sign"></i> </button>' + '</td>'+
                    '<td class="text-center" >' +
                    '<button class="edit-modal btn btn-warning btn-sm" title="' + $('#t4').val() + '" data-id='+ data.id + ' data-cocode=' + data.cocode  + ' data-codate=' + data.codate +' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" title="' + $('#t5').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '</tr>');
                $("#create #client").val('').trigger('change')
                $('#codate').val('');

            }
        },
    });
});

// function Edit POST
$(document).on('click', '.edit-modal', function() {
    $('#footer_action_button').text(" تعديل");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('تعديل معلومات العقد');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    // console.log($(this).data('id'));
    $('#fid').val($(this).data('id'));
    $('#editcocode').val($(this).data('cocode'));
    // console.log($('#fid').val());
    getData($('#fid').val());
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'POST',
        url: '/editcodate/'+ $('#fid').val(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('#fid').val(),
            'cocode' : '',
            'codate': $('input[name=editcodate]').val(),
            'cocars': '',
            'coamount': '',
            'cocurr': ''
        },
        success: function(data) {
            if ((data.errors)) {
                // console.log(data);
                $.each(data.errors,function(key,val){
                    // $("#" + "err_details_" + key ).show()
                    // $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('.corrows' + data.id).replaceWith(" " +
                        '<tr class="corrows' + data.id +'">'+
                        '<td style="display:none;">' + data.id + '</td>'+
                        '<td class="text-center" style="vertical-align: middle" width="100px">' + data.cocode  + '</td>'+
                        '<td class="text-center" style="vertical-align: middle" width="150px">' + data.codate  + '</td>'+
                        '<td class="text-center" style="vertical-align: middle" width="100px">' + data.cocars  + '</td>'+
                        '<td class="text-center" style="vertical-align: middle" width="150px">' + data.coamount  + '</td>'+
                        '<td class="text-center" style="vertical-align: middle" width="80px">' + data.cocurr  + '</td>'+
                        '<td class="text-center" >' +
                        '<a href="'+ $('#cdetails').val() + "/" + data.id +'" class="btn btn-info btn-sm" title="' + $('#t1').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-car"></i> </a>' + ' ' +
                        '<button class="create-modal-li btn btn-secondary btn-sm" title="' + $('#t2').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-id-card"></i> </button>' + ' ' +
                        '<button class="btn btn-success btn-sm" title="' + $('#t3').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-dollar-sign"></i> </button>' + '</td>'+
                        '<td class="text-center" >' +
                        '<button class="edit-modal btn btn-warning btn-sm" title="' + $('#t4').val() + '" data-id='+ data.id + ' data-cocode=' + data.cocode  + ' data-codate=' + data.codate +' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                        '<button class="delete-modal btn btn-danger btn-sm" title="' + $('#t5').val() + '" data-id='+ data.id + ' data-title=' + data.cocode + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                        '</tr>');
                $('#create').modal('hide');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" نعم ");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('إالغاء عقد التأجير');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deletecontract',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text(),
            'flag':''
        },
        success: function(data){
            console.log(data.flag);
            if(data.flag == "0") {
                $('.corrows' + $('.id').text()).remove();
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
        url: '/getcodate/'+ gid,
        success: function(data) {
            // console.log(data.codate);
            $('#myModal #editcodate').val(data.codate);
        }
    });
}



// $('#myModal.select2').select2();

