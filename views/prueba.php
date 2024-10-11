<?php 
$email = 'ycuesta@providenciacfi.com';
$email_hashed = hash("sha512", $email);

if ($email_hashed) {
    echo $email_hashed;
} else {
    echo "Los valores son iguales en tipo y valor.";
}
?>