//Login request

function advanced_recaptcha_reset(){
    var c = $('.g-recaptcha').length;
    for (var i = 0; i < c; i++)
        grecaptcha.reset(i);
}

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


//Password recovery request
$("#passresetform").submit(function (event) {
    event.preventDefault();
    var notyf = new Notyf(
        {
            duration: 4000,
            position: {
                x: 'center',
                y: 'top',
            }
        });

    var data = $('#passresetform').serialize();
    var animations = new updating_animations('#passresetform');



    $.ajax({
        type: "POST",
        url: "/inc/requests/auth/reset_password_send.php",
        data: data,
        beforeSend: function () {
            animations.disable();
        },
        success: function (response) {

            swaltoast("success","Wiadomość została wysłana na adres e-mail.")
            $('#passresetform').trigger("reset");
            console.log(response);
            advanced_recaptcha_reset()
            animations.enable();

        },
        error: function (response) {
            notyf.error(`Błąd ${response.status}: ${response.responseText}`);
            $('#passresetform').trigger("reset");
            advanced_recaptcha_reset()
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
            
            setTimeout(function(e){
                location.reload();
            }, 4000);
            

        },
        error: function (response) {
            animations.enable();
            notyf.error(`Błąd ${response.status}: ${response.responseText}`)
            advanced_recaptcha_reset()
        }
    });
});

//btn
class updating_animations{
    constructor(form){
        this.form = $(form);
        this.submitbtn = this.form.find('button[type=submit]')[0];
        this.beforesubmit = this.submitbtn.innerHTML;

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
    var object = $(object_id)
    
    $.get("/inc/requests/categories.php", { async: false }, function (data) {
        //Append wszystkie
        object.append(new Option("Wszystkie", "-1"))

        //Items from json request
        data.forEach(element => {
            object.append(new Option(element.text, element.id))
        });

    });
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

$("#unewclassfield").click(function (){
    Swal.fire({
        icon: 'info',
        text: 'Aby dodać ogłoszenie musisz się zalgowować lub zarejestrować!',
        confirmButtonText:'Logowanie / Rejestracja',
        showCloseButton: true,
        focusConfirm: false,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.close();
            $('#loginModal').modal('show')
        }
    })
});

//Sweet Alert small toast
function swaltoast(type, message){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: type,
        title: message
    })
}
function link_is_external(link_element) {
    return (link_element.host !== window.location.host);
}
function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(str);
}
$(() =>{
    $('a').click(function (e) {
        if (link_is_external(this) && validURL($(this).attr('href'))){
            console.log('extrenal')
            console.log(this)
            console.log(e)
            e.preventDefault();

            //Information
            Swal.fire({
                html: `<b>Link prowadzi do zewnętrznej strony, czy chcesz kontynować?</b> <br /> <br /> ${$(this).attr('href')}`,
                icon: 'question',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Przejdź',
                cancelButtonText: `Anuluj`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href')
                }
            })

        }
    })
})
