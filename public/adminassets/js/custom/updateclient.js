$(document).ready(function () {
    $(".selectionreg").select2({
        placeholder: "إختر اسم المنطقة",
        allowClear: true
    });

    $(".selectionrelig").select2({
        placeholder: "إختر الطائفة",
        allowClear: true
    });

    $(".selectionevalclient").select2({
        placeholder: "إختر تقييم الزبون",
        allowClear: true
    });

    $(".selectionnatio").select2({
        placeholder: "إختر الجنسية",
        allowClear: true
    });

    $(".selectionfollowby").select2({
        placeholder: "إختر إسم الوصي على الملف",
        allowClear: true
    });



    // $(".selectionnatio").select2({
    //     placeholder: "إختر الجنسية",
    //     allowClear: true
    // });
    //
    // $(".selectionplace").select2({
    //     placeholder: "إختر مكان الولادة",
    //     allowClear: true
    // });
    //
    // $(".selectionpassplace").select2({
    //     placeholder: "إختر مكان إصدار الجواز",
    //     allowClear: true
    // });
    //
    // $(".selectionliplace").select2({
    //     placeholder: "إختر مكان إصدار رخصة الفيادة",
    //     allowClear: true
    // });

   displayshares();

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


function onCheckboxChangedOffice(checked){
    if(checked) {
        $("#officeshare").show();
    }
    else{
        $("#officeshare").hide();
    }
}

function onCheckboxChangedBroker(checked){
    if(checked) {
        $("#brokershare").show();
    }
    else {
        $("#brokershare").hide();
    }
}

function displayshares(){
    if ($('#broker').is(':checked')){
        $("#brokershare").show();
    }

    if ($('#office').is(':checked')){
        $("#officeshare").show();
    }
}

$(document).on('keyup', '#cname', function(){
    $("#name").val( $("#cname").val());
});


//
// $(document).on('keyup', '#extracost', function(){
//     calcalutesums();
// });

// $('#myModal.select2').select2();

