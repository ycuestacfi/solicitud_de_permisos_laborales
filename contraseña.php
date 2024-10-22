<?php
$password = 'OtraContraseña123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>