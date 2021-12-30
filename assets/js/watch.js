var map;
var selected_location;
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
        <p class="card-text">Brak ogłoszeń </p>
    </div>
    </div>`
    }


}
function queryParams(params) {
    delete params.sort
    delete params.order
    return params
}

function responseHandler(res) {
    if ($('#table').bootstrapTable('getOptions').sortOrder === 'desc') {
        res.rows = res.rows.reverse()
    }
    return res
}

//onready
$(function(){
    const map = new ol.Map({
        target: 'map-box',
        interactions: ol.interaction.defaults({
            doubleClickZoom: false,
            dragAndDrop: true,
            dragPan: true,
            keyboardPan: false,
            keyboardZoom: false,
            mouseWheelZoom: false,
            pointer: false,
            select: true
        }),
        controls: ol.control.defaults({
            attribution: false,
            zoom: false,
        }),
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM(),
            }),
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat(['19.134422', '52.215933']),
            zoom: 13
        })
    });

    //Search
})


$(document).ready(function () {
    citypicker("#citypicker", selected_location);
    $('.category-select').select2({theme: "bootstrap-5"});
    $('#radius').select2({ theme: "bootstrap-5" });


});
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});



//Search suppor