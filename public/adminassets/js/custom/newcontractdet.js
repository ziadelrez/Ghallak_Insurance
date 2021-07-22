$(document).ready(function () {
    $(".selectioncarname").select2({
        placeholder: "إختر اسم السيارة",
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

});

$(document).on('change', '#carname', function(){
   $idcar = $('#carname option:selected').attr("value");
    $.ajax({
        type: 'POST',
        url: '/getcarrate',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'idcar':$idcar,
            'carrate':'',
            'curr' :''
        },
        success: function(data) {
            if ((data.errors)) {
                $('#dayrate').val('0');
                // $('#hcost').val('0');
            } else {
                $('#dayrate').val(data.carrate);
                // $('#hcost').val(Math.round($("#dayrate").val()/24));
            }
            calcalutesums();
        }
    });
});

$(document).on('click', '#calculate_btn', function(){
    calcalutesums();
});

// $(document).on('keyup', '#days', function(){
//     calcalutesums();
// });
//
// $(document).on('change', '#days', function(){
//     calcalutesums();
// });
//
// $(document).on('keyup', '#dayrate', function(){
//     calcalutesums();
// });
//
// $(document).on('change', '#dayrate', function(){
//     calcalutesums();
// });
//
// $(document).on('keyup', '#gascost', function(){
//     calcalutesums();
// });
//
// $(document).on('change', '#gascost', function(){
//     calcalutesums();
// });
//
// $(document).on('keyup', '#drivercost', function(){
//     calcalutesums();
// });
//
// $(document).on('change', '#drivercost', function(){
//     calcalutesums();
// });
//
// $(document).on('keyup', '#extratime', function(){
//     calcalutesums();
// });
//
// $(document).on('change', '#extratime', function(){
//     calcalutesums();
// });
//
// $(document).on('keyup', '#hcost', function(){
//    calcalutesums();
// });
//
// $(document).on('change', '#hcost', function(){
//     calcalutesums();
// });
//
// $(document).on('keyup', '#extracost', function(){
//     calcalutesums();
// });
//
// $(document).on('change', '#extracost', function(){
//     calcalutesums();
// });

$(document).on('focusout', '#datein', function(){
    let start = new Date($('#dateout').val());
    let end = new Date($('#datein').val());

    // $('#officedatein').val($('#datein').val());

    let Difference_In_Time = end.getTime() - start.getTime();

    let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    $('#days').val(Difference_In_Days);
    calcalutesums();
});

// $(document).on('focusout', '#timein', function(){
//
//     $('#officetimein').val($('#timein').val());
//
// });


$(document).on('focusout', '#dateout', function(){
    let start = new Date($('#dateout').val());
    let end = new Date($('#datein').val());

    $('#officedatein').val($('#datein').val());

    let Difference_In_Time = end.getTime() - start.getTime();

    let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    $('#days').val(Difference_In_Days);
    calcalutesums();
});

// function extcosttime(){
//     let sum = '';
//     let extratime = parseFloat($('#extratime').val());
//     let hcost = parseFloat($('#hcost').val());
//     sum = extratime * hcost
//     $('#extracost').val(sum);
// }
function calcalutesums(){
    // let btn_save = document.querySelector(".button");

    if ($('#deposit').val() == "")
    {
        $('#deposit').val("0");
        var x = document.getElementById("deposit_id");
        x.style.display = "none";
    }else if ($('#deposit').val() == "0")
    {
        var x = document.getElementById("deposit_id");
        x.style.display = "none";
    }else
    {
        var x = document.getElementById("deposit_id");
        x.style.display = "Block";
        x.innerHTML=$('#deposit_id_lbl').val() + " : " + $('#deposit').val() + " " + $("#depcurr option:selected").text();
    }
    if ($('#gascost').val() == "")
    {
        $('#gascost').val("0");
    }
    if ($('#drivercost').val() == "")
    {
        $('#drivercost').val("0");
    }
    // extcosttime()
    $('#stotal').val()
    $sum = '';
    $daysrate = parseFloat($('#dayrate').val());
    $dayscost = parseFloat($('#days').val());
    $gazcost = parseFloat($('#gascost').val());
    $drivercost = parseFloat($('#drivercost').val());

    $sum = ($daysrate * $dayscost) + $gazcost + $drivercost

    $('#stotal').val($sum)
    document.getElementById("btn_save").disabled = false;
}



