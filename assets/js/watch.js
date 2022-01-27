var map;
var selected_location;
var radius_picker;
var citypicker_obj;

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



$(document).ready(function () {
    citypicker_obj = citypicker("#citypicker", selected_location);
    radius_picker = $('#radius').select2({ theme: "bootstrap-5" });


});
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});



//Update select map
$('#citypicker').on('select2:selecting', function (e) {
    //Disable radius if województwo 
    if(selected_location.properties.place_rank == 8){
        radius_picker[0].disabled = true;
        radius_picker.prop("selectedIndex", 0).change()

    }else{
        radius_picker[0].disabled = false; 
    }


})

function queryParams(params) {
    $("#searchform").serializeArray().map(function(val){
        params[val.name] = val.value
    });
    return params
}
//search btn
$("#searchform").submit(function (event) {
    event.preventDefault();
    form = event;
    // var serialize_obj = $("#searchform").serialize();
    // current_page = location.protocol + '//' + location.host + location.pathname;
    // document.location.href = current_page + '?' + serialize_obj;
    // console.log(serialize_obj)
    $('#table').bootstrapTable('refresh')
    $('#table').bootstrapTable('selectPage', 1)

});



//update on page load attributes if exist for main page data
$(function(){
    //Category selector

    //update min cost
    var data_cost_min = getUrlParameter('osm_id');
    
    


    //update cost man
    var data_osm_id = getUrlParameter('osm_id');

    $.get("https://nominatim.openstreetmap.org/lookup?osm_ids=" + data_osm_id + "&format=json", function (data) {

        var newOption = new Option(data[0].display_name, data_osm_id, false, true);
        $('#citypicker').append(newOption).trigger('change');
        $('#citypicker').select2('refresh');
        refresh_table();
    });


    //Load categories and auto
    $.get("/inc/requests/categories.php", function (data) {
        //Append wszystkie
        var object = $("#category-select");
        object.append(new Option("Wszystkie", "-1"))

        //Items from json request
        data.forEach(element => {
            object.append(new Option(element.text, element.id))
        });

        var category = getUrlParameter('category-select');
        if (category != false) {
            $(`#category-select option[value=${category}]`).prop('selected', true);
            refresh_table();
        }
    });




})
function refresh_table(){
    $('#table').bootstrapTable('refresh')
    $('#table').bootstrapTable('selectPage', 1)

}