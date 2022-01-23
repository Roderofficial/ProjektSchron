<div class="profile-overlay">
    <div class="background-image w-100" style="background-image: url('/assets/images/backgrounds/<?= $data['banner_hash'] ?>');">
        <?php

        if (isset($_SESSION['userdata']['userid']) && $_SESSION['userdata']['userid'] == $_GET['id']) {
            echo '<button type="button" class="btn btn-primary banner-update-btn" id="bannerupdate"><i class="fas fa-upload"></i></button>';
        }

        ?>

        <!-- AVATAR -->
        <div class="avatar" style="background-image: url('<?= $avatar_locations . $data['avatar_hash'] ?>');">
            <?php
            if (isset($_SESSION['userdata']['userid']) && $_SESSION['userdata']['userid'] == $_GET['id']) {
                echo '<div class="avatar-update" id="avatar-update"><button type="button" class="btn btn-primary avatar-update-btn" id="avatarupdate"><i class="fas fa-upload"></i></button></div>';
            }
            ?>

            <?= ($data['provider'] == "facebook") ? '<i class="fab fa-facebook provider_facebook position-absolute top-100 start-50 translate-middle"></i>': null; ?>
        </div>



    </div>
    <div class="usertitle">
        <span class="username"><?= $data['verified_badge'] ?> <?= $data['username'] ?></span>
        <span class="userrole"><?= $data['role_icon'] ?> <?= $data['role_name'] ?></span>
    </div>

</div>