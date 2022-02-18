<div class="post row">
    <?php
    //ADS 
    require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
    ?>

    <?php
    //Enabled card
    if ($data["enabled"] == 0) {
        echo '
            <div class="card bg-warning mb-3 col-12">
                <div class="card-body">
                    <h4 class="card-title" style="margin-bottom:0px;"><i class="fas fa-ban"></i> Przeglądasz archiwalne ogłoszenie!</h4>
                </div>
            </div>
            ';
    }
    ?>


    <!-- LEFT SIDE -->
    <div class="left-side col-lg-4 order-1 order-lg-0">
        <!-- LOCATION CARD -->
        <div class="card location w-100">
            <div class="card-body">
                <p class="custom-card-text" style="font-size: 20px;">LOKALIZACJA</p>
                <div class="w-100 map-box placeholder" id="map-box"></div>
            </div>
        </div>

        <!-- CONTACT -->
        <div class="card w-100" id="contactcard">
            <div class="card-body">
                <p class="custom-card-text" style="font-size: 20px;">DANE KONTAKTOWE</p>
                <div class="contactdetail">
                    <button type="button" class="btn btn-outline-primary w-100 btn-lg" id="getcontactbtn" style="font-weight: 500;" <?= $data["enabled"] == 0 ? "Disabled" : null ?>><i class="far fa-address-book"></i> Pokaż dane kontaktowe</button>
                </div>
            </div>
        </div>


        <!-- AUTHOR INFO -->
        <div class="card author w-100">
            <div class="card-body">
                <p class="custom-card-text" style="font-size: 20px;">AUTOR OGŁOSZENIA</p>
                <img class="member-avatar-box placeholder" src=" <?= $avatar_locations . $data['userdata']['avatar_hash'] ?>" alt="">
                <p class="member-username w-75 placeholder placeholder-lg"><?= $verified_badge ?> <?= $data['userdata']['username'] ?></p>
                <a href="/profile/<?= $data['userdata']['userid'] ?>" tabindex="-1" class="btn btn-outline-primary placeholder w-75 profile-btn" aria-hidden="true" style="margin:auto; margin-top:20px; display:block;"><i class="fas fa-user"></i> Wyświetl profil użytkownika</a>
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



        <!-- DATA AND I PARAMETRY -->
        <div class="card post-details">
            <div class="card-body w-100">
                <!-- END IMAGES -->
                <h2 class="w-100 desc-title custom-card-text">OPIS</h2>
                <p class="description w-100 placeholder"><?= nl2br($data["description"]) ?></p>

            </div>
        </div>


    </div>

    <div class="col-12  order-3">
        <div class=" justify-content-end d-flex">
            <span class="badge bg-dark">Identyfikator ogłoszenia: <?= htmlspecialchars($id) ?></span>
        </div>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/post/near_more_classfields.php');
    //ADS 
    require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
    ?>
</div>