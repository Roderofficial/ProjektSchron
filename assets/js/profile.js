$('#table').bootstrapTable({
    url: '/inc/requests/classfields-member.php?userid=' + userid.toString(),
    locale: "pl_PL",

})

function customViewFormatter(data) {
    var template = $('#card-template').html()
    var view = '';
    if(data.length != 0){
        $.each(data, function (i, row) {
            view += template.replace('%NAME%', row.name)
                .replace('%title%', row.title)
                .replace('%link%', row.link)
                .replace('%location%', row.location)
                .replace('%photo_hash%', row.photo_hash)
                .replace('%cost%', row.cost)
        })

        return `<div class="row mx-0">${view}</div>`
    }else{
        return `<div class="card">
    <div class="card-body">
        <p class="card-text">Użytkownik nie posiada aktywnych ogłoszeń </p>
    </div>
    </div>`
    }
}

//Background update
$("#bannerupdate").click(function () {
    //Notyf
    var notyf = new Notyf(
        {
            duration: 4000,
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                    type: 'info',
                    background: '#0d6efd',
                    icon: false
                }
            ]
        });
    
    //Create and config input
    let input = document.createElement('input');
    input.type = 'file';
    input.accept = "image/png, image/jpeg"
    //ON file select
    input.onchange = _ => {
        // you can use this method to get file and perform respective operations
        let files = Array.from(input.files);
        console.log(files);

        //create form with image to send
        var fd = new FormData();
        fd.append('file', files[0], files[0].name);
        notyf.open({ type: 'info', message: "Trwa aktualizacja baneru" })
        
        //Ajax request
        $.ajax({
            url: '/inc/requests/profile/update-banner.php',
            type: 'POST',
            data: fd,

            //Success
            success: function (data) {
                console.log(data);
                notyf.success('Pomyślnie zaktualizowano banner!');
                $('.background-image').css('background-image', 'url("' + data + '")');
            },

            //Error
            error: function (data){
                notyf.error("Błąd " + data.status)
            },
            cache: false,
            contentType: false,
            processData: false
        });
    };
    input.click();
});

//Avatar update
//Background update
$("#avatar-update").click(function () {
    //Notyf
    var notyf = new Notyf(
        {
            duration: 4000,
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                    type: 'info',
                    background: '#0d6efd',
                    icon: false
                }
            ]
        });

    //Create and config input
    let input = document.createElement('input');
    input.type = 'file';
    input.accept = "image/png, image/jpeg"
    //ON file select
    input.onchange = _ => {
        // you can use this method to get file and perform respective operations
        let files = Array.from(input.files);
        console.log(files);

        //create form with image to send
        var fd = new FormData();
        fd.append('file', files[0], files[0].name);
        notyf.open({ type: 'info', message: "Trwa aktualizacja baneru" })

        //Ajax request
        $.ajax({
            url: '/inc/requests/profile/avatar-banner.php',
            type: 'POST',
            data: fd,

            //Success
            success: function (data) {
                console.log(data);
                notyf.success('Pomyślnie zaktualizowano banner!');
                $('.background-image').css('background-image', 'url("' + data + '")');
            },

            //Error
            error: function (data) {
                notyf.error("Błąd " + data.status)
            },
            cache: false,
            contentType: false,
            processData: false
        });
    };
    input.click();
});