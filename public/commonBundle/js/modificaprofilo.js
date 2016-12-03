$(function () {



    $('#rpassword-label').addClass("hidden");
    $('#rpassword').addClass("hidden");

    $("#password").keyup(function () {
        var password = $("#password").val();
        if (password.length > 0) {
            $('#rpassword-label').removeClass("hidden");
            $('#rpassword').removeClass("hidden");
        }
        else {
            $('#rpassword-label').addClass("hidden");
            $('#rpassword-error').addClass("hidden");
            $('#rpassword').addClass("hidden");
        }
    });

    $('#modificaprofilo').validate({
        rules: {
            nome: {
                required: true
            },
            cognome: {
                required: true
            },
            username: {
                required: true,
                minlength: 2
            },
            password: {
                minlength: 2
            },
            rpassword: {
                equalTo: '#password'
            }
        },
        messages: {
            nome: {
                required: "Inserisci un nome per continuare"
            },
            cognome: {
                required: "Inserisci un nome per continuare"
            },
            username: {
                required: "Inserisci un username per continuare",
                minlength: "L'username è composto da almeno due caratteri"
            },
            password: {
                minlength: "La password è composto da almeno due caratteri"
            },
            rpassword: {
                equalTo: "Le password devono coincidere"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
