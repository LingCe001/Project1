<?php
    if(isset($_SESSION['user_id'])){
        echo $_SESSION['user_id'];
    }

    //echo 'LEVEL: ' . (isAdmin() ? 'admin' : 'user');
     if(isAdmin()){
        echo 'LEVEL_USER: ADMIN';
    }else {
        echo 'LEVEL_USER: USER';
    }
?>

<h1>Dashboard</h1>