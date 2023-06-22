$(document).on('click','.create-modal-li', function() {
    $('#tablemodal').empty();
    $('#createdriver').modal('show');
    $('#adddrivericon').text(" حفظ البيانات");
    $('#adddrivericon').addClass('fa-plus');
    $('#err_details_person').hide()
    $('#err_details_linum').hide()
    $('#person').val('');
    $('#linum').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('إضافة سائق على العقد');
    $('#person').focus();
    $('#contract_id_1').val($(this).data('id'));
    $('#cflag').val('0');
    $("#liplace").val('').trigger('change')
    $('#lidate').val('');
    $('#lblcocode').val($(this).data('title'));
    getdrivers($(this).data('id'));
    // console.log($(this).data('id'));

});

function getdrivers(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getlinum',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contid' : ccid ,
            'person': '',
            'linum': ''
        },
        dataType:'json',
        success: function(data){
            // console.log(data.length)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    // console.log(val[0]);
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#tablemodal').html(data.li_data);
                if(data.rflag == "1"){
                    document.getElementById("noresult").style.display = "none";
                }
            }
        },
    });
}
$("#adddriver").click(function() {
    var cflag = $('#cflag').val();
    if (cflag == "0") {
        $.ajax({
            type: 'POST',
            url: '/adddriver',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'contid': $('input[name=contract_id_1]').val(),
                'id': '',
                'person': $('input[name=person]').val(),
                'linum': $('input[name=linum]').val(),
                'liplace': $('#liplace option:selected').attr("value"),
                'lidate': $('input[name=lidate]').val(),
            },
            success: function (data) {
                // console.log(data)
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        // console.log(val[0]);
                        $("#" + "err_details_" + key).show()
                        $("#" + "err_details_" + key).text(val[0]);
                    });
                } else {
                    document.getElementById("noresult").style.display = "none";
                    // console.log(data)
                    $('#tablemodal').append('<tr class="lirows' + data.id + '">' +
                        '<td style="display:none;">' + data.id + '</td>' +
                        '<td class="text-center" width="600px">' + data.person + '</td>' +
                        '<td class="text-center" width="400px">' + data.linum + '</td>' +
                        '<td class="text-center" width="250px" >' +
                        '<button type="button" class="edit-modal-li btn btn-warning btn-sm" data-id="' + data.id + '" data-person="' + data.person + '" data-linum="' + data.linum + '" > <i class="fa fa-edit"></i> </button>' + ' ' +
                        '<button type="button" class="delete-modal-li btn btn-danger btn-sm" data-id="' + data.id + '" > <i class="fa fa-trash"></i> </button>' + '</td>' +
                        '</tr>');
                    $('#person').val('');
                    $('#linum').val('');
                    $("#liplace").val('').trigger('change')
                    $('#lidate').val('');
                    $('#person').focus();
                }
            },
        });
    }else if (cflag == "1") {
        // console.log($(this).data('id'));
        $.ajax({
            type: 'POST',
            url: '/editdriver',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $('input[name=liid]').val(),
                'person': $('input[name=person]').val(),
                'linum': $('input[name=linum]').val(),
                'liplace': $('#liplace option:selected').attr("value"),
                'lidate': $('input[name=lidate]').val(),
            },
            success: function(data) {
                if ((data.errors)) {
                    $.each(data.errors,function(key,val){
                        $("#" + "err_details_" + key ).show()
                        $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('.lirows' + data.id).replaceWith(" " +
                        '<tr class="lirows' + data.id +'">'+
                        '<td style="display:none;">' + data.id + '</td>' +
                        '<td class="text-center" width="600px">' + data.person + '</td>' +
                        '<td class="text-center" width="400px">' + data.linum + '</td>' +
                        '<td class="text-center" width="250px" >' +
                        '<button type="button" class="edit-modal-li btn btn-warning btn-sm" data-id="' + data.id + '" data-person="' + data.person + '" data-linum="' + data.linum + '" > <i class="fa fa-edit"></i> </button>' + ' ' +
                        '<button type="button" class="delete-modal-li btn btn-danger btn-sm" data-id="' + data.id + '" > <i class="fa fa-trash"></i> </button>' + '</td>' +
                        '</tr>');
                    $('#person').val('');
                    $('#linum').val('');
                    $('#cflag').val('0');
                    $('#liid').val('');
                    $("#liplace").val('').trigger('change')
                    $('#lidate').val('');
                    $('#person').focus();
                }
            }
        });
    }
});

$(document).on('click', '.edit-modal-li', function() {
    $('#cflag').val('1');
    $('#liid').val($(this).data('id'));
    $('#person').val($(this).data('person'));
    $('#linum').val($(this).data('linum'));
    $.ajax({
        type: 'GET',
        url: '/getlidetails',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contid': $('input[name=contract_id_1]').val(),
            'liid': $(this).data('id'),
            'person': '',
            'linum': '',
            'liplaceid': '',
            'liplacename': '',
            'lidate': '',
        },
        success: function(data) {
            $('#liplace').select2('data', {id: data.liplaceid, a_key: data.liplacename}).change();
            $('#lidate').val(data.lidate);
            $('#adddrivericon').text(" تعديل");
            $('#adddrivericon').addClass('fa-check');
            $('#adddrivericon').removeClass('fa-plus');
        }
    });
});

$('#tablemodal').on('click', '.delete-modal-li', function() {
    $('#liid').val($(this).data('id'));
    $.ajax({
        type: 'POST',
        url: '/deletedriver',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('input[name=liid]').val()
        },
        success: function(data){
            getdrivers( $('#contract_id_1').val());
        }
    });
    $('#person').val('');
    $('#linum').val('');
    $('#cflag').val('0');
    $('#liid').val('');
    $("#liplace").val('').trigger('change')
    $('#lidate').val('');
    $('#person').focus();
});

function go(a, b, e, elt) {


    var $parent_form = $('#' + e).closest('.form-group');
    var parent_id = $parent_form.attr('data-label');

    // console.log($parent_form);

    $.ajax({
        type: "POST",
        url: $("#def_quick_add").val(),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            tid: parent_id,
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
