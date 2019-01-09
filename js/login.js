

$(document).ready(function () {
    //$("#_boxAvviso").css('display', 'none');
});

$("#_loginBtn").click(function () {
    
    if ($("#_lgnFrm").valid()){
        $('#_icoLogin').attr('class', 'fa fa-spinner fa-spin');
        var email = $("#_email").val().trim();
        var password = $("#_password").val().trim();
        var remember = ($('#_remember').is(':checked') === true ? 1:0);
        // Checking for blank fields.
        if (email == '' || password == '') {
            $("#_boxAvviso").toggleClass("hide show").hide().fadeIn("slow");
            $("#_testoAvviso").text('Si prega di inserire nome utente e password validi!');
        } else {
            var encPwd = hex_sha512(password);
            $.post("actions/do_login.php", {email: email, password: encPwd, remember: remember},
                function (data) {
                    var response = jQuery.parseJSON(data);
                    if(response['stato'] == 1){
                        window.location = "index.php";
                    } else {
                        $('#_icoLogin').attr('class', 'fa fa-sign-in');
                        $("#_testoAvviso").text(response['msg']);
                        if (!$("#_boxAvviso").hasClass('show')) $("#_boxAvviso").toggleClass("hide show").hide().fadeIn("slow");
                    }
                });
        }        
    }        
});

$(function () {
    
    $("#_lgnFrm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            error.insertBefore(element.parent());
        }
    });    
    
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});