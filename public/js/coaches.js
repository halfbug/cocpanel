var coUrl = app.base_url + "/coaches";
//display package form
$(document).on('click', '#btn_add_coach', function () {
//     $.get(url + '/live' , function (data) {

    $('#frmCoach').trigger("reset");
    $('#newCoachModal').modal('show');

});

$("#btn-save-coach").click(function (e) {
    // alert($('meta[name="_token"]').attr('content'));
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
        status: $('#status').val()
    };

    console.log(formData);
    $.ajax({
        type: "POST",
        url: app.base_url + "/coaches",
        data: formData,
        dataType: 'json',
        success: function (data) {
            $.notify("Coach have been added successfully.");
            console.log(data);
            if(data[1]== 0){
            $('#coach-list').append('<tr id="coache_{{$coache->id}}">'
                    + '<td>+</td>'
                    + '<td>'+data[0].name+'</td>'
                    + ' <td></td>'
                    + ' <td>'
                    + '                        <!-- butons here-->'
                    + '                   </td>'
                    + '              </tr>');
            $('#frmCoach').trigger("reset");
        } 
        else
        {
            $.notify("Coach already there.");
        }
            $('#newCoachModal').modal('hide');
            

        },
        error: function (xhr, status, error) {
//            var err = eval("(" + xhr.responseText + ")");
//            alert(err.Message);
            $('#newCoachModal').modal('hide');
//             $(xhr.responseText).find('.exception_message').html();
//             exception_message
            $.notify("Error :" + $(xhr.responseText).find('.exception_message').html());
        }
    });


});