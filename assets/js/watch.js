var map;
var selected_location;
var radius_picker;

$('#table').bootstrapTable({
    url: '/inc/requests/classfields-watch.php',
    locale: "pl_PL",
    paginationParts: ['pageList']

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

    //MAPBOX GENERATE
})


$(document).ready(function () {
    citypicker("#citypicker", selected_location);
    $('.category-select').select2({theme: "bootstrap-5"});
    radius_picker = $('#radius').select2({ theme: "bootstrap-5" });


});
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});



//Update select map
$('#citypicker').on('select2:selecting', function (e) {
    console.log('Selecting: ', e.params.args.data);
    console.log('test')
    console.log("Response from select request", selected_location);
    //Disable radius if województwo 
    if(selected_location.properties.place_rank == 8){
        radius_picker[0].disabled = true;
        radius_picker.prop("selectedIndex", 0).change()

    }else{
        radius_picker[0].disabled = false; 
    }

    // const styles = [
    //     /* We are using two different styles for the polygons:
    //      *  - The first style is for the polygons themselves.
    //      *  - The second style is to draw the vertices of the polygons.
    //      *    In a custom `geometry` function the vertices of a polygon are
    //      *    returned as `MultiPoint` geometry, which will be used to render
    //      *    the style.
    //      */
    //     new ol.style.Style({
    //         stroke: new ol.style.Stroke({
    //             color: 'blue',
    //             width: 3,
    //         }),
    //         fill: new ol.style.Fill({
    //             color: 'rgba(0, 0, 255, 0.1)',
    //         }),
    //     }),
    //     new ol.style.Style({
    //         image: new ol.style.Circle({
    //             radius: 5,
    //             fill: new ol.style.Fill({
    //                 color: 'orange',
    //             }),
    //         }),
    //         geometry: function (feature) {
    //             // return the coordinates of the first ring of the polygon
    //             const coordinates = feature.getGeometry().getCoordinates()[0];
    //             return new MultiPoint(coordinates);
    //         },
    //     }),
    // ];
    // const geojsonObject = {
    //     'type': 'FeatureCollection',
    //     'crs': {
    //         'type': 'name',
    //         'properties': {
    //             'name': 'EPSG:3857',
    //         },
    //     },
    //     'features': [
    //         {
    //             'type': 'Feature',
    //             'geometry': {
    //                 'type': 'Polygon',
    //                 'coordinates': [
    //                     [
    //                         [-5e6, 6e6],
    //                         [-5e6, 8e6],
    //                         [-3e6, 8e6],
    //                         [-3e6, 6e6],
    //                         [-5e6, 6e6],
    //                     ],
    //                 ],
    //             },
    //         },
    //         {
    //             'type': 'Feature',
    //             'geometry': {
    //                 'type': 'Polygon',
    //                 'coordinates': [
    //                     [
    //                         [-2e6, 6e6],
    //                         [-2e6, 8e6],
    //                         [0, 8e6],
    //                         [0, 6e6],
    //                         [-2e6, 6e6],
    //                     ],
    //                 ],
    //             },
    //         },
    //         {
    //             'type': 'Feature',
    //             'geometry': {
    //                 'type': 'Polygon',
    //                 'coordinates': [
    //                     [
    //                         [1e6, 6e6],
    //                         [1e6, 8e6],
    //                         [3e6, 8e6],
    //                         [3e6, 6e6],
    //                         [1e6, 6e6],
    //                     ],
    //                 ],
    //             },
    //         },
    //         {
    //             'type': 'Feature',
    //             'geometry': {
    //                 'type': 'Polygon',
    //                 'coordinates': [
    //                     [
    //                         [-2e6, -1e6],
    //                         [-1e6, 1e6],
    //                         [0, -1e6],
    //                         [-2e6, -1e6],
    //                     ],
    //                 ],
    //             },
    //         },
    //     ],
    // };

    // const source = new ol.layer.Vector({
    //     features: new ol.source.GeoJSON().readFeatures(geojsonObject),
    // });

    // const layer = new ol.layer.VectorLayer({
    //     source: source,
    //     style: styles,
    // });

    // map.addLayer(layer);
});
function queryParams(params) {
    $("#searchform").serializeArray().map(function(val){
        params[val.name] = val.value
    });
    return params
}
//search btn
$("#searchform").submit(function (event) {
    event.preventDefault();
    $('#table').bootstrapTable('refresh')
});