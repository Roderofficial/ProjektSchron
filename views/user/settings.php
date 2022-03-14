<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/settings/controler.php');
?>

<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Ustawienia profilu - GetPet.pl</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <link rel="stylesheet" href="/assets/css/settings.css">
    <script type="text/javascript">
        var public_location = <?php echo json_encode($data['location_public']); ?>;
    </script>
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>


    <div class="settings">
        <div class="card settingscard container">
            <div class="card-body">
                <!-- BUTTONS -->
                <div class="settingsbtns">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-displaydata-tab" data-bs-toggle="pill" data-bs-target="#pills-displaydata" type="button" role="tab" aria-controls="pills-displaydata" aria-selected="true"><i class="fas fa-user-cog"></i> Ustawienia ogólne</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-password-tab" data-bs-toggle="pill" data-bs-target="#pills-password" type="button" role="tab" aria-controls="pills-password" aria-selected="false"><i class="fas fa-key"></i> Zmień hasło</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-public-tab" data-bs-toggle="pill" data-bs-target="#pills-public" type="button" role="tab" aria-controls="pills-public" aria-selected="false"><i class="fas fa-address-card"></i> Profil publiczny</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-advanced-tab" data-bs-toggle="pill" data-bs-target="#pills-advanced" type="button" role="tab" aria-controls="pills-advanced" aria-selected="false"><i class="fas fa-tools"></i> Zarządzanie kontem</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-info-tab" data-bs-toggle="pill" data-bs-target="#pills-info" type="button" role="tab" aria-controls="pills-info" aria-selected="false"><i class="fas fa-info-circle"></i> Informacje</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="open-times-tab" data-bs-toggle="pill" data-bs-target="#open-times" type="button" role="tab" aria-controls="open-times" aria-selected="false"><i class="fa-solid fa-clock"></i> Godziny otwarcia</button>
                        </li> -->

                    </ul>
                </div>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <!-- USTAWIENIA OGÓLNE -->
                    <div class="tab-pane fade show active" id="pills-displaydata" role="tabpanel" aria-labelledby="pills-displaydata-tab">
                        <form id="displaydata" style="max-width:400px;" method="POST" action="/inc/requests/profile/update_settings.php">
                            <input type="hidden" name="type" value="displaydata">
                            <div class="mb-3">
                                <label class="form-label">Nazwa użytkownika</label>
                                <input type="text" name="displayname" class="form-control" value="<?= $data["username"] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adres e-mail</label>
                                <input type="email" class="form-control" name="email" value="<?= $data["email"] ?>">
                            </div>
                            <?php
                            if(check_permission($_SESSION["userdata"]["userid"], "subdomain")){
                                echo '
                                <label class="form-label">Subdomena</label>
                                <div class="input-group mb-3">
                                    
                                    <input type="text" min="5" max="25" class="form-control" name="subdomain" value="' . $data["subdomain"] . '">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.getpet.pl</span>
                                    </div>
                                </div>';
                            }
                            ?>
                            <button type="submit" class="btn btn-primary">Zmień dane</button>
                        </form>
                    </div>
                    <!-- ZMIANA HASŁA -->
                    <div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
                        <form id="passwordupdate" style="max-width:400px;" method="POST" action="/inc/requests/profile/update_settings.php">
                            <input type="hidden" name="type" value="password">
                            <div class="mb-3">
                                <label class="form-label">Stare hasło</label>
                                <input type="password" name="oldpassword" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nowe hasło</label>
                                <input type="password" name="newpassword1" class="form-control" minlength="8" maxlength="255" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Powtórz nowe hasło</label>
                                <input type="password" name="newpassword2" class="form-control" minlength="8" maxlength="255" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Zmień hasło</button>
                        </form>
                    </div>
                    <!-- USTAWIENIA PUBLICZNE -->
                    <div class="tab-pane fade" id="pills-public" role="tabpanel" aria-labelledby="pills-public-tab">
                        <form method="POST" id="advanceddata" action="/inc/requests/profile/update_settings.php">
                            <input type="hidden" name="type" value="details">
                            <div class="about mb-3">
                                <h4><b>ZAKŁADKA O NAS</b></h4>
                                <!-- EDITOR -->
                                <textarea name="about" id="desceditor">
                                <?= $data['about'] ?>
                            </textarea>
                            </div>
                            <div class="contactdetails">
                                <h4><b>DANE KONTAKTOWE</b></h4>
                                <!-- START ROW-->
                                <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                                    <div class="col-12 col-md-4 mb-3">
                                        <label>Telefon</label>
                                        <input type="tel" class="form-control" name="phone" value="<?= $data['phone_public'] ?>">
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <label>Adres E-MAIL</label>
                                        <input type="email" class="form-control" name="email" value="<?= $data['email_public'] ?>">

                                    </div>
                                    <div class=" col-12 col-md-4 mb-3">
                                        <label>Lokalizacja</label>
                                        <div class="input-group mb-3" style="max-width:100%;">
                                            <select class="form-control citypicker" id="citypicker" name="location" placeholder="Szukaj...">
                                                <option value="" disabled selected>Szukaj...</option>
                                            </select>
                                            <button class="btn btn-outline-secondary btn-search-clear" type="button" id="search-city-btn">Wyczyść</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- END ROW -->
                                <button type="submit" class="btn btn-primary">Zapisz informacje</button>

                        </form>
                    </div>
                </div>
                <!-- USTAWIENIA ZAAWANSOWANE -->
                <div class="tab-pane fade" id="pills-advanced" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <h2 style="color:var(--bs-danger);"><b>Usuwanie konta</b></h2>
                    <p>W przypadku gdy użytkownik zdecyuje się usunąć konto z serwisu, nie będzie możliwe jego przywrócenie. Dane kasowane są ze strony bezpowrotnie.</p>
                    <hr>
                    <form id="displaydata" style="max-width:400px;">
                        <div class="mb-3">
                            <label class="form-label">Obecne hasło</label>
                            <input type="password" name="password" class="form-control" autocomplete="off" required>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="sure" required>
                            <label class="form-check-label">Jestem pewny/a tego co robię.</label>
                        </div>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-user-slash"></i> Usuń konto</button>
                    </form>
                </div>
                <!-- INFORMACJE O KONCIE -->
                <div class="tab-pane fade" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Numer identyfikacyjny użytkownika</th>
                                <td><?= $data["userid"] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Data założenia konta</th>
                                <td><?= $data["date_created"] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Konto zweryfikowane przez administrację</th>
                                <td><?= ($data["verified"]) ? "Tak" : "Nie" ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Poziom uprawnień</th>
                                <td><?= $data["role_icon"], " ", $data["role_name"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- GODZINY OTWARCIA -->
                <div class="tab-pane fade" id="open-times" role="tabpanel" aria-labelledby="open-times-tab">
                    <form method="POST" id="opentimes" action="/inc/requests/profile/update_settings.php">
                        <input type="hidden" name="type" value="opentimes">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Dzień</th>
                                    <th>Od</th>
                                    <th>Do</th>
                                    <th>Ustawienia</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th scope="row">Poniedziałek</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[0]" id="btnradio1" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio1">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[0]" id="btnradio2" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradio2">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Wtorek</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[1]" id="btnradio3" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio3">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[1]" id="btnradio4" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradio4">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Środa</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[2]" id="btnradio5" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio5">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[2]" id="btnradio6" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradio6">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Czwartek</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[3]" id="btnradio7" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio7">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[3]" id="btnradio8" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradio8">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Piątek</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[4]" id="btnradio9" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio9">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[4]" id="btnradioa" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradioa">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Sobota</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[5]" id="btnradio10" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio10">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[5]" id="btnradio11" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradio11">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Niedziela</th>
                                    <td><input type="time" class="form-control" name="opentime[]"></td>
                                    <td><input type="time" class="form-control" name="closetime[]"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="dayoption[6]" id="btnradio12" autocomplete="off" value="open">
                                            <label class="btn btn-outline-primary" for="btnradio12">Otwarte</label>

                                            <input type="radio" class="btn-check" name="dayoption[6]" id="btnradio13" value="close" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary" for="btnradio13">Zamknięte</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Zapisz informacje</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    </div>



    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>
    <script src="/assets/libs/tinymce/tinymce.min.js"></script>
    <script src="/assets/js/settings.js"></script>
</body>

</html> 6