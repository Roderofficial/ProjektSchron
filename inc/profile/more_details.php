<hr />
<?php
//Check if display card
if (!empty($data['about']) || !empty($data['email_public']) || !empty($data['phone_punblic']) || !empty($data['website_public'])) {
    $about = null;
    $contact_details = null;

    if (!empty($data['email_public']) || !empty($data['phone_punblic']) || !empty($data['website_public'])) {
        $phone_public = null;
        $email_public = null;
        $website_public = null;
        if (!empty($data['phone_public'])) {
            $phone_public = '<div class="col-sm-12 col-lg-4 mb-3 align-self-center"><a class="btn btn-primary align-middle" href="tel:' . $data['phone_public'] . '" role="button"><i class="fas fa-phone me-2"></i>' . $data['phone_public'] . '</a></div>';
        }
        if (!empty($data['email_public'])) {
            $email_public = '<div class="col-sm-12 col-lg-4 mb-3 align-self-center"><a class="btn btn-primary align-middle" href="mailto:' . $data['email_public'] . '" role="button"><i class="fas fa-envelope-open-text me-2"></i> ' . $data['email_public'] . '</a></div>';
        }
        if (!empty($data['location_public'])) {
            $website_public = '<div class="col-sm-12 col-lg-4 mb-3 align-self-center"><div class="location align-middle"><i class="fas fa-map-marker-alt me-2"></i> <div class="location_content" style="display:contents;">Ładowanie...</div></div></div>';
        }
        $contact_details = '<div class="border-top">
            <p class="card-title-custom mt-3">KONTAKT</p>
            <div class="row ${1| ,row-cols-2,row-cols-3, auto,justify-content-md-center,|}">
                ' . $phone_public . $email_public . $website_public . '

            </div>
    </div>';


    if(!empty($data['about'])){
        $about = '<p class="card-title-custom">O NAS</p><p> ' . $data['about'] . '</p>';
    }
    echo '<div class="card">
    <div class="card-body">
        '.$about.$contact_details.'
    </div>
</div>';
}


}

?>




<span class="badge bg-primary me-2">Dała założenia konta: <?= $data['date_created'] ?></span><span class="badge bg-dark">Numer identyfikacyjny: <?= $data['userid'] ?></span></small>