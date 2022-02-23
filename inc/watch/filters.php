<form id="searchform">
    <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} ms-1 me-1 mt-3 mb-3">
        <div class="col-12 align-self-end">
            <span class="watch-title">FILTRY</span>
        </div>
        <div class="col-12 col-md-4 mb-3 align-self-end">
            <label>Tytuł</label>
            <input class="form-control " type="text" name="q" placeholder="Szukaj..." aria-label=".form-control-lg example">
        </div>
        <div class="col-12 col-md-5 mb-3 align-self-end">
            <label>Lokalizacja</label>
            <div class="input-group flex-nowrap">
                <button type="button" class="btn btn-dark btn-search-clear"><i class="fa-solid fa-xmark"></i></button>
                <select class="form-control citypicker" id="citypicker" name="osm_id" placeholder="Szukaj...">
                    <option value="" disabled selected>Cały kraj</option>
                </select>
                <select class="form-control radiuspicker" id="radius" name="radius" style="width:0px;">
                    <option value="0" selected>+0 km</option>
                    <option value="5">+5 km</option>
                    <option value="10">+10 km</option>
                    <option value="15">+15 km</option>
                    <option value="20">+20 km</option>
                    <option value="30">+30 km</option>
                    <option value="50">+50 km</option>
                    <option value="100">+100 km</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-2 mb-3 align-self-end">
            <label>Kategoria</label>
            <select class="category-select form-control" name="category-select" id="category-select">
            </select>
        </div>
        <div class="col-12 col-md-1 mb-3 align-self-end">
            <button type="submit" class="btn btn-primary w-100"><i class=" fa-solid fa-magnifying-glass"></i> Szukaj</button>
        </div>

    </div>

</form>