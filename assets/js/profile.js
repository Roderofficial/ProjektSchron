$('#table').bootstrapTable({
    url: '/inc/requests/classfields-member.php',
    locale: "pl_PL",
    paginationParts: ['pageList']

})

function queryParams(params) {
    $("#searchform").serializeArray().map(function(val){
        params[val.name] = val.value
    });
    params["userid"] = userid.toString();
    return params
}

//search btn
$("#searchform").submit(function (event) {
    event.preventDefault();
    form = event;
    // var serialize_obj = $("#searchform").serialize();
    // current_page = location.protocol + '//' + location.host + location.pathname;
    // document.location.href = current_page + '?' + serialize_obj;
    // console.log(serialize_obj)
    $('#table').bootstrapTable('refresh')
    $('#table').bootstrapTable('selectPage', 1)

});

//City picker / radius picker
$(() =>{
    citypicker("#citypicker");
    var radius_picker = $('#radius').select2({ theme: "bootstrap-5" });
})

//Category picker
$(()=>{
    //category selector
    $.get("/inc/requests/categories.php", function (data) {

        //Append wybierz
        var def_option = $("#category-select").append(new Option("Wszystkie", "-1",true))

        //Items from json request
        data.forEach(element => {
        var option = $("#category-select").append(new Option(element.icon + " " +element.text, element.id)).attr({"data-icon": element.icon})
        });

        var category = getUrlParameter('category-select');
        if(category != false){
            if (category != false) {
                $(`#category-select option[value=${category}]`).prop('selected', true);
                refresh_table();
            }
        }
    });
    $('.category-select').select2({ 
        theme: "bootstrap-5",
        width:"100%",
        allowHtml: true,
        templateSelection: iformat,
        templateResult: iformat
    });


})
function iformat(icon) {
  var originalOption = icon.element;
  return $('<span>' + icon.text + '</span>');
}


//Card formater
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
        <p class="card-text">Brak ogłoszeń </p>
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

        //create form with image to send
        var fd = new FormData();
        fd.append('file', files[0], files[0].name);
        fd.append('type', 'background')
        notyf.open({ type: 'info', message: "Trwa aktualizacja baneru" })
        
        //Ajax request
        $.ajax({
            url: '/inc/requests/profile/update-image.php',
            type: 'POST',
            data: fd,

            //Success
            success: function (data) {
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

        //create form with image to send
        var fd = new FormData();
        fd.append('file', files[0], files[0].name);
        fd.append('type', 'avatar')
        notyf.open({ type: 'info', message: "Trwa aktualizacja avataru" })

        //Ajax request
        $.ajax({
            url: '/inc/requests/profile/update-image.php',
            type: 'POST',
            data: fd,

            //Success
            success: function (data) {
                notyf.success('Pomyślnie zaktualizowano avatar!');
                $('.avatar').css('background-image', 'url("' + data + '")');
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

function public_location_update(){
    console.log(location_public)
    if (location_public == null){
        return
    }

    $.ajax({
        type: "GET",
        url: "https://nominatim.openstreetmap.org/lookup?format=json&osm_ids="+location_public,
        processData: false,
        contentType: false,
        success: function (response) {
            if(response[0].display_name != null){
                $('.location_content').html(response[0].display_name);

            }else{
                Swal.fire(
                    'Błąd!',
                    'Nie udało się załadować lokalizacji!',
                    'error'
                )
            }
            

        },
        error: function (response) {
            Swal.fire(
                'Błąd!',
                'Nie udało się załadować lokalizacji!',
                'error'
            )

        }
    });
}
$(() =>{
    public_location_update()
})