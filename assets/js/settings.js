//tinymce
var test;
var notyf = new Notyf({
  position: {
    x: 'right',
    y: 'top',
  },
});
editor = tinymce.init({
  selector: '#desceditor',
  plugins: 'lists advlist',
  toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
  menubar: false,
});

//City picker
function citypickeradd(tag) {
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
            if (item.properties.place_rank >= 12) {
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

citypickeradd('#citypicker');

$("form").submit(function(e){

    //prevent default
    e.preventDefault();

    //Trigger tynemce to save data
    tinyMCE.triggerSave();

    //define variables
    var form = e;
    var action_form = e.currentTarget.getAttribute('action')
    var data_form  = new FormData(this);
    test = form;

    //Animations
    var animations = new updating_animations('#' + test.currentTarget.id);
  

    //request
    $.ajax({
      url: action_form,
      type: 'POST',
      data: data_form,
      beforeSend: function () {
        animations.disable();

      },

      //Success
      success: function (data) {
        swaltoast("success", "Ustawienia zostały zapisane pomyślnie!")
      },

      //Error
      error: function (data){
        swaltoast("error", `Błąd ${data.status}: ${data.responseText}`)
      },

      complete: function(){
        animations.enable();

      },
      cache: false,
      contentType: false,
      processData: false
  });
    
});

$(".btn-search-clear").click((e) => {
  $('#citypicker').val(null).trigger('change');
})