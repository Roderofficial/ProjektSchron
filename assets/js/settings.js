//tinymce
var test;
var notyf = new Notyf();
editor = tinymce.init({
  selector: '#desceditor',
  plugins: 'lists advlist',
  toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
  menubar: false,
});

$("form").submit(function(e){

    //prevent default
    e.preventDefault();

    //define variables
    var form = e;
    var action_form = e.currentTarget.getAttribute('action')
    var data_form  = new FormData(this);
    test = form;
    console.log(data_form);

    //Trigger tynemce to save data
    tinyMCE.triggerSave();

    //request
    $.ajax({
      url: action_form,
      type: 'POST',
      data: data_form,

      //Success
      success: function (data) {
          console.log(data);
          console.info('sukces')
          notyf.success("Dane zostały zapisane pomyślnie.")
      },

      //Error
      error: function (data){
          console.error(data)
          console.info('błąd')
          notyf.error(`Błąd ${data.status}: ${data.responseText}`)
      },
      cache: false,
      contentType: false,
      processData: false
  });
    
    console.log(data);
});