<div class="dropdown" style="display: inline;">
    <button class="btn btn-secondary dropdown-toggle topbtn" style="margin-right:10px;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user"></i> Mój profil
    </button>
    <div class="dropdown-menu" style="margin-top: 18px; white-space: nowrap;">
        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
            <div class="col align-items-center justify-content-center">
                <?php
                echo '<img class="nav-avatar" src="' . $_SESSION['userdata']['avatar'] . '">';
                ?>
            </div>
            <div class="col align-items-center justify-content-center" style="text-align:center;">
                <?php
                echo $_SESSION['userdata']['username'];
                ?>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/profile/<?= $_SESSION['userdata']['userid']?>">Mój profil</a>
        <a class="dropdown-item" href="#">Moje ogłoszenia</a>
        <a class="dropdown-item" href="#">Ustawienia</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/inc/login/logout.php"><i class="fas fa-sign-out-alt"></i> Wyloguj</a>
    </div>
</div>


<button type="button" class="btn btn-primary topbtn"><i class="fas fa-plus"></i> Dodaj ogłoszenie</button>