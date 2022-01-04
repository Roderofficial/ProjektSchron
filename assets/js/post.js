$(function () {
    //IMAGES SWIPER
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
            type: "fraction",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    //MAP ICON POINT
    // const iconFeature = new ol.Feature({
    //     geometry: new ol.geom.Point(ol.proj.fromLonLat([geo_long, geo_lat])),
    //     name: 'Somewhere near Nottingham',
    // });

    //MAP CIRCLE
    var centerLongitudeLatitude = ol.proj.fromLonLat([geo_long, geo_lat]);
    var circle_layer = new ol.layer.Vector({
        source: new ol.source.Vector({
            projection: 'EPSG:4326',
            features: [new ol.Feature(new ol.geom.Circle(centerLongitudeLatitude, 1000))]
        }),
        style: [
            new ol.style.Style({
                stroke: new ol.style.Stroke({
                    color: 'blue',
                    width: 3
                }),
                fill: new ol.style.Fill({
                    color: 'rgba(0, 0, 255, 0.1)'
                })
            })
        ]
    });

    //MAP
    const map = new ol.Map({
        target: 'map-box',
        interaction: [],
        control: [],
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM(),
            }),
            new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [iconFeature]
                }),
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.8, 32],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'pixels',
                        src: '/assets/images/pin.png'
                    })
                })
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([geo_long, geo_lat]),
            zoom: 13
        })
    });
    map.addLayer(circle_layer);
    


    $(".placeholder").removeClass("placeholder");
});