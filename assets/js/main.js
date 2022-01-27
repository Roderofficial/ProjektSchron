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

    var data = $('#loginform').serialize();
    var animations = new updating_animations('#loginform');



    $.ajax({
        type: "POST",
        url: "/inc/requests/auth/validate_login.php",
        data: data,
        beforeSend: function () {
            animations.disable();
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
            
            animations.enable();

        }
         });
});

//on page ready
$(function () {
    //TOOLTIPS ENABLE
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
    var data = $('#registerform').serialize();
    var animations = new updating_animations('#registerform');


    $.ajax({
        type: "POST",
        url: "/inc/requests/auth/register.php",
        data: data,
        beforeSend: function () {
            animations.disable();
             

        },
        success: function (response) {

            notyf.success("Konto zostało utworzone pomyślnie. Automatyczne przekierowanie...")
            console.log(response);
            
            setTimeout(function(e){
                location.reload();
            }, 4000);
            

        },
        error: function (response) {
            animations.enable();
            notyf.error(`Błąd ${response.status}: ${response.responseText}`)
            grecaptcha.reset();
        }
    });
});

//btn
class updating_animations{
    constructor(form){
        this.form = $(form);
        this.submitbtn = this.form.find('button[type=submit]')[0];
        this.beforesubmit = this.submitbtn.innerHTML;
        console.log(this.beforesubmit);

    }

    disable(){
        this.form.find(":input").prop("disabled", true);
        this.submitbtn.innerHTML = `
        <i class="fas fa-spinner fa-spin"></i> Przetwarzanie
        `

    }

    enable(){
        this.form.find(":input").prop("disabled", false);
        this.submitbtn.innerHTML = this.beforesubmit;

    }
}
//social login
$(".btn_facebook-login").click(function (e){

    //open login window
    var social_window = window.open('/inc/requests/auth/social_login.php', 'Logowanie Facebook');
    console.log(social_window);
    social_window.addEventListener('beforeunload', function (e) {
        // the absence of a returnValue property on the event will guarantee the browser unload happens
        window.location.reload();
      });
});

class public_category_select{
    constructor(obj_id){
        this.obj_id = obj_id;
    }

    update_select(){


    }

}
function category_public_insert(object_id) {
    console.log(object_id);
    var object = $(object_id)
    
    $.get("/inc/requests/categories.php", { async: false }, function (data) {
        //Append wszystkie
        object.append(new Option("Wszystkie", "-1"))

        //Items from json request
        data.forEach(element => {
            object.append(new Option(element.text, element.id))
        });

    });
    console.log($(this.object_id));
    console.log('cat loaded')
}
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
