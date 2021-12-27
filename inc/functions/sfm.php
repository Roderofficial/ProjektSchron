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


?>