function getData(){
    //loading circle
    $(".classfields-cards").html(`
    <div class="d-flex justify-content-center mb-3">
        <div class="spinner-border spinner-border-xl" role="status">
            <span class="visually-hidden">Ładowanie...</span>
        </div>
    </div>
    `)

    $.get("/inc/requests/classfield-main-page.php", function (data) {

        //parse data
        var decoded_data = JSON.parse(data);
        
        //remove loading icon
        $(".classfields-cards").html("")

        //add cards
        for (element of decoded_data){
            addClassfield(element);
        }

        var view_more_card = $("template#view-more-card")[0].innerHTML;
        $(".classfields-cards").append(view_more_card);
    });

}

//function for generation card
function addClassfield(data){
    $(".classfields-cards").append(
        `
        <div class="col-lg-3 col-md-4 col-sm-6 cardcol">
                <div class="card classfield-card-preview">
                    <div style="background: url('/assets/images/classfields/${data.photo_hash}'); background-size: cover; background-position: center;" class="classfieldimage">
                        <div class="cost-badge">${data.cost}</div>
                    </div>
                    <div class="card-body">
                        <a href="${data.link}" class="card-title">${data.title}</a>
                        <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> ${data.location}</small></p>
                    </div>
                </div>
            </div>
        `
    )

}
$(function () {
    getData();
});
