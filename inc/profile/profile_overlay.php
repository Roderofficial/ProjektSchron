<div class="profile-overlay">
    <div class="background-image w-100" style="background-image: url('/assets/images/backgrounds/<?= $data['banner_hash'] ?>');">
        <?php 
        
        if(isset($_SESSION['userdata']['userid']) && $_SESSION['userdata']['userid'] == $_GET['id']){
            echo '<button type="button" class="btn btn-primary banner-update-btn" id="bannerupdate"><i class="fas fa-upload"></i></button>';
        }

        ?>

        <!-- AVATAR -->
        <div class="avatar" style="background-image: url('<?= $avatar_locations. $data['avatar_hash'] ?>');">
            <?php
                if (isset($_SESSION['userdata']['userid']) && $_SESSION['userdata']['userid'] == $_GET['id']) {
                    echo '<div class="avatar-update" id="avatar-update"><button type="button" class="btn btn-primary avatar-update-btn" id="avatarupdate"><i class="fas fa-upload"></i></button></div>';
                }
            ?>
            
            <div class="test"><i class="fab fa-facebook" style="color: #0043ff;
    font-size: 34px;
    border-radius: 50%;
    background: #fff;
    position: absolute;
    bottom: -15px;
    left: 50%;
    margin-left: -22px;
    border: 2px solid #fff;"></i></div>
        </div>



    </div>
    <div class="usertitle">
        <span class="username"><?= $data['verified_badge'] ?> <?= $data['username'] ?></span>
        <span class="userrole"><?= $data['role_icon'] ?> <?= $data['role_name'] ?></span>
    </div>

</div>