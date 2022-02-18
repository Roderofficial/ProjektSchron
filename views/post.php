<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/post/controler.php');
?>
<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/libs/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/libs/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="/assets/css/post.css">
    <meta property="og:image" content="https://getpet.pl/assets/images/classfields/<?= $images[0]["photo_hash"] ?>" />
    <meta property="og:title" content="<?= htmlspecialchars($data['title']) ?>" />


    <title><?= $data['title'] ?> - getpet.pl</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <script type="text/javascript">
        var geo_lat = <?php echo json_encode($data['geo_lat']); ?>;
        var geo_long = <?php echo json_encode($data['geo_long']); ?>;
        var post_id = <?php echo json_encode($id); ?>;
    </script>
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/post/main_post.php');
    

    ?>






    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    <!-- SLIDER -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.9.0/build/ol.js"></script>
    <script src="/assets/libs/owlcarousel/owl.carousel.min.js"></script>    

    <script src="/assets/libs/fslightbox.js"></script>
    <script src="/assets/libs/autolink.js"></script>
    <script src="/assets/js/post.js"></script>


</body>

</html>