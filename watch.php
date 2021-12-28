<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>zoomory</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <link rel="stylesheet" href="/assets/css/watch.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>

    <div class="watch">
        <h1>PRZEGLĄDAJ OGŁOSZENIA</h1>
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'].'/inc/watch/classfields.php')
        ?>

    </div>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/watch/filter-offcanvas.php');
    ?>





    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    
    <script src="/assets/js/watch.js"></script>
</body>

</html>