<?php
function clean($string)
{


    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

    $string = preg_replace('/-+/', '-', $string);

    return $string;  // Removes special chars.
}

function cost_formatter($cost)
{
    if ($cost == 0) {
        return '<i class="fas fa-donate"></i> Darmowe';
    }
    return number_format($cost, 0, ',', ' ').' zł';
}

function verified_badge(){
    return '<i class="fas fa-check-circle verified-badge" data-toggle="tooltip" title="" data-bs-original-title="Użytkownik został zweryfikowany pod kątem prawidłowości danych." aria-label="Użytkownik został zweryfikowany pod kątem prawidłowości danych."></i>';
}
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


?>