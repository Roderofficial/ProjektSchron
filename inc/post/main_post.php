<div class="post row">
    <!-- LEFT SIDE -->
    <div class="left-side col-lg-4 order-1 order-lg-0">
        <!-- LOCATION CARD -->
        <div class="card location w-100">
            <div class="card-body">
                <p class="custom-card-text" style="font-size: 20px;">LOKALIZACJA</p>
                <div class="w-100 map-box placeholder" id="map-box"></div>
            </div>
        </div>

        <!-- AUTHOR INFO -->
        <div class="card author w-100">
            <div class="card-body">
                <p class="custom-card-text" style="font-size: 20px;">AUTOR OGŁOSZENIA</p>
                <img class="member-avatar-box placeholder" src=" <?= $data['userdata']['avatar_hash'] ?>" alt="">
                <p class="member-username w-75 placeholder placeholder-lg"><?= $verified_badge ?> <?= $data['userdata']['username'] ?></p>
                <a href="/profile/<?= $data['userdata']['userid'] ?>" tabindex="-1" class="btn btn-primary placeholder w-75 profile-btn" aria-hidden="true" style="margin:auto; margin-top:20px; display:block;"><i class="fas fa-user"></i> Wyświetl profil użytkownika</a>
            </div>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="right-side col-lg-8 order-0 order-lg-1">
        <div class="card post-header">
            <div class="card-body w-100">
                <!-- IMAGES -->
                <div class="images w-100 placeholder">
                    <!-- Content here -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <?= $data['images'] ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>


                    <!-- END IMAGES CONTENT HERE -->
                </div>

                <!-- END IMAGES -->
                <h1 class="placeholder w-100 title"><?= $data['title'] ?></h1>
                <div class="cost"><?= $data['cost'] ?></div>
                <div class="row">
                    <p><small class="text-muted col-5 placeholder location"><i class="fas fa-map-marker-alt"></i> <?= $data['location'] ?> - <?= $data['created_at'] ?></small>
                        <small class="text-muted col-2 placeholder createdate float-end text-end"><?= $data["category_icon"] ?> <?= $data["category_title"] ?></small>
                    </p>
                </div>

            </div>
        </div>

        <!-- DETAILS -->
        <div class="card post-details">
            <div class="card-body w-100">
                <!-- END IMAGES -->
                <h2 class="w-100 desc-title custom-card-text">CHARAKTERYSTYKA</h2>
                <div class="row">
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Szczepiony</span></div>
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Odrobaczony</span></div>
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Sprząta</span></div>
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Gotuje</span></div>
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Sam się wyprowadza</span></div>
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Lubi kwiaty</span></div>
                    <div class="col-lg-4 detail"><i class="fas fa-check-circle"></i> <span>Świeżak</span></div>

                </div>
            </div>
        </div>

        <!-- DATA AND I PARAMETRY -->
        <div class="card post-details">
            <div class="card-body w-100">
                <!-- END IMAGES -->
                <h2 class="w-100 desc-title custom-card-text">OPIS</h2>
                <p class="description w-100 placeholder"><?= $data["description"] ?></p>

            </div>
        </div>
    </div>
</div>