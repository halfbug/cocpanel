var docUrl = app.base_url + "/documents";
//display modal form for module editing
$(document).on('click', '.open_doc', function () {
    var module_id = $(this).val();
    $.get(docUrl + '/list/' + module_id, function (documents) {
        //success data
        console.log(documents);
        $('#doc-list').html("");
        $.each(documents, function (i, doc) {
            console.log(doc.filename);
            $('#doc-list').append(
                    '<tr id="doc_'+doc.id+'">'
                    + '  <td>'+doc.description+'</td>'
                    + '  <td>'+doc.filename+'</td>'
                    + '  <td>'
                    + '     <a href="'+app.base_url+'/documents/'+doc.filename+'" class="btn btn-success btn-dowonload doc_download" title="Download" download><i class="fa fa-download" ></i></a>'
                    + '     <button class="btn btn-danger doc_delete" value="'+doc.id+'" title="Delete"><i class="fa fa-remove" ></i></button>'
                    + '  </td>'
                    + '</tr>'
                    );
        });
//        $('#doc-list').html(data);
//        $('#doc-list').append(data);

    })

    $('#doc_module_id').val(module_id);
    $('#documentModel').modal('show');
});
