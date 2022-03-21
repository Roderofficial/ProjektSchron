<?php
require($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');
$id_koty = 2;
$id_psy = 1;

$koty = $database->count('classfield', [
    "enabled" => 1,
    "classfield_categoryid" => $id_koty

]);

$psy = $database->count('classfield', [
    "enabled" => 1,
    "classfield_categoryid" => $id_psy

]);

$zdjecia = $database->count('classfield_photo');

?>


<div class="container">
    <div class="sectiontitle">
        <h2>Statystyki</h2>
        <span class="headerLine"></span>
    </div>
    <div id="projectFacts" class="sectionClass">
        <div class="fullWidth eight columns">
            <div class="projectFactsWrap ">
                <div class="item wow fadeInUpBig animated animated" style="visibility: visible;">
                    <i class="fa-solid fa-dog"></i>
                    <p id="number1" class="number"><?= $psy ?></p>
                    <span></span>
                    <p>Psy</p>
                </div>
                <div class="item wow fadeInUpBig animated animated" style="visibility: visible;">
                    <i class="fa-solid fa-cat"></i>
                    <p id="number2" class="number"><?= $koty ?></p>
                    <span></span>
                    <p>Koty</p>
                </div>
                <div class="item wow fadeInUpBig animated animated" style="visibility: visible;">
                    <i class="fa-regular fa-clipboard"></i>
                    <p id="number3" class="number"><?= $psy + $koty ?></p>
                    <span></span>
                    <p>Ogłoszenia</p>
                </div>
                <div class="item wow fadeInUpBig animated animated" style="visibility: visible;">
                    <i class="fa fa-camera"></i>
                    <p id="number4" class="number"><?= $zdjecia ?></p>
                    <span></span>
                    <p>Zdjęcia</p>
                </div>
            </div>
        </div>
    </div>
</div>