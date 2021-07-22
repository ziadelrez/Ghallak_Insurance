$(document).ready(function () {
    $(".selectionlocation1").select2({
        placeholder: "إختر اسم المنطقة",
        allowClear: true
    });

    $(".selectionlocation2").select2({
        placeholder: "إختر اسم المنطقة",
        allowClear: true
    });

    $(".selectionlocation3").select2({
        placeholder: "إختر اسم المنطقة",
        allowClear: true
    });

    $(".selectionacccurr1").select2({
        placeholder: "العملة",
        allowClear: true
    });


    getaccident($('#contdetid').val());
    getspeed($('#contdetid').val());
    getfailure($('#contdetid').val());
});

$(document).on('click', '.edit-btn', function(){
    clearaccident();
    $('#cflag').val('1');
    $('#accid').val($(this).data('id'));
    $('#saveaccident').text("تعديل البيانات");
    $('#location1').select2('data', {id: $(this).data('locid1'), a_key: $(this).data('locname1')}).change();
    $('#actiondate1').val($(this).data('accdate1'));
    $('#actiondetails1').val($(this).data('accdetails1'));
    $('#actioncost1').val($(this).data('acccost1'));
    $('#actioncurr1').select2('data', {id: $(this).data('acccurrid1'), a_key: $(this).data('acccurrname1')}).change();
});

$(document).on('click', '.edit-btn-speed', function(){
    clearspeed();
    $('#cflagspeed').val('1');
    $('#speedid').val($(this).data('id'));
    $('#savespeed').text("تعديل البيانات");
    $('#location2').select2('data', {id: $(this).data('locid2'), a_key: $(this).data('locname2')}).change();
    $('#actiondate2').val($(this).data('accdate2'));
    $('#actiondetails2').val($(this).data('accdetails2'));
    $('#actioncost2').val($(this).data('acccost2'));
    $('#actioncurr2').select2('data', {id: $(this).data('acccurrid2'), a_key: $(this).data('acccurrname2')}).change();
});

$(document).on('click', '.edit-btn-failure', function(){
    clearfailure();
    $('#cflagfailure').val('1');
    $('#failureid').val($(this).data('id'));
    $('#savefailure').text("تعديل البيانات");
    $('#location3').select2('data', {id: $(this).data('locid3'), a_key: $(this).data('locname3')}).change();
    $('#actiondate3').val($(this).data('accdate3'));
    $('#actiondetails3').val($(this).data('accdetails3'));
    $('#actioncost3').val($(this).data('acccost3'));
    $('#actioncurr3').select2('data', {id: $(this).data('acccurrid3'), a_key: $(this).data('acccurrname3')}).change();
});

$(document).on('click', '.delete-btn', function() {
    $('#accid').val($(this).data('id'));
    $.ajax({
        type: 'POST',
        url: '/deleteprocedure',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('input[name=accid]').val()
        },
        success: function(data){
            getaccident($('#contdetid').val());
            clearaccident();
        }
    });
});

$(document).on('click', '.delete-btn-speed', function() {
    $('#speedid').val($(this).data('id'));
    $.ajax({
        type: 'POST',
        url: '/deleteprocedure',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('input[name=accid]').val()
        },
        success: function(data){
            getspeed($('#contdetid').val());
            clearspeed();
        }
    });
});

$(document).on('click', '.delete-btn-failure', function() {
    $('#failureid').val($(this).data('id'));
    $.ajax({
        type: 'POST',
        url: '/deleteprocedure',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $('input[name=accid]').val()
        },
        success: function(data){
            getfailure($('#contdetid').val());
            clearfailure();
        }
    });
});

$(document).on('click', '#clearaccident', function(){
    clearaccident();
});

$(document).on('click', '#clearspeed', function(){
    clearspeed();
});

$(document).on('click', '#clearfailure', function(){
    clearfailure();
});

$(document).on('click', '#saveaccident', function(){
    var cflag = $('#cflag').val();
    if (cflag == "0") {
        $.ajax({
            type: 'POST',
            url: '/storeaccident',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'contdetid': $('#contdetid').val(),
                'location1': $('#location1 option:selected').attr("value"),
                'actiondate1': $('input[name=actiondate1]').val(),
                'actiondetails1': $('textarea[name=actiondetails1]').val(),
                'actioncost1': $('input[name=actioncost1]').val(),
                'actioncurr1': $('#actioncurr1 option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_location1').remove()
                    $('#err_details_actiondate1').remove()
                    $('#err_details_actiondetails1').remove()
                    $('#err_details_actioncost1').remove()
                    $('#err_details_actioncurr1').remove()
                    getaccident($('#contdetid').val());
                    clearaccident();
                }
            }
        });
    }else if (cflag == "1") {
        $.ajax({
            type: 'POST',
            url: '/editaccident',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $('input[name=accid]').val(),
                'location1': $('#location1 option:selected').attr("value"),
                'actiondate1': $('input[name=actiondate1]').val(),
                'actiondetails1': $('textarea[name=actiondetails1]').val(),
                'actioncost1': $('input[name=actioncost1]').val(),
                'actioncurr1': $('#actioncurr1 option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_location1').remove()
                    $('#err_details_actiondate1').remove()
                    $('#err_details_actiondetails1').remove()
                    $('#err_details_actioncost1').remove()
                    $('#err_details_actioncurr1').remove()
                    getaccident($('#contdetid').val());
                    clearaccident();
                }
            }
        });
    }
});

