function citypicker(tag){
    $(tag).select2(
        {
            theme: 'bootstrap-5',
            allowHtml: true,
            
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