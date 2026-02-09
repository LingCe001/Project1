<?php
    if(isset($_SESSION['user_id'])){
        echo $_SESSION['user_id'];
    }

    //echo 'LEVEL: ' . (isAdmin() ? 'admin' : 'user');
     if(isAdmin()){
        echo 'LEVEL: ADMIN';
    }else {
        echo 'LEVEL: USER';
    }
?>

<h1>Dashboard</h1>