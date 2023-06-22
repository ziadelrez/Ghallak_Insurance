$(document).ready(function () {
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

    $(".selectionenginetype").select2({
        placeholder: "إختر قوة محرك السيارة",
        allowClear: true
    });

    $(".selectioncarsuses").select2({
        placeholder: "إختر وجهة إستخدام السيارة",
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

$(document).on('focusout', '#platnumber', function(){
    $('#err_carsexist').hide()
    document.getElementById("carssavebtn").disabled = false;
    $carnumber = $("#platnumber").val();
    console.log($carnumber);
    $.ajax({
        type: 'POST',
        url: '/getcarnumbervalide',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'carnumber': $carnumber,
            'status': '',
            'flag': ''
        },
        success: function(data) {
            if ((data.errors)) {
                // console.log(data.errors)
                $('#err_carsexist').hide()
            } else {
                    // console.log($idcar)
                    // console.log(data.flag)
                    if ((data.flag == "1")) {
                        $('#err_carsexist').show()
                        document.getElementById("carssavebtn").disabled = true;
                    } else {
                        $('#err_carvalidation').hide()
                        document.getElementById("carssavebtn").disabled = false;
                    }
            }

        }
    });
});

// $('#myModal.select2').select2();

