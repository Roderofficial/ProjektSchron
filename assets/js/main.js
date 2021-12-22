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
        url: "/inc/login/validate_login.php",
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
            }
            
            console.table(response);
        },
         });
});