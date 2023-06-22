$(document).ready(function () {
    $(".selectioncompname").select2({
        placeholder: "إختر اسم شركة التأمين",
        allowClear: true
    });

    $(".selectioninsname").select2({
        placeholder: "إختر اسم التأمين",
        allowClear: true
    });

    $(".selectioncountry").select2({
        placeholder: "إختر اسم مكان السفر",
        allowClear: true
    });

    $(".selectioncarname").select2({
        placeholder: "إختر اسم السيارة",
        allowClear: true
    });

    $(".selectionfollowby").select2({
            placeholder: "إختر اسم معقب المعاملة",
            allowClear: true
        });

    $(".selectionmaid").select2({
        placeholder: "إختر اسم عاملة المنزل",
        allowClear: true
    });

    $(".selectioncurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectiondepcurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

    $(".selectionoffice").select2({
        placeholder: "إختر المكتب",
        allowClear: true
    });

    $(".selectionbroker").select2({
        placeholder: "إختر الوسيط",
        allowClear: true
    });


    if ( $('#flag').val() == 1) {
        getinsuranceslist();
        getDatainsname($('#contdetid').val());
        // getcurrinsurance();
    }

});

$(document).on('change', '#insname', function(){
    if ($('#flag').val() == 0) {
        $('#curr').empty();
        $idins = $('#insname option:selected').attr("value");
        $idcomp = $('#compname option:selected').attr("value");
        $.ajax({
            type: 'POST',
            url: '/getinsrate',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'idins': $idins,
                'idcomp': $idcomp,
                'cost': '',
                'curr': '',
                'currname': ''
            },
            success: function (data) {
                if ((data.errors)) {
                    $('#totalcost').val('0');
                    $('#curr').empty();
                } else {
                    var submenus = data.insname
                    $('#totalcost').val(submenus[0].cost);
                    calcalutesums();
                    // $('#hcost').val(Math.round($("#dayrate").val()/24));
                    $('#curr').append("<option value='" + submenus[0].curr + "'>" + submenus[0].currname + "</option>");
                    $('#curr').val('').trigger('change');
                }
            }
        });
    }else if ($('#flag').val() == 1) {
        $('#curr').empty();
        $idins = $('#insname option:selected').attr("value");
        $idcomp = $('#compname option:selected').attr("value");
        $.ajax({
            type: 'POST',
            url: '/getinsrate',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'idins': $idins,
                'idcomp': $idcomp,
                'cost': '',
                'curr': '',
                'currname': ''
            },
            success: function (data) {
                if ((data.errors)) {
                    $('#totalcost').val('0');
                    $('#curr').empty();
                } else {
                    var submenus = data.insname
                    $('#totalcost').val(submenus[0].cost);
                    calcalutesums();
                    // $('#hcost').val(Math.round($("#dayrate").val()/24));
                    $('#curr').append("<option value='" + submenus[0].curr + "'>" + submenus[0].currname + "</option>");
                    $('#curr').val('').trigger('change');
                }
            }
        });
    }
});

$(document).on('change', '#compname', function(){
    $('#insname').empty();
    $('#curr').empty();
    $('#totalcost').val('0');
    $('#insname').val('').trigger('change');
    $('#curr').val('').trigger('change');
    $idcomp = $('#compname option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getinsurance',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idcomp':$idcomp,
            'ins_id': '',
            'insname': ''
        },
        success: function(data) {
            if ((data.errors)) {
                $('#insname').empty();
            } else {
                // $('#insname').empty();
                var submenus = data.insname;
                for(var i=0; i<submenus.length; i++) {
                    $('#insname').append("<option value='"+submenus[i].ins_id+"'>" +submenus[i].insname+"</option>");
                    $('#insname').val('').trigger('change');
                }
            }
        }
    });
});

function getinsuranceslist(){
    $('#insname').empty();
    $idcomp = $('#compname option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getinsurance',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idcomp':$idcomp,
            'ins_id': '',
            'insname': ''
        },
        success: function(data) {
            if ((data.errors)) {
                $('#insname').empty();
            } else {
                // $('#insname').empty();
                var submenus = data.insname;
                for(var i=0; i<submenus.length; i++) {
                    $('#insname').append("<option value='"+submenus[i].ins_id+"'>" +submenus[i].insname+"</option>");
                    // $('#insname').val('').trigger('change');
                }
            }
        }
    });
}

function getDatainsname(gid) {
    $.ajax({
        type: 'GET',
        url: '/getinsname/'+ gid,
        data: {
            'insid':'',
            'insname':'',
            'curr':'',
            'currname':''
        },
        success: function(data) {
            // $('#insname').select2('data', {id: data.insid, a_key: data.insname}).change();
            var temp = data.insid;
            var mySelect = document.getElementById('insname');

            for(var i, j = 0; i = mySelect.options[j]; j++) {
                if(i.value == temp) {
                    mySelect.selectedIndex = j;
                    break;
                }
            }
            getcurrinsurance(data.insid);
            // console.log(data.currname);
        }
    });
}