$(document).on('click', '#savespeed', function(){
    var cflag = $('#cflagspeed').val();
    if (cflag == "0") {
        $.ajax({
            type: 'POST',
            url: '/storespeed',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'contdetid': $('#contdetid').val(),
                'location2': $('#location2 option:selected').attr("value"),
                'actiondate2': $('input[name=actiondate2]').val(),
                'actiondetails2': $('textarea[name=actiondetails2]').val(),
                'actioncost2': $('input[name=actioncost2]').val(),
                'actioncurr2': $('#actioncurr2 option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_location2').remove()
                    $('#err_details_actiondate2').remove()
                    $('#err_details_actiondetails2').remove()
                    $('#err_details_actioncost2').remove()
                    $('#err_details_actioncurr2').remove()
                    getspeed($('#contdetid').val());
                    clearspeed();
                }
            }
        });
    }else if (cflag == "1") {
        $.ajax({
            type: 'POST',
            url: '/editspeed',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $('input[name=accid]').val(),
                'location2': $('#location2 option:selected').attr("value"),
                'actiondate2': $('input[name=actiondate2]').val(),
                'actiondetails2': $('textarea[name=actiondetails2]').val(),
                'actioncost2': $('input[name=actioncost2]').val(),
                'actioncurr2': $('#actioncurr2 option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_location2').remove()
                    $('#err_details_actiondate2').remove()
                    $('#err_details_actiondetails2').remove()
                    $('#err_details_actioncost2').remove()
                    $('#err_details_actioncurr2').remove()
                    getspeed($('#contdetid').val());
                    clearspeed();
                }
            }
        });
    }
});

$(document).on('click', '#savefailure', function(){
    var cflag = $('#cflagfailure').val();
    if (cflag == "0") {
        $.ajax({
            type: 'POST',
            url: '/storefailure',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'contdetid': $('#contdetid').val(),
                'location3': $('#location3 option:selected').attr("value"),
                'actiondate3': $('input[name=actiondate3]').val(),
                'actiondetails3': $('textarea[name=actiondetails3]').val(),
                'actioncost3': $('input[name=actioncost3]').val(),
                'actioncurr3': $('#actioncurr3 option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_location3').remove()
                    $('#err_details_actiondate3').remove()
                    $('#err_details_actiondetails3').remove()
                    $('#err_details_actioncost3').remove()
                    $('#err_details_actioncurr3').remove()
                    getfailure($('#contdetid').val());
                    clearfailure();
                }
            }
        });
    }else if (cflag == "1") {
        $.ajax({
            type: 'POST',
            url: '/editfailure',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $('input[name=accid]').val(),
                'location3': $('#location3 option:selected').attr("value"),
                'actiondate3': $('input[name=actiondate3]').val(),
                'actiondetails3': $('textarea[name=actiondetails3]').val(),
                'actioncost3': $('input[name=actioncost3]').val(),
                'actioncurr3': $('#actioncurr3 option:selected').attr("value"),
            },
            success: function (data) {
                if ((data.errors)) {
                    $.each(data.errors, function (key, val) {
                        $("#" + "err_details_" + key).show()
                        // $("#" + "err_details_" + key ).text(val[0]);
                    });
                } else {
                    $('#err_details_location3').remove()
                    $('#err_details_actiondate3').remove()
                    $('#err_details_actiondetails3').remove()
                    $('#err_details_actioncost3').remove()
                    $('#err_details_actioncurr3').remove()
                    getfailure($('#contdetid').val());
                    clearfailure();
                }
            }
        });
    }
});

function clearaccident(){
    $('#err_details_location1').hide()
    $('#err_details_actiondate1').hide()
    $('#err_details_actiondetails1').hide()
    $('#err_details_actioncost1').hide()
    $('#err_details_actioncurr1').hide()

    $('#location1').val('').trigger('change');
    $("#actiondate1").val('');
    $('#actiondetails1').val('-');
    $('#actioncost1').val('0');
    $('#actioncurr1').val('').trigger('change');
    $('#cflag').val('0');
    $('#saveaccident').text("حفظ البيانات");


}

function clearspeed(){
    $('#err_details_location2').hide()
    $('#err_details_actiondate2').hide()
    $('#err_details_actiondetails2').hide()
    $('#err_details_actioncost2').hide()
    $('#err_details_actioncurr2').hide()

    $('#location2').val('').trigger('change');
    $("#actiondate2").val('');
    $('#actiondetails2').val('-');
    $('#actioncost2').val('0');
    $('#actioncurr2').val('').trigger('change');
    $('#cflagspeed').val('0');
    $('#savespeed').text("حفظ البيانات");

}

function clearfailure(){
    $('#err_details_location3').hide()
    $('#err_details_actiondate3').hide()
    $('#err_details_actiondetails3').hide()
    $('#err_details_actioncost3').hide()
    $('#err_details_actioncurr3').hide()

    $('#location3').val('').trigger('change');
    $("#actiondate3").val('');
    $('#actiondetails3').val('-');
    $('#actioncost3').val('0');
    $('#actioncurr3').val('').trigger('change');
    $('#cflagfailure').val('0');
    $('#savefailure').text("حفظ البيانات");


}

function getaccident(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getaccidentlist',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contdetid' : ccid
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
                $('#tableaccident').html(data.accident_data);
                if(data.rflag == "1"){
                    document.getElementById("noresult").style.display = "none";
                }
            }
        },
    });
}

function getspeed(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getspeedlist',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contdetid' : ccid
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
                $('#tablespeed').html(data.speed_data);
                if(data.rflagspeed == "1"){
                    document.getElementById("noresultspeed").style.display = "none";
                }
            }
        },
    });
}

function getfailure(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getfailurelist',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'contdetid' : ccid
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
                $('#tablefailure').html(data.failure_data);
                if(data.rflagfailure == "1"){
                    document.getElementById("noresultfailure").style.display = "none";
                }
            }
        },
    });
}

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

// $('#myModal.select2').select2();

