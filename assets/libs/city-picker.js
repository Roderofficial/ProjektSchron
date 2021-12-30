function citypicker(tag){
    $(tag).select2(
        {
            theme: 'bootstrap-5',
            dropdownParent: $('#offcanvasExample'),
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
                        limit: 1
                    };
                },
                processResults: function (data) {
                    console.log(data)
                    var res = data.features.map(function (item) {
                        if (item.properties.place_rank >= 10 && item.properties.place_rank <= 16) {
                            console.log(item)
                            selected_location = item;
                            return { id: item.properties.place_id, text: item.properties.display_name };
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