function getcurrinsurance($insid){
    $('#curr').empty();
    $idins = $insid;
    $idcomp = $('#compname option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getinsrate',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idins':$idins,
            'idcomp':$idcomp,
            'cost':'',
            'curr':'',
            'currname':''
        },
        success: function(data) {
            if ((data.errors)) {
                // $('#totalcost').val('0');
                $('#curr').empty();
            } else {
                var submenus = data.insname
                // $('#totalcost').val(submenus[0].cost);
                // calcalutesums();
                // $('#hcost').val(Math.round($("#dayrate").val()/24));
                $('#curr').append("<option value='"+submenus[0].curr+"'>" +submenus[0].currname+"</option>");
                var temp = submenus[0].curr;
                var mySelect = document.getElementById('curr');

                for(var i, j = 0; i = mySelect.options[j]; j++) {
                    if(i.value == temp) {
                        mySelect.selectedIndex = j;
                        break;
                    }
                }
                // $('#curr').select2('data', {id: submenus[0].curr, a_key: submenus[0].currname}).change();
                // $('#curr').val('').trigger('change');
            }
        }
    });
}

$(document).on('change', '#office', function(){

    $idoffice = $('#office option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getofficeinfo',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idoffice':$idoffice,
            'officeper': '',
        },
        success: function(data) {
            if ((data.errors)) {
                $('#officeper').val('0');
            } else {
                // var valshare = data.officeper;
                $('#officeper').val(data.officeper);
                calcalutesums();
            }
        }
    });
});

$(document).on('change', '#broker', function(){

    $idbroker = $('#broker option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getbrokerinfo',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idbroker':$idbroker,
            'brokerper': '',
        },
        success: function(data) {
            if ((data.errors)) {
                $('#brokerper').val('0');
            } else {
                // var valshare = data.brokerper;
                $('#brokerper').val(data.brokerper);
                calcalutesums();
            }
        }
    });
});

$(document).on('click', '#calculate_btn', function(){
    calcalutesums();
});

$(document).on('keyup', '#totalcost', function(){
    calcalutesums();
});

$(document).on('change', '#officeshare', function(){
    calcalutesums();
});

$(document).on('change', '#brokershare', function(){
    calcalutesums();
});

$(document).on('keyup', '#officebroker', function(){
    calcalutesums();
});

$(document).on('focusout', '#edate', function(){
    // let start = new Date();
    let start = new Date($('#sdate').val());
    let end = new Date($('#edate').val());

    var diff = Math.floor(end.getTime() - start.getTime());
    var day = 1000 * 60 * 60 * 24;

    var days = Math.floor(diff/day);
    var months = Math.floor(days/31);
    var years = Math.floor(months/12);


    $('#days').val(days);
});

function calcalutesums(){
    // let btn_save = document.querySelector(".button");

    if ($('#totalcost').val() == "" && $('#totalcost').val() == "0")
    {
        $('#officeshare').val("0");
        $('#brokershare').val("0");
        $('#netcost').val("0");
    }else
    {
        $tocost = parseFloat($('#totalcost').val());
        $oper = parseFloat($('#officeper').val());
        $bper = parseFloat($('#brokerper').val());

        $osh = parseFloat($('#officeshare').val());
        $bsh = parseFloat($('#brokershare').val());

        // calcalute Office Share
        //
        // if ($('#officeper').val() != "0" && $('#officeper').val() != "") {
        //     $shareoffice = ($tocost * $oper) / 100
        //     $('#officeshare').val($shareoffice);
        // }else {
        //      $('#officeshare').val("0");
        //      $('#officeper').val("0");
        // }

        // calcalute Office Percentage

        if ($('#officeshare').val() != "0" && $('#officeshare').val() != "") {
            // console.log("stick with if");
            $officepercentage = ($osh * 100) / $tocost
            $('#officeper').val(parseFloat($officepercentage.toFixed(2)));
        }else {
            // console.log("go to else");
            $('#officeshare').val("0");
            $('#officeper').val("0");
        }


        // // calcalute Broker Share
        // if ($('#brokerper').val() != "0" && $('#brokerper').val() != "") {
        //     $oshare = parseFloat($('#officeshare').val());
        //     $sharebroker = ($tocost * $bper) / 100
        //     $('#brokershare').val($sharebroker);
        // }else {
        //     $('#brokershare').val("0");
        //     $('#brokerper').val("0");
        // }


        // calcalute Broker percentage
        if ($('#brokershare').val() != "0" && $('#brokershare').val() != "") {
            // $oshare = parseFloat($('#officeshare').val());
            $brokerpercentage = ($bsh * 100) / $tocost
            $('#brokerper').val(parseFloat($brokerpercentage.toFixed(2)));
        }else {
            $('#brokershare').val("0");
            $('#brokerper').val("0");
        }


        $sum = '';
        $osharevalue = parseFloat($('#officeshare').val());
        $bsharevalue = parseFloat($('#brokershare').val());

        // $sum = Math.floor($tocost - $osharevalue - $bsharevalue)
        // $sum = Math.floor($tocost - $osharevalue)
        $sum = $tocost - $osharevalue

        $('#netcost').val($sum)
        document.getElementById("btn_save").disabled = false;
    }

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



