<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/password_recovery/controler.php');
?>

<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Resetuj hasło - GetPet.pl</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>


    <div class="card" style="max-width: 800px; margin:auto; margin-top:20px;">
        <div class="card-body">
            <h5 class="card-title">Resetowanie hasła</h5>
            <h6 class="card-subtitle mb-2 text-muted">Konto: <?= $token_data[0]["username"] ?></h6>
            <form id="pwdreset">
                <input type="hidden" name="token" value="<?= $_GET["token"] ?>">
                <input type="hidden" name="email" value="<?= $_GET["email"] ?>">
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Nowe hasło</label>
                    <input type="password" name="password1" class="form-control" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Powtórz nowe hasło</label>
                    <input type="password" name="password2" class="form-control" minlength="8" required>
                </div>
                <div>
                    <div class="g-recaptcha mb-3" style="display:inline-block" data-sitekey="6Ldl6d8dAAAAANuCA-InONqkE0EIWnuoMRDyIqGb"></div>
                </div>
                <button type="submit" class="btn btn-primary">Zmień hasło</button>
            </form>
        </div>
    </div>



    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    <script src="/assets/js/password_recovery.js"></script>
</body>

</html>