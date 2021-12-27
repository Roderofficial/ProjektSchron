$('#table').bootstrapTable({
    url: '/inc/requests/classfields-watch.php',
    locale: "pl_PL",

})

function customViewFormatter(data) {
    var template = $('#card-template').html()
    var view = '';
    if (data.length != 0) {
        $.each(data, function (i, row) {
            view += template.replace('%NAME%', row.name)
                .replace('%title%', row.title)
                .replace('%link%', row.link)
                .replace('%location%', row.location)
                .replace('%photo_hash%', row.photo_hash)
                .replace('%cost%', row.cost)
        })

        return `<div class="row mx-0">${view}</div>`
    } else {
        return `<div class="card">
    <div class="card-body">
        <p class="card-text">Użytkownik nie posiada aktywnych ogłoszeń </p>
    </div>
    </div>`
    }


}