//table actual
var active_table = $('#active-table');
active_table.bootstrapTable({
    url: '/inc/requests/profile/user_classfields.php?state=1',
    queryParamsType: {state: 1},
    locale: "pl_PL",
    paginationParts: ['pageList']

})


//disactive table
var disactive_table = $('#disactive-table');
disactive_table.bootstrapTable({
    url: '/inc/requests/profile/user_classfields.php?state=0',
    queryParamsType: { state: 1 },
    locale: "pl_PL",
    paginationParts: ['pageList']

})

function refresh_all_tables(){
    active_table.bootstrapTable('refresh');
    disactive_table.bootstrapTable('refresh');

    active_table.bootstrapTable('selectPage', 1)
    diactive_table.bootstrapTable('selectPage', 1)
}

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

            active_table.bootstrapTable('refresh');



        },
        error: function (response) {
            Swal.fire(
                'Błąd!',
                '' + response.responseText,
                'error'
            )

            btn.prop("disabled", false);

        }
    });
    



});
//edit button

$(document).on('click', '.action-edit', function (event) {
    var classfield_id = $(this).data('cid');
    window.location.href = "/u/dodaj?mode=edit&id="+classfield_id;

})

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
                    Swal.fire(
                        'Sukces!',
                        'Akcja została wykonana pomyślnie.',
                        'success'
                    )

                    active_table.bootstrapTable('refresh');
                    

                   

                },
                error: function (response) {
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

//archive button
$(document).on('click', '.action-archive', function (event) {
    var classfield_id = $(this).data('cid');
    Swal.fire({
        title: 'Czy chcesz zakończyć i zarchiwizować to ogłoszenie?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#430091',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Tak, kontynuuj',
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
                url: "/inc/requests/post/archive_post.php",
                data: { 'id': classfield_id },
                success: function (response) {
                    Swal.fire(
                        'Sukces!',
                        'Akcja została wykonana pomyślnie.',
                        'success'
                    )

                    active_table.bootstrapTable('refresh');
                    disactive_table.bootstrapTable('refresh');




                },
                error: function (response) {
                    Swal.fire(
                        'Błąd ' + response.status,
                        '' + response.responseText,
                        'error'
                    )

                }
            });



        }
    })

})

//Active
$(document).on('click', '.action-active', function (event) {
    var classfield_id = $(this).data('cid');
    var btn = $(this);
    btn.prop("disabled", true);
    $.ajax({
        type: "POST",
        url: "/inc/requests/post/active_post.php",
        data: { 'id': classfield_id },
        success: function (response) {
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
                title: 'Pomyślnie aktywowano ogłoszenie!'
            })

            active_table.bootstrapTable('refresh');
            disactive_table.bootstrapTable('refresh');



        },
        error: function (response) {
            Swal.fire(
                'Błąd!',
                '' + response.responseText,
                'error'
            )

            btn.prop("disabled", false);

        }
    });

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
        <p class="card-text">Brak ogłoszeń </p>
    </div>
    </div>`
    }
}
function endedcustomViewFormatter(data) {
    var template = $('#card-template-ended').html()
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
        <p class="card-text">Brak ogłoszeń </p>
    </div>
    </div>`
    }
}

//queryparams
function userclassfieldquery(params) {
    //Searchbox
    var searchboxval = $(".uc-searchbox").val()
    if(searchboxval != null && searchboxval != ''){
        params.q = searchboxval;
    }

    //Sortbox
    params.sortid = $(".sort-box").val();

    console.log('queryParams: ' + JSON.stringify(params))
    return params
}
var searchboxtimer;
$('.uc-searchbox').on('input', function () {
    clearTimeout(searchboxtimer);
    searchboxtimer = setTimeout(function () {
        refresh_all_tables()
    }, 1000); // Will do the ajax stuff after 1000 ms, or 1 s
});
$('.sort-box').on('change', function () {
    refresh_all_tables();
});

