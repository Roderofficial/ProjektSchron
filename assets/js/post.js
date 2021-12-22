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
    var map = new ol.Map({
        target: 'map-box',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([52.23, 21.01]),
            zoom: 6
        }),
        
    });


    $(".placeholder").removeClass("placeholder");
});