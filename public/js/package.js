/* 
 *Deal with all packages related operations.
 */
var pUrl = app.base_url + "/packages";
//display package form
$(document).on('click', '#btn_add_package', function () {
//     $.get(url + '/live' , function (data) {

    $('#frmPackage').trigger("reset");
    $('#addPackageModal').modal('show');
    $('#btn-save-package').val("add");

//    });



});

$(document).on('click', '#btn-save-package', function (e) {
    var selected_modules = {};
    $('.selected-modules li').each(function (index) {
        selected_modules[index] = $(this).attr('value');
        console.log(index + ": " + $(this).text() + " value =" + $(this).attr('value'));
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    var formData = {
        title: $('#title').val(),
        description: tinymce.get('description').getContent(),
        price: $('#price').val(),
        currency: $('#currency').val(),
        paymnent_frequency: $('input[name=paymnent_frequency]:checked').val(),
        release_schedule: $('input[name=release_schedule]:checked').val(),
        facebook_group: $('#facebook_group').val(),
        selected_modules: selected_modules
    };
    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = $('#btn-save-package').val();
    var type = "POST"; //for creating new resource
    var package_id = $('#package_id').val();

    var my_url = pUrl;
    if (state == "update") {
        type = "PUT"; //for updating existing resource
        my_url += '/' + package_id;
    }
    console.log(formData);
    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function (package) {
            console.log(package);
            var packagerow = '<tr id="package_' + package.id + '">'
                    + '<td>' + package.title + '</td>'
                    + '<td>' + package.price + '</td >'
                    + '<td> </td>'
                    + ' <td>'
                    +' <div class="dropup">'
                                   +' <button class="btn btn-danger btn-detail dropdown-toggle pull-left dropdownMenu1" value="' + package.id + '"  type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Add Client"><i class="fa fa-user" ></i>'
                                   +' <span class="caret"></span>'
                                   +' </button>'
                                   + '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">'
                                    +'    <li ><a class="add_client" data-value="' + package.id + '" href="#">Add Existing Client</a></li>'
                                    +'    <li role="separator" class="divider"></li>'
                                    +'    <li><a class="new_client" data-value="' + package.id + '" href="#">Add New Client</a></li>'
                                    +'</ul>'
                                +'</div>&nbsp;'
                    + ' <button class="btn btn-secondary btn-detail edit_package" value="' + package.id + '" title="Edit"><i class="fa fa-edit" ></i></button>'
                    + ' <button class="btn btn-warning linked_client" value="' + package.id + '"  title="Linked Client"><i class="fa fa-group"></i></button>'
                    + ' <button class="btn btn-success preview_package" value="' + package.id + '" title="Preview"><i class="fa fa-search" ></i></button>'
                    + ' <button class="btn btn-primary btn-delete copy_package" value="' + package.id + '" title="Copy"><i class="fa fa-copy" ></i></button>'
                    + '</td>'
                    + '</tr>'

            if (state == "add") { //if user added a new record
                $('#package-list').append(packagerow);
                $.notify("Package have been added successfully.");
            } else { //if user updated an existing record
                $("#package_" + package_id).replaceWith(packagerow);
                $.notify("Package have been updated successfully.");
            }
            $('#frmPackage').trigger("reset");
            $('#addPackageModal').modal('hide');

        },
        error: function (data) {
            console.log('Error:', data);
        }
    });


});

$(document).on('click', '.edit_package', function (e) {
    var package_id = $(this).val();
   $('.available-modules li').show();
    $.get(pUrl + '/' + package_id, function (data) {
        //success data
        console.log(data);
        $('#package_id').val(data.id);
        $('#title').val(data.title);
        tinymce.get('description').setContent(data.description);
            $('#price').val(data.price);
        $('#currency').val(data.currency);
       
        $( 'input[value="'+data.release_schedule+'"]' ).prop( "checked", true );
        $( 'input[value="'+data.paymnent_frequency+'"]' ).prop( "checked", true );
        $('#facebook_group').val(data.facebook_group);
        $('.selected-modules').html(""); 
        group.sortable("refresh");
        $.each(data.selected_modules, function (index, module) {
//            alert(index + ": " + value);
        $('.selected-modules').append('<li value="'+module.id+'" id="'+module.id+'" style="cursor:move" ><i class="fa fa-fw fa-folder"></i>'+module.title+'</li>');
           $('.available-modules #'+module.id).hide();
           
        });
               
                $('#btn-save-package').val("update");
       
//         $('#frmPackage').trigger("reset");
    $('#addPackageModal').modal('show');
    });
});

$(document).on('click', '.new_client', function (e) {
    var package_id = $(this).data('value');
    $('#package_id').val(package_id);
    $('#newClientModal').modal('show');
    
});

$(document).on('click', '#btn-save-client', function (e) {
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    var formData = {
        name: $('#name').val(),
        password: $('#password').val(),
        email: $('#email').val(),
        package_id : $('#package_id').val()
    };
        
    
    console.log(formData);
    $.ajax({
        type: "POST",
        url: app.base_url+"/clients",
        data: formData,
        dataType: 'json',
        success: function (data) {
                $.notify("Client have been added successfully.");
            console.log(data);
            $('#clients_'+$('#package_id').val()).html(data.totalclients);
            $('#frmClient').trigger("reset");
            $('#newClientModal').modal('hide');

        },
        error: function (data) {
            console.log('Error:', data);
        }
    });


});

$(document).on('click', '.add_client', function (e) {
    var package_id = $(this).data('value');
    $('#package_id').val(package_id);
    $('#addClientModal').modal('show');
    
});

$(document).on('click', '#btn-save-addclient', function (e) {
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    var formData = {
        emails: $('#emails').val(),
        package_id : $('#package_id').val()
    };
        
    
    console.log(formData);
    $.ajax({
        type: "POST",
        url: app.base_url+"/clients/addExisting",
        data: formData,
        dataType: 'json',
        success: function (data) {
                $.notify(data.clients+" Clients have been added successfully.");
            console.log(data);
             $('#clients_'+$('#package_id').val()).html(data.totalclients);
            $('#frmAddClient').trigger("reset");
            $('#addClientModal').modal('hide');

        },
        error: function (data) {
            console.log('Error:', data);
        }
    });


});

$(document).on('click', '.linked_client', function (e) {
     $('#linked_clients_list').html("");
    var package_id = $(this).val();
    $('#package_id').val(package_id);
    $.get(pUrl + '/linked_clients/' + package_id, function (data) {
        console.log(data);
   $.each(data, function (index, client) {
//            alert(index + ": " + value);
        $('#linked_clients_list').append('<tr><td>'+client.name +' </td></tr>');
           
           
        });     
    });
    $('#linkedClient').modal('show');
    
});