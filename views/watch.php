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
        <?php
        //ADS 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
        ?>

        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/watch/filters.php');
        ?>
        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} ms-1 me-1">
            <div class="col-12 col-md-8 align-self-end mb-3">
                <span class="watch-title">Przeglądaj ogłoszenia</span>
            </div>
        </div>
        <?php

        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/watch/classfields.php');

        //ADS 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
        ?>

    </div>




    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    <script src="/assets/libs/city-picker.js"></script>
    <script src="/assets/js/watch.js"></script>
</body>

</html>