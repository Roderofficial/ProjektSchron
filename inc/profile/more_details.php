<hr />
<?php
if (!empty($data['about'])) {
    echo '<div class="card">
    <div class="card-body">
        <p class="card-title-custom">O NAS</p>
        <p> ' . $data['about'] . '</p>
    </div>
</div>';
}



if (!empty($data['email_public']) || !empty($data['phone_punblic']) || !empty($data['website_public'])) {
    $phone_public = null;
    $email_public = null;
    $website_public = null;
    if (!empty($data['phone_public'])) {
        $phone_public = '<p class="contact-detail"><i class="fas fa-phone"></i>' . $data['phone_public'] . '</p>';
    }
    if (!empty($data['email_public'])) {
        $email_public = '<p class="contact-detail"><i class="fas fa-envelope-open-text"></i> ' . $data['email_public'] . '</p>';
    }
    if (!empty($data['website_public'])) {
        $website_public = '<p class="contact-detail"><i class="far fa-newspaper"></i> <a href="' . $data['website_public'] . '">' . $data['website_public'] . '</a> </p>';
    }
    echo '<div class="card">
    <div class="card-body">
        <p class="card-title-custom">KONTAKT</p>
        <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
            <div class="col">' . $phone_public . $email_public . $website_public . '</div>
            <div class="col">
                b5-col
            </div>

        </div>
    </div>
</div>';
}

?>




<span class="badge bg-primary me-2">Dała założenia konta: <?= $data['date_created'] ?></span><span class="badge bg-dark">Numer identyfikacyjny: <?= $data['userid'] ?></span></small>