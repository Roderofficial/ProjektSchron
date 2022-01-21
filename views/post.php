<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/post/controler.php');
?>
<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/post.css">


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
    <script src="/assets/js/post.js"></script>


</body>

</html>