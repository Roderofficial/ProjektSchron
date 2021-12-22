<?php
$hash = password_hash('Radekp123!!!', PASSWORD_ARGON2ID);
var_dump($hash);
echo '<br />' . password_verify('Radekp123!!!', $hash);
?>