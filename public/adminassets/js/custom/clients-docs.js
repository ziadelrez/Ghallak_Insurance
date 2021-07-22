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
                url: '/doc_image_delete_file/' + $("#client_id").val() ,
                data: {id: file.name, _token: $('[name="_token"]').val(),docid:$("#doc_id").val()},
            });
        });

        this.on("sending", function (file, xhr, formData) {
            formData.append("doc_id", $("#doc_id").val());
            formData.append("client_id", $("#client_id").val());
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
            // Will send the filesize along with the file as POST data.

        });

        this.on("success", function (file, response) {
            file.previewElement.outerHTML  = "";
            $('#createimg').modal('hide');
        });

    },
};

$(document).on('click','.createimg-modal', function() {
    $('#createimg').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('الوثائق المرفقة للزبون');
    $("#doc_id").val($(this).attr('data-id'));
    // cleardropzone();
});


$(document).on('click','.create-modal', function() {
    $('#create').modal('show');
    $('#err_details_docname').hide()
    $('#docname').val('');
    $('.form-horizontal').show();
    $('.modal-title').text('الوثائق المرفقة للزبون');
    $('#docname').focus();
});

function cleardropzone(){
    //DropZone Object Get
    var objDZ = Dropzone.forElement("#my-dropzone");
    //"resetFiles" Event Call
    objDZ.removeAllFiles();
}

$("#add").click(function() {
    $.ajax({
        type: 'POST',
        url: '/savedocfile' ,
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'cid': $("#client_id").val(),
            'docname': $('input[name=docname]').val(),
        },
        success: function(data){
            // console.log(data)
            if ((data.errors)) {
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                $('#err_details_docname').remove()
                // console.log(data)
                $('#table').append('<tr class="attachrows' + data.id +'">'+
                    '<td style="display:none;" width="150px">' + data.id + '</td>'+
                    '<td width="400px">' + data.docname + '</td>'+
                    '<td class="text-center" width="200px">' +
                    '<button class="viewdoc-modal btn btn-info btn-sm" title="عرض الوثيقة" ><i class="fas fa-eye"></i></button>'+ ' ' +
                    '<button class="createimg-modal btn btn-primary btn-sm" title="إضافة وثيقة" data-id='+ data.id + ' data-title=' + data.docname + '><i class="fas fa-images"></i></button>'+ ' ' +
                    '<button class="edit-modal btn btn-warning btn-sm" title="تعديل الوثيقة" data-id='+ data.id + ' data-title=' + data.docname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" title="حذف الوثيقة" data-id='+ data.id + ' data-title=' + data.docname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '</tr>');
                $('#docname').val('');
                $('#docname').focus();
            }
        },
    });
});

$(document).on('click', '.edit-modal', function() {
    $('#myModal #editdoc').val('');
    $('#footer_action_button').text(" تعديل");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('تعديل بيانات الوثيقة');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    // console.log($(this).data('id'));
    $("#editdocid").val($(this).attr('data-id'));
    // console.log($("#editdocid").val());
    getDatadoc($(this).data('id'));
    $('#myModal').modal('show');
});

function getDatadoc(gid) {
    $.ajax({
        type: 'GET',
        url: '/getdocdetails/'+ gid,
        success: function(data) {
            // console.log(data.locationdb);
            $('#myModal #editdoc').val(data.docname);
        }
    });
}

$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'POST',
        url: '/editdoc',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id': $("#editdocid").val(),
            'docname': $('input[name=editdoc]').val(),
        },
        success: function(data) {
            if ((data.errors)) {
                // console.log(data);
                $.each(data.errors,function(key,val){
                    $("#" + "err_details_" + key ).show()
                    $("#" + "err_details_" + key ).text(val[0]);
                });
            } else {
                // console.log(data);
                $('.attachrows' + data.id).replaceWith(" " +
                    '<tr class="attachrows' + data.id +'">'+
                    '<td style="display:none;" width="150px">' + data.id + '</td>'+
                    '<td width="400px">' + data.docname + '</td>'+
                    '<td class="text-center" width="200px">' +
                    '<button class="viewdoc-modal btn btn-info btn-sm" title="عرض الوثيقة" ><i class="fas fa-eye"></i></button>'+ ' ' +
                    '<button class="createimg-modal btn btn-primary btn-sm" title="إضافة وثيقة" data-id='+ data.id + ' data-title=' + data.docname + '><i class="fas fa-images"></i></button>'+ ' ' +
                    '<button class="edit-modal btn btn-warning btn-sm" title="تعديل الوثيقة" data-id='+ data.id + ' data-title=' + data.docname + ' ><i class="fa fa-edit"></i> </button>'  + ' ' +
                    '<button class="delete-modal btn btn-danger btn-sm" title="حذف الوثيقة" data-id='+ data.id + ' data-title=' + data.docname + ' ><i class="fa fa-trash"></i> </button>' + '</td>'+
                    '</tr>');
                $('#create').modal('hide');
            }
        }
    });
});

// form Delete function
$(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" حذف الوثيقة");
    $('#footer_action_button').addClass('fa-check');
    $('#footer_action_button').removeClass('fa-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('حذف الوثيقة');
    $("#editdocid").val($(this).attr('data-id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

$('.modal-footer').on('click', '.delete', function(){
    $.ajax({
        type: 'POST',
        url: '/deletedoc',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'id':  $("#editdocid").val(),
        },
        success: function(data){
            $('.attachrows' + $("#editdocid").val()).remove();
            // console.log($('.id').text());
        }
    });
});


