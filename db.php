<?php 
ob_start();

$db['db_host'] =  'localhost';
$db['db_user'] =  'root';
$db['db_pass'] =  'root';
$db['db_name'] =  'example';

foreach ( $db as $key => $val ) {
    define( strtoupper($key), $val);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ( !$connection ) {
    die('No connected ' . mysqli_error($connection));
}
?>

