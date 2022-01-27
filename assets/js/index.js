function getData(){
    //loading circle
    $(".classfields-cards").html(`
    <div class="d-flex justify-content-center mb-3">
        <div class="spinner-border spinner-border-xl" role="status">
            <span class="visually-hidden">Ładowanie...</span>
        </div>
    </div>
    `)

    $.get("/inc/requests/classfield-main-page.php", function (data) {

        //parse data
        var decoded_data = JSON.parse(data);
        
        //remove loading icon
        $(".classfields-cards").html("")

        //add cards
        for (element of decoded_data){
            addClassfield(element);
        }

        var view_more_card = $("template#view-more-card")[0].innerHTML;
        $(".classfields-cards").append(view_more_card);
    });

}

//function for generation card
function addClassfield(data){
    $(".classfields-cards").append(
        `
        <div class="col-lg-3 col-md-4 col-sm-6 cardcol">
                <div class="card classfield-card-preview">
                    <div style="background: url('/assets/images/classfields/${data.photo_hash}'); background-size: cover; background-position: center;" class="classfieldimage">
                        <div class="cost-badge">${data.cost}</div>
                    </div>
                    <div class="card-body">
                        <a href="${data.link}" class="card-title">${data.title}</a>
                        <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> ${data.location}</small></p>
                    </div>
                </div>
            </div>
        `
    )

}

//Citypicker
function citypicker(tag) {
    $(tag).select2(
        {
            theme: 'bootstrap-5',
            ajax: {
                url: 'https://nominatim.openstreetmap.org/search',
                type: "GET",
                delay: 500,
                minimumInputLength: 3,
                allowClear: 1,
                data: function (params) {
                    return {
                        q: params.term,
                        format: 'geojson',
                        addressdetails: 1,
                        countrycodes: "pl",
                        dedupe: 1,
                        extratags: 1,
                        limit: 1,
                        polygon_geojson: 1
                    };
                },
                processResults: function (data) {
                    var res = data.features.map(function (item) {
                        if ((item.properties.place_rank >= 12 && item.properties.place_rank <= 18) || item.properties.place_rank == 8) {
                            selected_location = item;
                            return { id: item.properties.osm_type.charAt(0).toUpperCase() + item.properties.osm_id, text: item.properties.display_name };
                        } else {
                            return {}
                        }


                    });
                    return {
                        results: res
                    };
                }
            },

        });
}


//ONLOAD
$(function () {
    getData();
    citypicker("#citypicker");
    category_public_insert("#category-select");
});