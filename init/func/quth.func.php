<?php
function usernameExists($username){
    global $db;
    $query = $db ->prepare('SELECT * FROM tbl_users WHERE username_user = ?');
$query -> bind_param('s', $username);
$query-> execute();
$result = $query -> get_result();
if ($result-> num_rows){
    return true;
}
return false;
}
function registerUser($name, $username, $passwd){
    global $db;
    $query = $db ->prepare('INSERT INTO tbl_users (name_user,username_user,password_user) VALUES (?,?,?)');
    $query -> bind_param('sss',$name,$username,$passwd);
    $query-> execute();
    if($db->affected_rows){
        return true;
    }
    return false;
}
?>