var editor;
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
          console.log(data)
          var res = data.features.map(function (item) {
            if (item.properties.place_rank >= 12 && item.properties.place_rank <= 18) {
              console.log(item)
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

var uppy = new Uppy.Core({
  restrictions: {
    maxFileSize: 5000000,
    maxNumberOfFiles: 5,
    minNumberOfFiles: 1,
    allowedFileTypes: ['image/jpg', 'image/jpeg', 'image/png']
  },
})
.use(Uppy.Dashboard, {
  inline: true,
  target: '#drag-drop-area',
  height: 400,
  locale: Uppy.locales.pl_PL,
  hideUploadButton: true,
  hideCancelButton: true
})
.use(Uppy.ImageEditor, { target: Uppy.Dashboard })


//on site ready
$(function(){
  //city picker
  citypickeradd('.citypicker')

  //category selector
  $.get("/inc/requests/categories.php", function (data) {

    //Append wybierz
    var def_option = $("#new-classfield-category-picker").append(new Option("Wybierz...", "-1",true))
    $('#new-classfield-category-picker option[value="-1"]').attr('disabled', 'disabled');

    //Items from json request
    data.forEach(element => {
      $("#new-classfield-category-picker").append(new Option(element.text, element.id))
    });
  });
  $('.category-select').select2({ theme: "bootstrap-5" });

  //add map
  const map = new ol.Map({
    target: 'map-box',

    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM(),
      }),
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat(['19.134422', '52.215933']),
      zoom: 13
    })
  });

  //tinymce
  //tinymce
  editor = tinymce.init({
    selector: '#desceditor',
    plugins: 'lists advlist',
    toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    menubar: false,
  });


  //only numer input
})

$("#classfield").submit(function (event) {
  event.preventDefault();
  $("#description").val(tinymce.activeEditor.getContent());
  var formdata = new FormData(this);
  pondFiles = uppy.getFiles();
  for (var i = 0; i < pondFiles.length; i++) {
    // append the blob file
    formdata.append('images[]', pondFiles[i].data);
  }

  var form = $(this);
  var notyf = new Notyf(
    {
      duration: 6000,
      position: {
        x: 'center',
        y: 'top',
      }
    });
  var data = $('#classfield').serialize();
    
  //Animations
  var animations = new updating_animations('#classfield')


  $.ajax({
    type: "POST",
    url: "/inc/requests/profile/new_classfield.php",
    data: formdata,
    processData: false,
    contentType: false,
    beforeSend: function () {
      animations.disable();
      
    },
    success: function (response) {

      notyf.success("Konto zostało utworzone pomyślnie. Automatyczne przekierowanie...")
      window.location.replace(response);

    },
    error: function (response) {
      notyf.error(`Błąd ${response.status}: ${response.responseText}`)
      grecaptcha.reset();
      animations.enable();

    }
  });
});