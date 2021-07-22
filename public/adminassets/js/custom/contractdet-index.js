$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details').hide();
    $('#title').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('بيانات تسليم السيارة');
    $('#title').focus();
    getinfo($(this).data('id'))
    $('#contdet_id').val($(this).data('id'));
    $('#car_id').val($(this).data('carid'));
});
function getinfo(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getcontdetinfo',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contdetid' : ccid ,
            'officedatein' : '',
            'officetimein' : '',
            'hcost' : '',
            'extratime' : '',
            'extracost' : '',
            'carback' : '',

        },
        dataType:'json',
        success: function(data){
            // console.log(data.length)
            if ((data.errors)) {

            } else {
                // console.log(data.officedatein + data.hcost);
                $('#create #officedatein').val(data.officedatein);
                $('#create #officetimein').val(data.officetimein);
                $('#create #hcost').val(data.hcost);
                $('#create #extratime').val(data.extratime);
                $('#create #extracost').val(data.extracost);
                // $('#create #carback').val(data.carback ? true : false);
                $('#create #carback').prop("checked", data.carback == '1');
            }
        },
    });
}
$("#add").click(function() {
    // console.log($('#contdet_id').val());
    if ($('input[name=carback]').prop('checked')){
        $chk_status = "1";
    }else{
        $chk_status = "0";
    }
    // console.log($chk_status);
    $.ajax({
        type: 'POST',
        url: '/updatecontdetinfo' ,
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'carid' : $('#car_id').val() ,
            'contdetid' : $('#contdet_id').val() ,
            'officedatein' : $('input[name=officedatein]').val(),
            'officetimein' : $('input[name=officetimein]').val(),
            'hcost' : $('input[name=hcost]').val(),
            'extratime' : $('input[name=extratime]').val(),
            'extracost' : $('input[name=extracost]').val(),
            'carback' : $chk_status,
        },
        success: function(data){
            if ((data.errors)) {
                console.log(data.errors)
                // $('#err_details').show()
                // $('#err_details').text(data.errors.title);
                // $('.error').removeClass('hidden');
                // $('.error').text(data.errors.title);
            } else {
                $('#create').modal('hide');
            }
        },
    });
});
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف بيانات تفاصيل العقد");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text(" حذف بيانات تفاصيل العقد");
    $('.id').text($(this).attr('data-id'));
    $("#car_id").val($(this).data('carid'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/contract-car-details/delete/'+ $('.id').text(),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('.id').text(),
            'cont-id':  $("#contid_id").val(),
            'car-id':  $("#car_id").val(),
            'flag':''
        },
        success: function(data){
            // console.log(data.flag);
            if(data.flag == "0") {
                $('.codetrrows' + $('.id').text()).remove();
            }else if(data.flag == "1"){
                // console.log(data.flag);
                var str = $("#deleteconfid").val();
                $("#modal_body").html(str);
                $('#exampleModal').modal('show');
            }
            // console.log($('.id').text());
        }
    });
});


