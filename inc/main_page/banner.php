<div class="main-banner border-bottom">
    <div class="container">
        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}" style="max-width:100%; padding:20px 0px;">
            <div class="col-lg-7 align-items-center pr-2 pl-2 center-banner">
                <span class="banner-title">Wszystko co związane z zwierzętami znajdziesz tutaj!</span>
                <p>GetPet to miejsce, w którym można znaleźć wszystkie ogłoszenia o zwierzętach, adopcje i nie tylko. Możesz również zamieścić bezpłatne ogłoszenie na naszej stronie.</p>
                <form method="GET" action="/ogloszenia" style="width:100%;">
                    <div class="searchbox">
                        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                            <div class="col-lg-5 mb-3">
                                <select class="category-select form-control" name="category-select" id="category-select">
                                </select>
                            </div>
                            <div class="col-12 col-lg-4  mb-3">
                                <select class="form-control citypicker" id="citypicker" name="osm_id" placeholder="Szukaj..." style="width:100%;">
                                    <option value="" disabled selected>Szukaj...</option>
                                </select>
                            </div>
                            <div class="col-lg-3  mb-3">
                                <button type="submit" class="btn searchbtn w-100"><i class="fas fa-search"></i> Szukaj</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="popularne-kategorie text-left mb-3">
                    <span style="font-weight: 600;">Popularne kategorie: </span>
                    <!-- POPULAR BUTTONS -->
                    <a href="#" role="button" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-dog"></i> Psy</a>
                    <a role="button" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-cat"></i> Koty</a>
                    <a role="button" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-horse"></i> Konie</a>
                    <a role="button" class=" btn btn-outline-primary btn-sm me-2"><i class="fas fa-boxes"></i> Akcesoria</a>
                    <a role="button" class="btn btn-outline-primary btn-sm me-2"><i class="fas fa-hand-holding-heart"></i> Usługi</a>
                </div>

            </div>
            <div class="col-sm-0 col-lg-5 order-1 d-none d-lg-block">
                <img src="/assets/images/undraw_post_online_re_1b82.svg" class="banner-image" style="max-width:60%;">
            </div>
        </div>

    </div>


</div>