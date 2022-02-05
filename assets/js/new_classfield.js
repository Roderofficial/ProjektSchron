var editor;
var cat_select;
var editor_data = null;
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
            if (item.properties.place_rank >= 12 && item.properties.place_rank <= 18) {
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

function edit_mode_init(){
  //Get edit mode
  var mode = getUrlParameter('mode');
  if (mode == 'edit') {

    //Change names
    //Change titles and button name
    document.title = "Edytuj ogłoszenie - GetPet.pl";
    $("#labelnewclassfieldtitle").html("Edytuj ogłoszenie");
    $("#formclassfieldsubmit").html("Zapisz zmiany");

    //loading information

    var load_info = Swal.fire({ title: "Ładowanie informacji", text: "Twoje ogłoszenie jest pobierane, proszę czekać", icon: "info", showCancelButton: false, showConfirmButton: false, allowOutsideClick: false })


    var edit_id = getUrlParameter('id');
    if (edit_id == false) {
      Swal.fire('Błąd!', 'Nieprawidłowy argument ID', 'error').then(function () {
        window.location = "/";
      });
      
    }


    //Download classfield data
    $.ajax({
      type: "GET",
      url: "/inc/requests/profile/new_classfield_edit_data.php",
      data: {id: edit_id},
      success: function (response) {

        //isnert data
        $("[name='title']").val(response.title);
        tinymce.activeEditor.setContent(response.description, { format: 'raw' });

        //for safe update textarea
        document.getElementById("description").value = response.description;

        cat_select.val(response.classfield_categoryid);
        cat_select.trigger('change');

        $("[name='cost']").val(response.cost);

        $("[name='phone']").val(response.phone);

        $("[name='email']").val(response.email);


        var newOption = new Option(response.location, response.osm_id, false, true);
        $("[name='osm_id']").append(newOption).trigger('change');


        //Load images
        response.photos.forEach(function (item, index) {

          fetch(`/assets/images/classfields/${item}`)
          .then((response) => response.blob())
          .then((blob) => {
            uppy.addFile({
              name: item,
              type: blob.type,
              data: blob
            });
          });
        });






        load_info.close();
      },
      error: function (response) {
        load_info.close();
        Swal.fire('Błąd!', 'Kod błędu: '+ response.status, 'error').then(function () {
          window.location = "/";
        });
        return;
      }
    });


  }
}



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
  cat_select = $('.category-select').select2({ theme: "bootstrap-5" });

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
  editor = tinymce.init({
    selector: '#desceditor',
    plugins: 'lists advlist',
    toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    menubar: false,
    object_resizing: true,
    height: 400
  }).then(function (){

    //init edit mode
    edit_mode_init();
  });


  
  
})

$("#classfield").submit(function (event) {
  event.preventDefault();
  $("#description").val(tinymce.activeEditor.getContent());
  var formdata = new FormData(this);
  //Check if is edit
  if(getUrlParameter("mode") != false){
    formdata.append("mode", getUrlParameter("mode"));
    formdata.append("update_id", getUrlParameter("id"));

  }
  pondFiles = uppy.getFiles();
  for (var i = 0; i < pondFiles.length; i++) {
    if (pondFiles[i].data instanceof Blob){
      const myFile = new File([pondFiles[i].data], pondFiles[i].meta.name, {
        type: pondFiles[i].meta.type,
      });

      // append the file
      formdata.append('images[]', myFile);
    }else{
      // append the file
      formdata.append('images[]', pondFiles[i].data);

    }

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

      var mode = getUrlParameter('mode');
      if(mode == "edit"){
        Swal.fire({
          icon: 'success',
          title: 'Sukces!',
          text: 'Ogłoszenie zostało zaktualizowane, nastąpi przekierowanie!',
          showCancelButton: false, // There won't be any cancel button
          showConfirmButton: false, // There won't be any confirm button
          allowOutsideClick: false
        })

      }else{
        Swal.fire({
          icon: 'success',
          title: 'Sukces!',
          text: 'Ogłoszenie zostało pomyślnie dodane, nastąpi przekierowanie!',
          showCancelButton: false, // There won't be any cancel button
          showConfirmButton: false, // There won't be any confirm button
          allowOutsideClick: false
        })
      }

      
      window.location.replace(response);

    },
    error: function (response) {
      swaltoast("error", `Błąd ${response.status}: ${response.responseText}`)
      grecaptcha.reset();
      animations.enable();

    }
  });
});