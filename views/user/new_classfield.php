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
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>

    <div class="new-classfield-box">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nowe ogłoszenie</h5>
                <form method="POST" id="classfield">

                    <div class="obrazy mb-3">
                        <h6 class="card-subtitle mb-2 text-muted ">Zdjęcia</h6>
                        <div id="drag-drop-area"></div>
                        <div class="hidden-images" style="display:none"></div>
                        <small class="text-muted">Pierwsze wybrane zdjęcie będzie robiło za okładkę.</small>

                    </div>
                    <div class="simpleinfo mb-3">
                        <h6 class="card-subtitle mb-2 text-muted ">Informacje podstawowe</h6>

                        <!-- DETAIL EDITOR -->
                        <div class="mb-3">
                            <label>Tytuł ogłoszenia</label>
                            <input class="form-control form-control-lg" type="text" placeholder="tytuł ogłoszenia" name="title" aria-label=".form-control-lg example" required>
                        </div>
                        <div class="mb-3">
                            <label>Treść ogłoszenia</label>
                            <div id="editor">
                            </div>
                            <textarea name="description" style="display:none" id="hiddenArea"></textarea>

                        </div>

                        <div class="catcost mb-3">
                            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                                <div class="col-lg-6 col-12">
                                    <label>Kategoria</label>
                                    <select class="category-select form-control" name="category" style="width:100%;">
                                        <option value="-1" selected disabled>Wybierz kategorię</option>
                                        <option value="1">Psy</option>
                                        <option value="2">Koty</option>
                                        <option value="3">Konie</option>
                                        <option value="4">Akcesoria</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Cena</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="cost" placeholder="0 zł" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">zł</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mb-3 lokalizacja">
                            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} location">
                                <div class="col-lg-6 col-12">
                                    <label>Lokalizacja</label>
                                    <select class="form-control citypicker" id="citypicker" name="osm_id" placeholder="Szukaj..." style="width:100%;">
                                        <option value="" disabled selected>Szukaj...</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Mapa podglądowa</label>
                                    <div class="map-box" id="map-box"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="submit">
                        <div style="text-align:center;">
                            <div class="g-recaptcha mb-3" style="display:inline-block" data-sitekey="6Ldl6d8dAAAAANuCA-InONqkE0EIWnuoMRDyIqGb"></div>
                        </div>
                        <button class="btn btn-primary" type="submit">Button</button>

                    </div>


            </div>

            </form>
        </div>
    </div>
    </div>



    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>

    <script src="https://releases.transloadit.com/uppy/v2.3.2/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/locales/v2.0.5/pl_PL.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="/assets/js/new_classfield.js"></script>
</body>

</html>