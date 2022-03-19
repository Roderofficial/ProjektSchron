<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login();
?>
<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Moje ogłoszenia - GetPet.pl</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/head.php'); ?>
    <link rel="stylesheet" href="/assets/css/user_classfields.css">
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/navbar/navbar.php');

    ?>


    <div class="container mt-3">

        <?php
        //ADS 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
        ?>
        <!-- top nav -->
        <div class="top-nav">
            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} mb-3">
                <div class="col-md-6 ">
                    <!-- BTN GROUP -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i class="fas fa-clipboard-list"></i> Aktualne</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="fas fa-clipboard-check"></i> Zakończone</button>
                        </li>
                    </ul>

                    <!-- END BTN GROUP -->
                </div>
            </div>
        </div>

        <!-- SEARCH FILTERS -->
        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|} justify-content-between">
            <!-- SEARCHBOX -->

            <div class="col-12 col-md-4  mb-3">
                <label>Wyszukiwarka</label>
                <div class="input-group mb-1">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control uc-searchbox" placeholder="Tytuł lub Numer ogłoszenia" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>


            <!-- SORTING -->
            <div class="col-12 col-md-auto  mb-3">
                <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                    <div class="col-10  ">
                        <label>Sortuj według</label>
                        <select class="form-select sort-box">
                            <option value="0" selected>Data wygaśnięcia: malejąco</option>
                            <option value="1">Data wygaśnięcia: rosnąco</option>
                            <option value="2">Data dodania: malejąco</option>
                            <option value="3">Data dodania: rosnąco</option>
                        </select>
                    </div>
                    <div class="col-2  align-self-end">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a role="button" class="dropdown-item refresh-all" href="#"><i class="fa-solid fa-arrows-rotate me-3"></i>Odśwież wszystkie ogłoszenia</a></li>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <!-- TABS CONTENT -->
        <div class="tab-content" id="pills-tabContent">
            <!-- AKTUALNE -->
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <table id="active-table" data-pagination="true" data-page-size="8" data-show-custom-view="true" data-custom-view="customViewFormatter" data-query-params="userclassfieldquery">
                    <thead>
                        <tr>
                            <th data-field="id">id</th>
                            <th data-field="title">title</th>
                            <th data-field="location">location</th>
                            <th data-field="cost">cost</th>
                            <th data-field="photo_hash">photo_hash</th>
                            <th data-field="link">link</th>
                            <th data-field="created_at">created_at</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Zakończone-->
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <table id="disactive-table" data-pagination="true" data-page-size="8" data-show-custom-view="true" data-custom-view="endedcustomViewFormatter" data-query-params="userclassfieldquery">
                    <thead>
                        <tr>
                            <th data-field="id">id</th>
                            <th data-field="title">title</th>
                            <th data-field="location">location</th>
                            <th data-field="cost">cost</th>
                            <th data-field="photo_hash">photo_hash</th>
                            <th data-field="link">link</th>
                            <th data-field="created_at">created_at</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>


        <?php
        //ADS 
        require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/ads/szeroka_reklama.php');
        ?>


    </div>

    <!-- ACTIVE CARD TEMPLATE -->
    <template id="card-template">
        <div class="card mb-3 classfield-user">
            <div class="row g-0" style="min-height: 200px;">
                <div class="col-md-2">
                    <div class="img-card" style="background-image: url('/assets/images/classfields/%photo_hash%');"></div>
                </div>
                <div class="col-md-10">
                    <div class="card-body">
                        <a class="card-title" href="%link%">%title%</a>
                        <p class="card-text"><small>Data dodania: %create_time% <br /> Data wygaśnięcia: <b><span style="color:red;">%expire_time%</span></b> </small></p>
                        <div class="bottom-control">
                            <div class="d-grid gap-2 d-md-block">
                                <button type="button" class="btn btn-primary action-refresh" data-cid="%cid%"><i class="fas fa-redo"></i> Odśwież</button>
                                <!-- DROPDOWN -->
                                <div class="dropdown d-md-inline-block">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-wrench"></i> Zarządzaj
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <li><button class="dropdown-item action-edit" type="button" data-cid="%cid%"><i class="fas fa-pen"></i> Edytuj</button></li>
                                        <li><button class="dropdown-item action-archive" type="button" data-cid="%cid%"><i class="fas fa-clipboard-check"></i> Zakończ</button></li>
                                        <li><button class="dropdown-item action-remove" type="button" data-cid="%cid%"><i class="fas fa-trash-alt"></i> Usuń</button></li>
                                    </ul>
                                </div>


                                <!-- END DROPDOWN -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </template>
    <!-- END CARD TEMPLATE -->

    <!-- ENDED CARD TEMPLATE -->
    <template id="card-template-ended">
        <div class="card mb-3 classfield-user">
            <div class="row g-0" style="min-height: 200px;">
                <div class="col-md-2">
                    <div class="img-card" style="background-image: url('/assets/images/classfields/%photo_hash%');"></div>
                </div>
                <div class="col-md-10">
                    <div class="card-body">
                        <a class="card-title" href="%link%">%title%</a>
                        <p class="card-text"><small>Data dodania: %create_time% <br /> Data zakończenia: <b><span style="color:red;">%expire_time%</span></b> </small></p>
                        <div class="bottom-control">
                            <div class="d-grid gap-2 d-md-block">
                                <button type="button" class="btn btn-success action-active" data-cid="%cid%"><i class="fas fa-sync-alt"></i> Aktywuj</button>
                                <!-- DROPDOWN -->
                                <div class="dropdown d-md-inline-block">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-wrench"></i> Zarządzaj
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <li><button class="dropdown-item action-edit" type="button" data-cid="%cid%"><i class="fas fa-pen"></i> Edytuj</button></li>
                                        <li><button class="dropdown-item action-remove" type="button" data-cid="%cid%"><i class="fas fa-trash-alt"></i> Usuń</button></li>
                                    </ul>
                                </div>


                                <!-- END DROPDOWN -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </template>
    <!-- END CARD TEMPLATE -->



    <?php require($_SERVER['DOCUMENT_ROOT'] . '/inc/includes/scripts.php') ?>

    <script src="/assets/js/user_classfields.js"></script>
</body>

</html>