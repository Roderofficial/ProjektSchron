<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filtruj wyniki</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            <div class="mb-3">
                <label class="form-label">Kategoria</label>
                <div class="input-group mb-3" style="max-width:100%;">
                    <select class="category-select form-control" name="category-select[]" multiple="multiple">
                        <option value="1">Psy</option>
                        <option value="2">Koty</option>
                        <option value="3">Konie</option>
                        <option value="4">Akcesoria</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="button" id="search-city-btn">Wyczyść</button>
                </div>
                <label class="form-label">Miejscowość</label>
                <div class="input-group mb-3" style="max-width:100%;">
                    <select class="form-control citypicker" id="citypicker" name="osm_id" placeholder="Szukaj...">
                        <option value="" disabled selected>Szukaj...</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="button" id="search-city-btn">Wyczyść</button>
                </div>
                <label class="form-label">Promień</label>
                <div class="radius-picker-div" style="max-width:100%; margin-bottom:20px;">
                    <select class="form-control" id="radius" name="radius">
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

                <div class="map-box" id="map-box" style="margin-bottom:20px;"></div>

                <label class="form-label">Cena</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Od</span>
                    <input type="text" class="form-control" aria-label="0zł">
                    <span class="input-group-text">Do</span>
                    <input type="text" class="form-control" aria-label="10 000 zł">

                </div>
                <button class="btn btn-primary btn-sm" role="button">Za darmo</button>
                <br />
            </div>
        </div>
        <hr>
        <button class="btn btn-success w-100" href="#" role="button">Szukaj</button>
    </div>
</div>