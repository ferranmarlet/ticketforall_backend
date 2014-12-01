<?php
require '../app/data/rb.php';
require '../app/data/config.php';

// The following parameters are defined at /app/data/config.php
R::setup('mysql:host='.dbHost.';dbname='.dbname,dbUser,dbPassword);
?>
