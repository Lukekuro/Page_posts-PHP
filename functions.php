<?php 

function redirect( $location ) {
    return header( "Location:" . $location );
    exit;
}


function query($query){
    global $connection;
    return mysqli_query($connection, $query);
}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}

function escape($string) {
    global $connection;

    return mysqli_real_escape_string($connection, trim($string));
}

function confirm( $name, $result ) {
    global $connection;

    if ( !$result ) {
        // error_reporting(E_ALL);
        die( 'Query failed ' . $name . ' -> ' . mysqli_error($connection));

    }

    return $result;
}

function IfItIsMethod( $method = null ) {
    if ( $_SERVER['REQUEST_METHOD'] == strtoupper( $method ) ) {
        return true;
    }

    return false;
}

function isLoggedIn() {
    if ( isset($_SESSION['user_role'] ) ) {
        return true;
    }

    return false;
}

function loggedInUserId(){
    if(isLoggedIn()){
        // $result = select_from_where('users', 'user_username', $_SESSION['user_username'], true);
        // return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;

        $result = query("SELECT * FROM users WHERE user_username='" . $_SESSION['user_username'] ."'");
        confirm('loggedInUserId' ,$result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;

}

function userLikedThisPost($post_id){
    // $result = select_from_where_and( 'likes', 'user_id', loggedInUserId(), 'post_id', $post_id );
    // return mysqli_num_rows($result) >= 1 ? true : false;

    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    confirm('err', $result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

// function getPostLikes($post_id) {
//     return select_from_where_count('likes', 'post_id', $post_id );
// }

function checkIfUserIsLoggedAndRedirect( $redirectLocation = null ) {

    if ( isLoggedIn() ) {
        redirect( $redirectLocation );
    }
}



function users_online() {

    if (isset($_GET['onlineusers']) ) {
        global $connection;
    
        if ( !$connection ) {
            session_start();
            include("db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 30;
            $time_out = $time - $time_out_in_seconds;
        
            $query_users_online_db = "SELECT * FROM users_online WHERE user_online_session = '$session'";
            $select_query_users_online_db = mysqli_query($connection, $query_users_online_db);
            confirm( "user online" , $select_query_users_online_db );
            $count_users_online_db = mysqli_num_rows($select_query_users_online_db);
            
            if ( $count_users_online_db == NULL ) {
                mysqli_query($connection, "INSERT INTO users_online (user_online_session, user_online_time) VALUES ('$session', $time)");
            } else {
                mysqli_query($connection, "UPDATE users_online SET user_online_time = $time WHERE user_online_session = '$session'");
            }
        
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE user_online_time > $time_out");
            echo $count_users = mysqli_num_rows($users_online_query);
        }
    }
}

users_online();

function select_from( $table ) {
    global $connection;

    $the_query = "SELECT * FROM " . $table;
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "select_from -> $table. ", $select_all );
}

function select_from_count( $table ) {
    global $connection;

    $the_query = "SELECT * FROM " . $table;
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "select_from_count -> $table. ", $select_all );
    
    return mysqli_num_rows($select_all);
}

function select_from_where( $table, $column, $status, $fetch = null ) {
    global $connection;

    if ( is_numeric($status) ) {
        $status_text = $status;
    } else {
        $status_text = "'$status'";
    }

    $the_query = "SELECT * FROM $table WHERE $column = $status_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "select_from_where -> $table where $column =  $status. ", $select_all );

    if ( $fetch == true ) {
        return mysqli_fetch_array($select_all);
    }
}

function select_from_where_count( $table, $column, $status ) {
    global $connection;

    if ( is_numeric($status) ) {
        $status_text = $status;
    } else {
        $status_text = "'$status'";
    }

    $the_query = "SELECT * FROM $table WHERE $column = $status_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "select_from_where_count -> $table where $column =  $status. ", $select_all );

    return mysqli_num_rows($select_all);
}

function select_from_where_and( $table, $column, $status, $and_column, $and_status, $fetch = null ) {
    global $connection;

    if ( is_numeric($status) ) {
        $status_text = $status;
    } else {
        $status_text = "'$status'";
    }

    if ( is_numeric($and_status) ) {
        $and_status_text = $and_status;
    } else {
        $and_status_text = "'$and_status'";
    }

    $the_query = "SELECT * FROM $table WHERE $column = $status_text AND $and_column = $and_status_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "select_from_where_and -> $table WHERE $column =  $status AND $and_column = $and_status_text. ", $select_all );

    if ( $fetch == true ) {
        return mysqli_fetch_array($select_all);
    }
}

function select_from_where_and_count( $table, $column, $status, $and_column, $and_status ) {
    global $connection;

    if ( is_numeric($status) ) {
        $status_text = $status;
    } else {
        $status_text = "'$status'";
    }

    if ( is_numeric($and_status) ) {
        $and_status_text = $and_status;
    } else {
        $and_status_text = "'$and_status'";
    }

    $the_query = "SELECT * FROM $table WHERE $column = $status_text AND $and_column = $and_status_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "select_from_where_and_count -> $table WHERE $column =  $status AND $and_column = $and_status_text. ", $select_all );

    return mysqli_num_rows($select_all);
}

function udpdate_set_where( $table, $column_set, $status_set, $column_where, $status_where ) {
    global $connection;

    if ( is_numeric($status_set) ) {
        $status_set_text = $status_set;
    } else {
        $status_set_text = "'$status_set'";
    }

    if ( is_numeric($status_where) ) {
        $status_where_text = $status_where;
    } else {
        $status_where_text = "'$status_where'";
    }

    $the_query = "UPDATE $table SET $column_set = $status_set_text WHERE $column_where = $status_where_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "udpdate_set_where -> $table SET $column_set = $status_set where $column_where =  $status_where. ", $select_all );
}

function delete_from_where( $table, $column, $status ) {
    global $connection;

    if ( is_numeric($status) ) {
        $status_text = $status;
    } else {
        $status_text = "'$status'";
    }

    $the_query = "DELETE FROM $table WHERE $column = $status_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "delete_from_where -> $table where $column =  $status. ", $select_all );
}

function delete_from_where_and( $table, $column, $status, $and_column, $and_status ) {
    global $connection;

    if ( is_numeric($status) ) {
        $status_text = $status;
    } else {
        $status_text = "'$status'";
    }

    if ( is_numeric($and_status) ) {
        $and_status_text = $and_status;
    } else {
        $and_status_text = "'$and_status'";
    }

    $the_query = "DELETE FROM $table WHERE $column = $status_text AND $and_column = $and_status_text";
    $select_all = mysqli_query( $connection, $the_query );
    
    confirm( "delete_from_where_and -> $table where $column =  $status and $and_column = $and_status_text. ", $select_all );
}

function is_admin() {
    global $connection;

    if ( isLoggedIn() ) {

        $the_query = "SELECT user_role FROM users WHERE user_id = ".$_SESSION['user_id']."";
        $result = mysqli_query( $connection, $the_query );

        confirm( "is_admin -> " . $_SESSION['user_id'], $result );

        $row = fetchRecords( $result );

        if ( $row['user_role'] == 'admin' ) {
            return true;
        } else {
            return false;
        }
    }

}

function username_exists( $username ) {
    global $connection;

    $the_query = "SELECT user_username FROM users WHERE user_username = '$username'";
    $result = mysqli_query( $connection, $the_query );

    confirm( "username_exists -> $username ", $result );

    if ( mysqli_num_rows( $result ) > 0 ) {
        return true;
    } else {
        return false;
    }
 
}

function email_exists( $email ) {
    global $connection;

    $the_query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query( $connection, $the_query );

    confirm( "email_exists -> $email ", $result );

    if ( mysqli_num_rows( $result ) > 0 ) {
        return true;
    } else {
        return false;
    }
 
}

function loginIn( $username, $password ) {
    global $connection;

    if ( $username && $password ) {

        $user_username = escape($username);
        $user_password = escape($password);
    
        $user_username = mysqli_real_escape_string($connection, $user_username);
        $user_password = mysqli_real_escape_string($connection, $user_password);
    
        $query_login_db = "SELECT * FROM users WHERE user_username = '{$user_username}' ";
    
        $select_user_query = mysqli_query($connection, $query_login_db);
    
        confirm( 'login' , $select_user_query );
    
        while ( $row = mysqli_fetch_assoc($select_user_query) ) {
            $db_user_id = $row['user_id'];
            $db_user_username = $row['user_username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_email = $row['user_email'];
            $db_user_image = $row['user_image'];
            $db_user_role = $row['user_role'];

            if ( $user_username == $db_user_username && password_verify( $user_password, $db_user_password )  ) {
            
                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['user_username'] = $db_user_username;
                $_SESSION['user_firstname'] = $db_user_firstname;
                $_SESSION['user_lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;
        
                redirect( "/study_php/admin" );
        
            } else {
                return false;
            }
        }
    
        // $user_password = crypt($user_password, $db_user_password); // old
    
        
       
    }

    return true;
}



?>