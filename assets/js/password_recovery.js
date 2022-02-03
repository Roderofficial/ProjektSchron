$("#pwdreset").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);

    $.ajax({
        type: "POST",
        url: "/inc/requests/auth/reset_password_process.php",
        data: form.serialize(), // serializes the form's elements.
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Sukces!',
                text: 'Twoje hasło zostało pomyślnie zmienione!',
                showCancelButton: false, // There won't be any cancel button
                showConfirmButton: false, // There won't be any confirm button
                allowOutsideClick: false,
                timer: 3000,
                timerProgressBar: true,
            }).then(() =>{
                window.location.replace("/");
            })
            grecaptcha.reset()
        },
        error: function (response){
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
                icon: 'error',
                title: `Błąd ${response.status}: ${response.responseText}`
            })
            
            grecaptcha.reset()
        }
    });

});