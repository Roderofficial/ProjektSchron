$("#loginform").submit(function (event) {
    event.preventDefault();
    var notyf = new Notyf(
        {
            duration: 4000,
            position: {
                x: 'center',
                y: 'top',
            }
        });
    var submitBtn = $(this).find("input[type=submit]");
    var data = $('#loginform').serialize();


    $.ajax({
        type: "POST",
        url: "/inc/requests/auth/validate_login.php",
        data: data,
        beforeSend: function () {
            submitBtn.prop("disabled", true);
        },
        success: function(response){

            notyf.success("Zalogowano pomyślnie.")
            location.reload();

        },
        error: function (response) {
            if(response.status == 400){
                notyf.error(`Podano niepoprawne dane podczas logowania`);
            }else if (response.status == 404){
                notyf.error("Niepoprawny login lub hasło!")
            } else if (response.status == 403) {
                notyf.error("Twoje konto zostało zablokowane! <br /> Jeśli uważasz, że to błąd, skontaktuj się z administracją.")
            }
            
            console.table(response);
        }
         });
});

//TOOLTIPS
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
class login_modal_page{
    static login(){
        $('#loginmodal-passwordreset, #loginmodal-register').hide();
        $('#loginmodal-login').fadeIn();
        

    }
    static password_reset() {
        $('#loginmodal-login, #loginmodal-register').hide();
        $('#loginmodal-passwordreset').fadeIn();


    }
    static register() {
        $('#loginmodal-login, #loginmodal-passwordreset').hide();
        $('#loginmodal-register').fadeIn();


    }

}
$('#loginModal').on('show.bs.modal', function (e) {
    login_modal_page.login();
})
$(".login-switch-register").click(function(e){
     e.preventDefault();
     login_modal_page.register();
})
$(".login-switch-login").click(function (e) {
    e.preventDefault();
    login_modal_page.login();
})
$(".login-switch-passwordreset").click(function (e) {
    e.preventDefault();
    login_modal_page.password_reset();
})

$("#registerform").submit(function (event) {
    event.preventDefault();
    var form = $(this);
    var notyf = new Notyf(
        {
            duration: 6000,
            position: {
                x: 'center',
                y: 'top',
            }
        });
    var submitBtn = $(this).find("input[type=submit]");
    var data = $('#registerform').serialize();
    console.log(data);


    $.ajax({
        type: "POST",
        url: "/inc/requests/auth/register.php",
        data: data,
        beforeSend: function () {
            submitBtn.prop("disabled", true);
        },
        success: function (response) {

            notyf.success("Konto zostało utworzone pomyślnie. Automatyczne przekierowanie...")
            form.trigger("reset");
            console.log(response);
            setTimeout(function(e){
                location.reload();
            }, 4000);
            

        },
        error: function (response) {
            notyf.error(`Błąd ${response.status}: ${response.responseText}`)
            grecaptcha.reset();

            console.table(response);
        }
    });
});