//var url = app.base_url + "/modules";

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
    var my_url = app.base_url + "/modules";
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
            if (state == "add") { //if user added a new record
                $('#btn-save').val("update");
                $('#module_id').val(data.id);
                $('#que_module_id').val(data.id);
                $('#doc_module_id').val(data.id);
                $('#btn-save-question').removeClass('disabled');
                $('#uploaddocument').removeClass('disabled');
                $.notify("Module have been added successfully.");
            } else { //if user updated an existing record

                $.notify("Module have been updated successfully.");
            }
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});


function load_questions(){
    var module_id =  $('#module_id').val();
    $.get(qUrl + '/list/' + module_id, function (questions) {
        //success data
        console.log(questions);
        $('#que-list').html("");
        if (questions) {
            $.each(questions, function (i, que) {

                $('#que-list').append(
                        '<tr id="que_' + que.id + '">'
                        //+ '  <td>' + que.sno + '</td>'
                        + '  <td class="ques_content">' +$($.parseHTML(que.content)).text().substring(0,120)+ '</td>'
                        + '  <td class="ques_actions">'
                        + '     <button class="btn btn-success que_edit" value="' + que.id + '" title="Edit"><i class="fa fa-edit" ></i></button>'
                        + '     <button class="btn btn-danger que_delete" value="' + que.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                        + '  </td>'
                        + '</tr>'
                        );
            });
        } else
        {
            $('#que-list').append(
                    '<tr >'
                    + '  <td colspan="2">No question found.</td>'
                    + '  </td>'
                    + '</tr>'
                    );
        }

    });
    $('#que_module_id').val(module_id);

}

function load_documents(){
     var module_id = $('#module_id').val();

    $.get(docUrl + '/list/' + module_id, function (documents) {
        //success data
        console.log(documents);
        $('#doc-list').html("");
        $.each(documents, function (i, doc) {
            //console.log(doc.filename);
            if(doc.uploaded_by == $("#user_id").val()){
                $('#doc-list').append(
                        '<tr id="doc_' + doc.id + '">'
                        + '  <td>' + doc.description + '</td>'
                        + '  <td>' + doc.filename + '</td>'
                        + '  <td>'
                        + '     <a href="' + app.base_url + '/documents/' + doc.filename + '" class="btn btn-success btn-dowonload doc_download" title="Download" download><i class="fa fa-download" ></i></a>'
                        + '     <button class="btn btn-danger doc_delete" value="' + doc.id + '" title="Delete"><i class="fa fa-remove" ></i></button>'
                        + '  </td>'
                        + '</tr>'
                );
            }
        });
//        $('#doc-list').html(data);
//        $('#doc-list').append(data);

    })

    $('#doc_module_id').val(module_id);
}

$( document ).ready(function() {
    var state = $('#btn-save').val();
    if(state == "update"){
    load_questions();
    load_documents();
}
});