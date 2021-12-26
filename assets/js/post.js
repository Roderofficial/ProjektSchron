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
    //MAP
    const iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([geo_long, geo_lat])),
        name: 'Somewhere near Nottingham',
    });

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
    


    $(".placeholder").removeClass("placeholder");
});