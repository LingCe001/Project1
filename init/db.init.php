<?php
    $db_host = 'localhost';
    $db_name = 'webapp_ai001';
    $db_user = 's';
    $db_pass = '';
    $db_port = 3306;
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
    if ($db->connect_error) {

        echo $db->connect_error;
        die();

    }
?>