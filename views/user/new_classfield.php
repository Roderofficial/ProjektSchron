<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/new_classfield/controler.php');

?>

<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Dodaj ogłoszenie - GetPet.pl</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <link rel="stylesheet" href="/assets/css/new_classfield.css">
    <link href="https://releases.transloadit.com/uppy/v2.3.2/uppy.min.css" rel="stylesheet">

</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>

    <div class="new-classfield-box">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" id="labelnewclassfieldtitle">Nowe ogłoszenie</h5>
                <form method="POST" id="classfield">

                    <!-- OBRAZY -->
                    <div class="obrazy mb-3">
                        <h6 class="card-subtitle mb-2 text-muted ">Zdjęcia</h6>
                        <div id="drag-drop-area"></div>
                        <div class="hidden-images" style="display:none"></div>
                        <small class="text-muted">Pierwsze zdjęcie będzie zdjęciem głównym.</small>

                    </div>
                    <div class="simpleinfo mb-3">
                        <h6 class="card-subtitle mb-2 text-muted ">Informacje podstawowe</h6>

                        <!-- DETAIL EDITOR -->
                        <div class="mb-3">
                            <label>Tytuł ogłoszenia</label>
                            <input class="form-control form-control-lg" type="text" placeholder="tytuł ogłoszenia" name="title" aria-label=".form-control-lg example" min="1" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label>Treść ogłoszenia</label>
                            <div id="editor">
                                <textarea id="desceditor" minlength="100" maxlength="6000"></textarea>
                                <textarea name="description" id="description" style="display:none;"></textarea>



                            </div>


                        </div>

                        <!-- KATEGORIA I CENA -->
                        <div class="catcost mb-3">
                            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                                <div class="col-lg-6 col-12">
                                    <label>Kategoria</label>
                                    <select class="category-select form-control" name="category" id="new-classfield-category-picker" style="width:100%;" required>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Cena</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="cost" placeholder="0 zł" aria-describedby="basic-addon2" min="0" step="1" required>
                                        <span class="input-group-text" id="basic-addon2">zł</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- DANE KONTAKTOWE -->
                        <div class="contact mb-3">
                            <h6 class="card-subtitle mb-2 text-muted ">Dane kontaktowe</h6>
                            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                                <div class="col-lg-6 col-12">
                                    <label>Adres e-mail</label>
                                    <input type="email" class="form-control" name="email" placeholder="name@example.com" value="<?= $placeholder["email_public"] ?>" required>

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Telefon</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+48 123 456 789" pattern="(?<!\w)(\(?(\+|00)?48\)?)?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}(?!\w)" value="<?= $placeholder["phone_public"] ?>" required>

                                </div>
                            </div>

                        </div>


                        <!-- LOKALIZACJA -->
                        <div class="mb-3 lokalizacja">
                            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} location">
                                <div class="col-lg-6 col-12">
                                    <label>Lokalizacja</label>
                                    <select class="form-control citypicker" id="citypicker" name="osm_id" placeholder="Szukaj..." style="width:100%;">
                                        <option value="" disabled selected>Szukaj...</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- PRZESYŁANIE FORMULARZA -->
                    <div class="submit">
                        <div style="text-align:center;">
                            <div class="g-recaptcha mb-3" style="display:inline-block" data-sitekey="6Ldl6d8dAAAAANuCA-InONqkE0EIWnuoMRDyIqGb"></div>
                        </div>
                        <button class="btn btn-primary" type="submit" id="formclassfieldsubmit">Dodaj ogłoszenie</button>

                    </div>


            </div>

            </form>
        </div>
        <?php
        //ADS 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
        ?>
    </div>



    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>

    <script src="https://releases.transloadit.com/uppy/v2.3.2/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/locales/v2.0.5/pl_PL.min.js"></script>
    <script src="/assets/libs/tinymce/tinymce.min.js"></script>
    <script src="/assets/js/new_classfield.js"></script>
</body>

</html>