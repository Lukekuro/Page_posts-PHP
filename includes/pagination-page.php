<?php 
$page_num_max = 3;
if ( isset($_GET['page']) ) {
    $page_num = $_GET['page'];

} else {
    $page_num = 1;
}

if ( $page_num == "" ||  $page_num == 1) {
    $page_1 = 0;
} else {
    $page_1 = ($page_num * $page_num_max) - $page_num_max;
}
?>
