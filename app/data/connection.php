<?php
require 'rb.php';
require 'config.php';

// The following parameters are defined at /app/data/config.php
R::setup('mysql:host='.dbHost.';dbname='.dbname,dbUser,dbPassword);
?>
