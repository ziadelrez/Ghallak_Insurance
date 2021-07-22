$(document).ready(function () {
    $(".selectionbranch").select2({
        placeholder: "إختر الفرع",
        allowClear: true
    });

    $(".selectioncartype").select2({
        placeholder: "إختر ماركة السيارة",
        allowClear: true
    });

    $(".selectioncarmodel").select2({
        placeholder: "إختر موديل السيارة",
        allowClear: true
    });

    $(".selectioncarcolor").select2({
        placeholder: "إختر لون السيارة",
        allowClear: true
    });

    $(".selectioncarenginetype").select2({
        placeholder: "إختر نوع المحرك",
        allowClear: true
    });


    $(".selectioncurr").select2({
        placeholder: "إختر العملة",
        allowClear: true
    });

});

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

