<?php
    define('DB_DSN','mysql:host=localhost;dbname=fire_emblem;charset=utf8');
    define('DB_USER','username');
    define('DB_PASS','password');     

    $db = new PDO(DB_DSN, DB_USER, DB_PASS); 
?>