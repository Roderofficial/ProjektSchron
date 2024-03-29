<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php') ?>
<div class="dropdown" style="display: inline;">
    <button class="btn btn-dark dropdown-toggle" style="margin-right:10px;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user"></i> Mój profil
    </button>
    <div class="dropdown-menu" style="margin-top: 18px; white-space: nowrap; z-index: 9999;">
        <div class="align-items-center justify-content-center">
            <?php
            echo '<img class="nav-avatar" src="' . $avatar_locations . $_SESSION['userdata']['avatar'] . '">';
            ?>
        </div>
        <div class="align-items-center justify-content-center" style="text-align:center;">
            <?php
            echo $_SESSION['userdata']['username'];
            ?>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/profile/<?= $_SESSION['userdata']['userid'] ?>"><i class="fa-solid fa-user me-1"></i> Mój profil</a>
        <a class="dropdown-item" href="/u/moje-ogloszenia"><i class="fa-solid fa-table-list me-1"></i> Moje ogłoszenia</a>
        <a class="dropdown-item" href="/u/ustawienia"><i class="fa-solid fa-gear"></i> Ustawienia</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/inc/requests/auth/logout.php"><i class="fas fa-sign-out-alt"></i> Wyloguj</a>
    </div>
</div>


<a href="/u/dodaj" type="button" class="btn btn-primary topbtn"><i class="fas fa-plus"></i> Dodaj ogłoszenie</a>