<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Aktualne ogłoszenia - GetPet.pl</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <link rel="stylesheet" href="/assets/css/watch.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>

    <div class="watch">
        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} ms-1 me-1">
            <div class="col-12 col-md-8 align-self-end mb-3">
                <span class="watch-title">Przeglądaj ogłoszenia</span>
            </div>
            <div class="col-12 col-md-4  mb-3 mt-3 d-flex justify-content-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-controls="offcanvasExample">
                    <i class="fas fa-filter"></i> Filtry wyszukiwania
                </button>
            </div>
        </div>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/watch/classfields.php')
        ?>

    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/watch/filter-offcanvas.php');
    ?>





    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    <script src="/assets/libs/city-picker.js"></script>
    <script src="/assets/js/watch.js"></script>
</body>

</html>