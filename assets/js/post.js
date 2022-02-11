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
                    color: '#543884',
                    width: 5
                }),
                fill: new ol.style.Fill({
                    color: '#5438844d'
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
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([geo_long, geo_lat]),
            zoom: 13
        })
    });
    map.addLayer(circle_layer);
    


    $(".placeholder").removeClass("placeholder");
});

//contact data load
$("#getcontactbtn").click(function () {
    var current_btn = $("#getcontactbtn")[0].innerHTML;
    $(this).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span> Ładowanie`);
    $(this).prop("disabled", true);
    $.ajax({
        type: "POST",
        data: {"post_id": post_id},
        url: "/inc/requests/post/contact_details.php",
        success: function (response) {
            if(response.email != null && response.email != ''){
                var email_html = `<a href="mailto:${response.email}" class="btn btn-outline-primary"" role="button" aria-disabled="true"><i class="fas fa-envelope me-1"></i> ${response.email}</a>`;
            }else{
                var email_html = '';
            }
            console.log(response.email);
            var contact_details = `
            <div class="d-grid gap-2">
                <a href="tel:${response.phone}" class="btn btn-outline-primary"" role="button" aria-disabled="true"><i class="fas fa-phone-alt me-1"></i> ${response.phone}</a>
                ${email_html}
            </div>
            `
            $(".contactdetail").html(contact_details);
            $("#contactcard").addClass("border-primary")

        },
        error: function (response) {
            $("#getcontactbtn")[0].innerHTML = current_btn;
            $("#getcontactbtn").prop("disabled", false);
            var notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
            });
            notyf.error('Wystąpił błąd podczas pobierania danych.');
            

            
        }
    });



});
//autolink
$(".description").html(Autolinker.link($(".description").html(),{
    newWindow: true,
    urls: true,
    phone: true
}));
