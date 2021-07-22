$(document).ready(function () {
    $(".selectionreg").select2({
        placeholder: "إختر اسم المنطقة",
        allowClear: true
    });

    $(".selectionctype").select2({
        placeholder: "إختر نوع الزبون",
        allowClear: true
    });

    $(".selectionnatio").select2({
        placeholder: "إختر الجنسية",
        allowClear: true
    });

    $(".selectionplace").select2({
        placeholder: "إختر مكان الولادة",
        allowClear: true
    });

    $(".selectionpassplace").select2({
        placeholder: "إختر مكان إصدار الجواز",
        allowClear: true
    });
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

// $('#myModal.select2').select2();

