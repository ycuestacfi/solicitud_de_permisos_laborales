<?php 
$email = 'Prueba123*';
$email_hashed = hash("sha512", $email);

    echo "Los valores son iguales en tipo y valor. $email_hashed";

?>