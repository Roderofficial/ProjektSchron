<div class="profile-overlay">
    <div class="background-image w-100" style="background-image: url('<?= $data['banner_hash'] ?>');">

        <!-- AVATAR -->
        <div class="avatar" style="background-image: url('<?= $data['avatar_hash'] ?>');">
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