<?php

function usernameExists($username)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username_user = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}

function registerUser($name, $username, $passwd)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_users (name_user,username_user,password_user) VALUES (?,?,?)');
    $query->bind_param('sss', $name, $username, $passwd);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;
}

function logUserIn($username, $passwd)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username_user = ? AND password_user = ?');
    $query->bind_param('ss', $username, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return false;
}

function loggedInUser()
{
    global $db;
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id_user = ?');
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return null;
}
function isAdmin(){
    $user_id = loggedInUser();
    
    // Add debugging to see what's happening
    // error_log("User object: " . print_r($user_id, true));
    
    if($user_id && isset($user_id->level) && strtolower($user_id->level) === 'admin'){
        return true;
    }    
    return false;
}
function isUserHasPassword($passwd)
{
global $db;
$user = loggedInUser();
$query = $db -> prepare(
"SELECT * FROM tbl_users WHERE id = ? AND passwd = ?"
);
$query->bind_param('ss', $user->id_user, $passwd) ;
$query->execute();
$result = $query->get_result();
if ($result->num_rows) {
return true;
}
return false;
}
function setUserNewPassowrd($passwd)
{
global $db;
$user = loggedInUser();
$query = $db->prepare(
"UPDATE tbl_users SET passwd = ? WHERE id = ?"
);
$query->bind_param('ss', $passwd, $user->id_user);
$query->execute();
if ($db->affected_rows) {
return true;
}
return false;
}