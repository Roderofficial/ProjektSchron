var editor;
var cat_select;
var editor_data = null;
var breed_select;
var gender_select;
var size_select;

function citypickeradd(tag) {
  $(tag).select2({
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
            return {
              id: item.properties.osm_type.charAt(0).toUpperCase() + item.properties.osm_id,
              text: item.properties.display_name
            };
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
  .use(Uppy.ImageEditor, {
    target: Uppy.Dashboard
  })



// EDIT MODE UPDATE DATA
function edit_mode_init() {
  //Get edit mode
  var mode = getUrlParameter('mode');
  if (mode == 'edit') {

    //Change names
    //Change titles and button name
    document.title = "Edytuj ogłoszenie - GetPet.pl";
    $("#labelnewclassfieldtitle").html("Edytuj ogłoszenie");
    $("#formclassfieldsubmit").html("Zapisz zmiany");

    //loading information

    var load_info = Swal.fire({
      title: "Ładowanie informacji",
      text: "Twoje ogłoszenie jest pobierane, proszę czekać",
      icon: "info",
      showCancelButton: false,
      showConfirmButton: false,
      allowOutsideClick: false
    })


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
      data: {
        id: edit_id
      },
      success: function (response) {

        //isnert data
        $("[name='title']").val(response.title);
        tinymce.activeEditor.setContent(response.description, {
          format: 'raw'
        });

        //for safe update textarea
        document.getElementById("description").value = response.description;


        //Category update
        cat_select.val(response.classfield_categoryid);
        cat_select.trigger('change');
        breed_data(response.breed);




        $("[name='cost']").val(response.cost);

        $("[name='phone']").val(response.phone);

        $("[name='email']").val(response.email);


        if(response.name) {$("[name='d_pet_name']").val(response.name)};


        //Gender update
        if(response.gender){
          gender_select.val(parseInt(response.gender));
          gender_select.trigger('change');
        }



        //Size update
        if(response.size){
          size_select.val(response.size);
          size_select.trigger('change');
        }




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


        //Update details points
        update_point_details(response.classfield_categoryid, edit_id);




        load_info.close();
      },
      error: function (response) {
        load_info.close();
        Swal.fire('Błąd!', 'Kod błędu: ' + response.status, 'error').then(function () {
          window.location = "/";
        });
        return;
      }
    });




  }
}


function iformat(icon) {
  var originalOption = icon.element;
  return $('<span>' + icon.text + '</span>');
}
//on site ready

$(function () {
  //Breed select
  breed_select = $('.rasa-select').select2({
    theme: 'bootstrap-5',
    minimumResultsForSearch: -1,
    allowHtml: true,
  });
  //gender picker
  gender_select = $('.gender-select').select2({
    theme: 'bootstrap-5',
    minimumResultsForSearch: -1,
    allowHtml: true
  });

  //Size picker
  size_select = $('.size-select').select2({
    theme: 'bootstrap-5',
    minimumResultsForSearch: -1
  });
  //city picker

  citypickeradd('.citypicker')

  //category selector
  $.get("/inc/requests/categories.php", function (data) {

    //Append wybierz
    var def_option = $("#new-classfield-category-picker").append(new Option("Wybierz...", "-1", true))
    $('#new-classfield-category-picker option[value="-1"]').attr('disabled', 'disabled');

    //Items from json request
    data.forEach(element => {
      var option = $("#new-classfield-category-picker").append(new Option(element.icon + " " + element.text, element.id)).attr({
        "data-icon": element.icon
      })
    });
  });
  cat_select = $('.category-select').select2({
    theme: "bootstrap-5",
    allowHtml: true,
    templateSelection: iformat,
    templateResult: iformat,
  });

  //tinymce
  editor = tinymce.init({
    selector: '#desceditor',
    plugins: 'lists advlist emoticons paste',
    paste_word_valid_elements: 'p,b,strong,i,em,ul,li,td',
    deprecation_warnings: false,
    toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | emoticons",
    language: 'pl',
    menubar: false,
    paste_as_text: true,
    object_resizing: true,
    height: 400
  }).then(function () {

    //init edit mode
    edit_mode_init();
  });




})


$("#classfield").submit(function (event) {
  event.preventDefault();
  $("#description").val(tinymce.activeEditor.getContent());
  var formdata = new FormData(this);
  //Check if is edit
  if (getUrlParameter("mode") != false) {
    formdata.append("mode", getUrlParameter("mode"));
    formdata.append("update_id", getUrlParameter("id"));

  }
  pondFiles = uppy.getFiles();
  for (var i = 0; i < pondFiles.length; i++) {
    if (pondFiles[i].data instanceof Blob) {
      const myFile = new File([pondFiles[i].data], pondFiles[i].meta.name, {
        type: pondFiles[i].meta.type,
      });

      // append the file
      formdata.append('images[]', myFile);
    } else {
      // append the file
      formdata.append('images[]', pondFiles[i].data);

    }

  }

  var form = $(this);
  var notyf = new Notyf({
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
      if (mode == "edit") {
        Swal.fire({
          icon: 'success',
          title: 'Sukces!',
          text: 'Ogłoszenie zostało zaktualizowane, nastąpi przekierowanie!',
          showCancelButton: false, // There won't be any cancel button
          showConfirmButton: false, // There won't be any confirm button
          allowOutsideClick: false
        })

      } else {
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


//Point details
$('#new-classfield-category-picker').on('select2:select', function (e) {
  var data = e.params.data;
  breed_data();
  update_point_details(data.id);
  

});

function update_point_details(catid, classfield_id = null) {
  //Get Data
  $.get("/inc/requests/post/category_details_point.php", {
    id: catid
  }, function (data) {
    if (!jQuery.isEmptyObject(data)) {
      //Create detail card
      //Remove old card 
      $('.point-details').remove();
      var card_details = $('.details-section').append('<div class="row point-details "><label>Karta charakterystyki</label></div>');

      //Append points
      for (const [key, value] of Object.entries(data)) {
        $(".point-details").append(`
        <div class="col-12 col-md-6 mb-2 input-point-group">
          <input class="form-check-input checkbox-dp" name="point_details[]" type="checkbox" value="${value.id}" id="dp${value.id}">
          <label class="form-check-label label-dp" for="dp${value.id}">
            ${value.text}
          </label>
        </div>
        
        `)
      }

      //Update edit when classfield_id is not null
      if (classfield_id != null) {
        $.get("/inc/requests/post/point_details.php", {
          id: classfield_id
        }, function (data) {
          if (!jQuery.isEmptyObject(data)) {
            for (const [key, value] of Object.entries(data)) {
              $(".point-details").find(`:checkbox[value=${value}]`).attr("checked", "true");
            }
          }
        })
      }



    } else {
      //Remove card when exist
      $('.point-details').remove();
    }

  });
}

//Function for dynamic generation breed data from get url
function breed_data(selected_id = null) {

  $('.rasa-select').empty();
  $('.rasa-select').trigger('change');

  var category_id = cat_select.val()
  //Disabled breed select when category is null
  if (category_id == null) {
    breed_select.prop("disabled", true);
    return
  } else {
    $.get("/inc/requests/post/breeds.php", {
      id: category_id
    }, function (data) {

      //Append empty first row with value (Brak Informacji)
      data.unshift({
        id: '',
        text: 'Brak informacji'
      })

      //Init breed select2
      breed_select = $('.rasa-select').select2({
        data: data,
        theme: 'bootstrap-5',
      })

    }).then(() => {
      //Update selected id after load if exist variable and not null
      breed_select.prop("disabled", false);

      if (selected_id != null) {
        $('#rasa-select').val(selected_id);
        $('#rasa-select').trigger('change');
        

      }
    })

  }



}