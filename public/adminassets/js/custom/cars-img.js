$(document).ready(function () {

    getcarsfiles($('#car-id').val());
});

Dropzone.options.myDropzone = {
    init: function() {
        this.on("addedfile", function(file) {

            // Create the remove button
            var removeButton = Dropzone.createElement("<button  class='btn btn-sm btn-outline-danger btn-block'>حذف الصورة المرفقة</button>");


            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                // Remove the file preview.
                _this.removeFile(file);
                // If you want to the delete the file on the server as well,
                // you can do the AJAX request here.
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);
        });

        this.on("removedfile", function (file) {
            $.post({
                url: '/car_image_delete_file/' + $("#car-id").val() ,
                data: {id: file.name, _token: $('[name="_token"]').val()},
                });
        });

        this.on("sending", function (file, xhr, formData) {
            formData.append("car_id", $("#car-id").val());
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
            // Will send the filesize along with the file as POST data.

        });

        this.on("success", function (file, response) {
            getcarsfiles($('#car-id').val());
        });
    },
};

$('#table').on("click", '.asDoc', function () {
    var Path = $(this).attr('data-path');

    var Options =
        {
            pdfOpenParams:
                {
                    pagemode: "thumbs",
                    navpanes: 0,
                    toolbar: 0,
                    statusbar: 0,
                    view: "FitV",
                    zoom: true
                }
        };

    var myPDF = PDFObject.embed(Path, "#divDocEmbed", Options);
    $('#doc_modal').modal();
});

$('#table').on('click', '.btn-outline-danger', function () {
    var $fid = $(this).attr('data-id')
    bootbox.confirm({
        message: $("#del_msg").val(),
        title: $("#CONFIRM").val(),
        buttons:
            {
                'confirm': {
                    label: '<i class="fa fa-check"></i> ' + $("#YES").val(),
                    className: 'btn-danger'
                },
                'cancel': {
                    label: '<i class="fa fa-times"></i> ' + $("#CANCEL").val(),
                    className: 'btn-default'
                }
            },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: 'POST',
                    url: "/deleteFile",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        fid: $fid,
                    },
                    success: function (data) {
                        if (data.error) {
                            bootbox.alert('<b>' + data.error + '</b>');
                        } else {
                            // console.log("success");
                            getcarsfiles($('#car-id').val());
                        }
                    }
                });
            }
        }
    });
});
function getcarsfiles(ccid){
    // document.getElementById("noresult").style.display = "none";
    $.ajax({
        method:'POST',
        url: '/getfileslist',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'car_id' : ccid
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
                $('#table').html(data.files_data);
            }
        },
    });
}

$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('صورة مرفقة للسيارة');
    $("#car-id").val($(this).attr('data-id'));
    // console.log($(this).attr('data-id'));
    // cleardropzone();
});

function cleardropzone(){
    //DropZone Object Get
    var objDZ = Dropzone.forElement("#my-dropzone");
    //"resetFiles" Event Call
    objDZ.removeAllFiles();
}

// $("#add").click(function() {
//     $.ajax({
//         type: 'POST',
//         url: '/savedocfile/' + $("#client_id").val() ,
//         data: {
//             '_token': $('meta[name="csrf-token"]').attr('content'),
//             'cid': $("#client_id").val(),
//             'docname': $('input[name=docname]').val(),
//         },
//         success: function(data){
//             // console.log(data)
//             if ((data.errors)) {
//                 $.each(data.errors,function(key,val){
//                     $("#" + "err_details_" + key ).show()
//                     $("#" + "err_details_" + key ).text(val[0]);
//                 });
//             } else {
//                 $('#err_details_docname').remove()
//                 // console.log(data)
//                 $('#table').append('<tr class="attachrows' + data.id +'">'+
//                     '<td style="display:none;">' + data.id + '</td>'+
//                     '<td>' + data.docname + '</td>'+
//                     '<td class="text-center" >' +
//                     '<button class="edit-modal btn btn-warning btn-sm" data-id='+ data.id + ' data-title=' + data.docname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
//                     '<button class="delete-modal btn btn-danger btn-sm" data-id='+ data.id + ' data-title=' + data.docname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
//                     '</tr>');
//                 $('#docname').val('');
//                 $('#docname').focus();
//             }
//         },
//     });
// });



