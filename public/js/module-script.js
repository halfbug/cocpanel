var url = "http://localhost:82/laravel5.3/cocpanel/public/modules";
    //display modal form for module editing
    $(document).on('click','.open_modal',function(){
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
    $('#btn_add').click(function(){
        $('#btn-save').val("add");
        $('#frmModules').trigger("reset");
        $('#myModal').modal('show');
    });
    //delete module and remove it from list
    $(document).on('click','.delete-module',function(){
        var module_id = $(this).val();
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
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    //create new module / update existing module
    $("#btn-save").click(function (e) {
       // alert($('meta[name="_token"]').attr('content'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
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
        var module_id = $('#module_id').val();;
        var my_url = url;
        if (state == "update"){
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
                var module = '<tr id="module' + data.id + '"><td>' + data.id + '</td><td>' + data.title + '</td>';
                module += '<td><button class="btn btn-warning btn-detail open_modal" value="' + data.id + '">Edit</button>';
                module += ' <button class="btn btn-danger btn-delete delete-module" value="' + data.id + '">Delete</button></td></tr>';
                if (state == "add"){ //if user added a new record
                    $('#modules-list').append(module);
                }else{ //if user updated an existing record
                    $("#module" + module_id).replaceWith( module );
                }
                $('#frmModules').trigger("reset");
                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });