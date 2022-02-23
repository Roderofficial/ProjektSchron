var map;
var selected_location;
var radius_picker;
var citypicker_obj;

$('#table').bootstrapTable({
    url: '/inc/requests/classfields-watch.php',
    locale: "pl_PL",
    paginationParts: ['pageList']

})

$('#table').on('page-change.bs.table', function (e,number) {
  const url = new URL(window.location);
    url.searchParams.set('page', number);
    window.history.pushState({}, '', url);
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

    //update cost man
    var data_osm_id = getUrlParameter('osm_id');

    if(data_osm_id != false){
        $.get("https://nominatim.openstreetmap.org/lookup?osm_ids=" + data_osm_id + "&format=json", function (data) {

            var newOption = new Option(data[0].display_name, data_osm_id, false, true);
            $('#citypicker').append(newOption).trigger('change');
            $('#citypicker').select2('refresh');
            refresh_table();
        });

    }

    var pageno = getUrlParameter('page');
    if(pageno != false){
        $('#table').bootstrapTable('selectPage', parseInt(pageno))
        console.log(pageno);
    }

    


})
function refresh_table(){
    $('#table').bootstrapTable('refresh')
    $('#table').bootstrapTable('selectPage', 1)

}

$(".btn-search-clear").click((e) =>{
    $('#citypicker').val(null).trigger('change');
})

$(".btn-free").click(() =>{
    $("[name='cost_min']").val(0);
    $("[name='cost_max']").val(0);
})

$('#table').on('page-change.bs.table', function (e, arg1) {
    $('html, body').animate({
        scrollTop: $('.bootstrap-table').offset().top - 20
    }, 'slow');
})

$(()=>{
    //category selector
    $.get("/inc/requests/categories.php", function (data) {

        //Append wybierz
        var def_option = $("#category-select").append(new Option("Wszystkie", "-1",true))

        //Items from json request
        data.forEach(element => {
        var option = $("#category-select").append(new Option(element.icon + " " +element.text, element.id)).attr({"data-icon": element.icon})
        });

        var category = getUrlParameter('category-select');
        if(category != false){
            if (category != false) {
                $(`#category-select option[value=${category}]`).prop('selected', true);
                refresh_table();
            }
        }
    });
    $('.category-select').select2({ 
        theme: "bootstrap-5",
        width:"100%",
        allowHtml: true,
        templateSelection: iformat,
        templateResult: iformat
    });


})
function iformat(icon) {
  var originalOption = icon.element;
  return $('<span>' + icon.text + '</span>');
}