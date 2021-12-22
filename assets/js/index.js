function getData(){
    $.get("/inc/requests/classfield-main-page.php", function (data) {
        var decoded_data = JSON.parse(data);
        for (element of decoded_data){
            addClassfield(element);
        }
    });

}
function addClassfield(data){
    $(".classfields-cards").append(
        `
        <div class="col-lg-3 col-md-6 col-sm-6 cardcol">
                <div class="card classfield-card-preview">
                    <div style="background: url('/assets/images/test-dogs/${data.photo_hash}'); background-size: cover; background-position: center;" class="classfieldimage"></div>
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
