<?php 
include '../db.php'; 
include '../functions.php'; 
session_start();

if ( isset($_POST['login']) ) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query_login_db = "SELECT * FROM users WHERE user_username = '{$username}' ";

    $select_user_query = mysqli_query($connection, $query_login_db);

    confirm( 'login' , $select_user_query );

    while ($row = mysqli_fetch_assoc($select_user_query) ) {
        $db_user_id = $row['user_id'];
        $db_user_username = $row['user_username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_email = $row['user_email'];
        $db_user_image = $row['user_image'];
        $db_user_role = $row['user_role'];
    }

    // $password = crypt($password, $db_user_password); // old

    
    if ( $username == $db_user_username && password_verify( $password, $db_user_password )  ) {
        
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['user_username'] = $db_user_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header('Location: /study_php/admin');

    } else {
        header('Location: /study_php');
    }
}

?> 
