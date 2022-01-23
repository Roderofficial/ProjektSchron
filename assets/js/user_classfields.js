//table actual
$('#table').bootstrapTable({
    url: '/inc/requests/profile/user_classfields.php',
    locale: "pl_PL",
    paginationParts: ['pageList']

})

//refresh button
$(document).on('click', '.action-refresh', function (event) {
    var classfield_id = $(this).data('cid');
    var btn = $(this);
    btn.prop("disabled", true);
    $.ajax({
        type: "POST",
        url: "/inc/requests/post/refresh.php",
        data: { 'id': classfield_id },
        success: function (response) {
            console.log(response);
            //Toastr
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
                icon: 'success',
                title: 'Pomyślnie odświeżono ogłoszenie!'
            })

            $('#table').bootstrapTable('refresh');



        },
        error: function (response) {
            console.log(response);
            Swal.fire(
                'Błąd!',
                '' + response.responseText,
                'error'
            )

            btn.prop("disabled", false);

        }
    });
    



});
//remove button

$(document).on('click', '.action-remove', function (event) {
    var classfield_id = $(this).data('cid');
    Swal.fire({
        title: 'Usunąć ogłoszenie?',
        text: "Tej operacji nie można już cofnąć!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#430091',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Tak, usuń!',
        cancelButtonText: `Anuluj`,
    }).then((result) => {
        if (result.isConfirmed) {
            //WHEN REMOVE SUCCESS

            //show waiting box
            Swal.fire({
                title: 'Proszę czekać!',
                html: `Trwa wykonywanie akcji. <br />
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                `,// add html attribute if you want or remove
                icon: 'info',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });


            //Ajax request
            $.ajax({
                type: "POST",
                url: "/inc/requests/post/delete.php",
                data: {'id': classfield_id},
                success: function (response) {
                    console.log(response);
                    Swal.fire(
                        'Sukces!',
                        'Akcja została wykonana pomyślnie.',
                        'success'
                    )

                    $('#table').bootstrapTable('refresh');
                    

                   

                },
                error: function (response) {
                    console.log(response);
                    Swal.fire(
                        'Błąd ' + response.status,
                        ''+response.responseText,
                        'error'
                    )

                }
            });
            


        }
    })

});

function customViewFormatter(data) {
    var template = $('#card-template').html()
    var view = '';
    if (data.length != 0) {
        $.each(data, function (i, row) {
            view += template.replace('%NAME%', row.name)
                .replace('%title%', row.title)
                .replaceAll('%cid%', row.id)
                .replace('%link%', row.link)
                .replace('%location%', row.location)
                .replace('%photo_hash%', row.photo_hash)
                .replace('%create_time%', row.created_at)
                .replace('%expire_time%', row.expire_at)
                .replace('%cost%', row.cost)
        })

        return `<div class="row mx-0">${view}</div>`
    } else {
        return `<div class="card">
    <div class="card-body">
        <p class="card-text">Brak aktywnych ogłoszeń </p>
    </div>
    </div>`
    }
}

