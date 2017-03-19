var url = app.base_url + "/modules";
//display modal form for module editing
$(document).on('click', '.open_modal', function () {
    var module_id = $(this).val();

    $.get(url + '/' + module_id, function (data) {
        //success data
        console.log(data);
        $('#module_id').val(data.id);
        $('#title').val(data.title);
        $('#description').val(data.description);
//             $('#content').val(data.content);
        tinymce.get('content').setContent(data.content);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    })
});
//display modal form for creating new module
$('#btn_add').click(function () {
    $('#btn-save').val("add");
    $('#frmModules').trigger("reset");
    $('#myModal').modal('show');
});
//delete module and remove it from list
$(document).on('click', '.delete-module', function () {
    var module_id = $(this).val();
    if (!$('#dataConfirmModal').length) {
        $('body').append('<div class="modal fade " id="confirmModel" tabindex="-1" role="dialog" aria-labelledby="add_documentLabel" aria-hidden="true">'
                + ' <div class="modal-dialog ">'
                + '     <div class="modal-content">'
                + '         <div class="modal-header">'
                + '             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'
                + '             <h4 class="modal-title" id="add_documentLabel"> Please Confirm</h4>'
                + '         </div>'
                + '         <div class="modal-body">'
                + ' Are you sure to delete entire Module'
                + '</div>'
                + '<div class="modal-footer">'
                + '            <button type="button" class="btn btn-secondry" id="btn-cancel" value="cancel">Cancel</button>'
                + '            <button type="button" class="btn btn-primary" id="btn-ok" value="ok">Ok</button>'

                + '</div>'
                + '  </div>'
                + ' </div>'
                + '</div>'
                );
    }
//		$('#confirmModel').find('.modal-body').text("Are you sure to delete module");
//                        .text($(this).attr('data-confirm'));
//		$('#dataConfirmOK').attr('href', href);
    $('#confirmModel').modal('show');
    $(document).on('click', '#btn-cancel', function () {
        $('#confirmModel').modal('hide');
    });
    $(document).on('click', '#btn-ok', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            type: "DELETE",
            url: url + '/' + module_id,
            success: function (data) {
                console.log(data);
                $("#module" + module_id).remove();
                $('#confirmModel').modal('hide');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
//create new module / update existing module
$("#btn-save").click(function (e) {
    // alert($('meta[name="_token"]').attr('content'));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    var formData = {
        title: $('#title').val(),
        description: $('#description').val(),
        content: tinymce.get('content').getContent() //$('textarea#content').val()
    };
    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = $('#btn-save').val();
    var type = "POST"; //for creating new resource
    var module_id = $('#module_id').val();
    ;
    var my_url = url;
    if (state == "update") {
        type = "PUT"; //for updating existing resource
        my_url += '/' + module_id;
    }
    console.log(formData);
    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var module = '<tr id="module' + data.id + '">'
                    + '<td>' + data.title + '</td>'
                    + '<td>'
                    + '<button class="btn btn-secondary btn-detail open_modal" value="' + data.id + '" title="Edit"><i class="fa fa-edit" ></i></button>'
                    + ' <button class="btn btn-primary btn-detail open_doc" value="' + data.id + '" title="Documents"><i class="fa fa-file-text-o" ></i></button>'
                    + ' <button class="btn btn-warning " value="' + data.id + '"  title="Questions"><i class="fa fa-question-circle"></i></button>'
                    + ' | '
                    + ' <button class="btn btn-success " value="' + data.id + '" title="Make Live"><i class="fa fa-plus-square-o" ></i></button>'
                    + ' <button class="btn btn-danger btn-delete delete-module" value="' + data.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '</td>'
                    + '</tr>'

            if (state == "add") { //if user added a new record
                $('#modules-list').append(module);
            } else { //if user updated an existing record
                $("#module" + module_id).replaceWith(module);
            }
            $('#frmModules').trigger("reset");
            $('#myModal').modal('hide')
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});