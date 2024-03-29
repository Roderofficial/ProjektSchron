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
        data: {
            "post_id": post_id
        },
        url: "/inc/requests/post/contact_details.php",
        success: function (response) {
            if (response.email != null && response.email != '') {
                var email_html = `<a href="mailto:${response.email}" class="btn btn-outline-primary"" role="button" aria-disabled="true"><i class="fas fa-envelope me-1"></i> ${response.email}</a>`;
            } else {
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
$(".description").html(Autolinker.link($(".description").html(), {
    newWindow: true,
    urls: true,
    phone: true
}));


function more_classfields() {
    //Get more classfields
    $.get(`/inc/requests/more_classfields.php?lat=${geo_lat}&lon=${geo_long}`, function (data) {
        data.forEach(function (row) {
            addClassfield(row);
        });
    }).then(() => {
        //Add carousel
        $(".owl-carousel").owlCarousel({
            autoWidth: true,
            margin: 10,
            dots: true,
            lazyLoad: true,
            animateIn: true,
            loop: true,
        });

    });


}

function addClassfield(data) {
    $(".owl-carousel").append(
        `
                <div class="card classfield-card-preview">
                    <div style="background: url('/assets/images/classfields/${data.photo_hash}'); background-size: cover; background-position: center;" class="classfieldimage">
                        <div class="cost-badge">${data.cost}</div>
                    </div>
                    <div class="card-body">
                        <a href="${data.link}" class="card-title stretched-link">${data.title}</a>
                        <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> ${data.location}</small></p>
                    </div>
                </div>
        `
    )

}

//Detail points
function update_detail_points(classfield_id, cat_id) {
    //Cehck if classfield has detail points
    $.get("/inc/requests/post/point_details.php", {
        id: classfield_id
    }, function (classfield_point_details) {
        if (!jQuery.isEmptyObject(classfield_point_details)) {
            //Get all points in categories
            $.get("/inc/requests/post/category_details_point.php", {
                id: cat_id
            }, function (category_points) {


                var points_box = $('.post-points-detail');
                var point_row = $(".post-points-detail .points-rows")

                //Add points
                for (const [key, value] of Object.entries(category_points)) {

                    //Append col
                    var point = point_row.append(` 
                    <div class="col-12 col-md-6 mb-2  point" data-pid="${value.id}">
                        <span class="align-middle"><i class="fa-solid fa-circle-check"></i></span><span class="ms-2">${value.text}</span>
                    </div>
                    `)

                    //Check if checked and color change icon
                    if (classfield_point_details.includes(value.id)) {
                        if (value.background == null) {
                            var point_color = '#430091';
                        } else {
                            var point_color = value.background;
                        }

                    } else {
                        var point_color = '#e4e4e4';
                    }


                    //Replace color in icon
                    point.find(`[data-pid='${value.id}'] i`).css("color", point_color);

                }

                //Remove class d-none from post-points-detail
                points_box.removeClass("d-none")

            });

        }
    })

}

//Update table with pet details 
function update_table() {

    var gender = ['Ona', 'On'];
    var pet_size = [null, "Bardzo mały", "Mały", "Średni", "Duży"];

    //Generate TD to insert into table
    function generate_td(row_name, row_value) {
        var td =
            `
        <tr>
            <th scope="row">${row_name}</th>
            <td>${row_value}</td>
        </tr>

        `
        return td;
    }

    //Show table to update
    var table = $('.details-table')
    var table_body = table.children('tbody');
    table.removeClass("d-none");


    //Append data into tbody in table
    if (post_name != null) table_body.append(generate_td("Imię", post_name))
    if (post_breed != null) table_body.append(generate_td("Rasa", post_breed))
    if (post_gender != null) table_body.append(generate_td("Płeć", gender[parseInt(post_gender)]))
    if (post_size != null) table_body.append(generate_td("Wielkość", pet_size[parseInt(post_size)]))
    

    //Append location
    table_body.append(generate_td("Lokalizacja", `${post_location} (${post_wojewodztwo})`))



}

$(() => {
    update_detail_points(post_id, post_cat);
    update_table();
    more_classfields();
})