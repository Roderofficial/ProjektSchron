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


?>