<?php
@session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/profile/controler.php');
?>
<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title><?= $data['username'] ?></title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <link rel="stylesheet" href="/assets/css/profile.css">
    <script type="text/javascript">
        var userid = <?php echo json_encode($data['userid']); ?>;
        var location_public = <?= isset($data['location_public']) ? json_encode($data['location_public']) : json_encode(null) ?>;
    </script>
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>

    <div class="profile container">
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/profile/profile_overlay.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/profile/classfields.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/profile/more_details.php');

        //ADS 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');

        ?>
    </div>





    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    <script src="/assets/js/profile.js"></script>
</body>

</html>