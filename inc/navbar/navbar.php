<!-- NAVBAR -->
<?php
@session_start();

?>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="/assets/images/logo_endd.svg" alt="Logo GetPet" width="25px"> GetPet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <div class="d-field">
                <?php
                @session_start();
                if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {
                    require_once('member_options.php');
                } else {
                    require_once('guest_options.php');
                }

                ?>

            </div>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->