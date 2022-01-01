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
            if (item.properties.place_rank >= 8 && item.properties.place_rank <= 16) {
              console.log(item)
              selected_location = item;
              return { id: item.properties.osm_id, text: item.properties.display_name };
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
    maxFileSize: 1000000,
    maxNumberOfFiles: 5,
    minNumberOfFiles: 1,
    allowedFileTypes: ['image/jpg', 'image/jpeg', 'image/png'],
    requiredMetaFields: ['caption'],
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

var toolbareidtor = [['bold', 'italic', 'underline', 'strike'], [{ 'align': [] }], [{ 'list': 'ordered' }, { 'list': 'bullet' }], ,['clean']]
var quill = new Quill('#editor', {
  theme: 'snow',
  placeholder: 'Miejsce na treść ogłoszenia...',
  modules: {
    toolbar: toolbareidtor
  },

});

//on site ready
$(function(){
  //city picker
  citypickeradd('.citypicker')

  //category selector
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

})

$("#classfield").submit(function (event) {
  event.preventDefault();
  $("#hiddenArea").val($("#editor").html());
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
  var submitBtn = $(this).find("input[type=submit]");
  var data = $('#classfield').serialize();
  console.log(data);


  $.ajax({
    type: "POST",
    url: "/inc/requests/profile/new_classfield.php",
    data: formdata,
    processData: false,
    contentType: false,
    beforeSend: function () {
      submitBtn.prop("disabled", true);
    },
    success: function (response) {

      notyf.success("Konto zostało utworzone pomyślnie. Automatyczne przekierowanie...")
      console.log(response);

    },
    error: function (response) {
      notyf.error(`Błąd ${response.status}: ${response.responseText}`)
      grecaptcha.reset();

      console.table(response);
    }
  });
});