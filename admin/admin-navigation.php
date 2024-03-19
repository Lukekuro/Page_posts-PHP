<?php
    include '../db.php'; 
    include '../functions.php'; 
    ob_start(); // is need if here is e.g. header("Location: categories.php");
    session_start();

    if ( !isset($_SESSION['user_role']) ) {
        header("Location: ../index.php");
    } 
?> 

<div class="navigation d-flex gap-3 navbar-collapse p-3" style="background-color: #CCC;">


    <?php 
        echo '<span>CMS ADMIN</span>';
        echo '<a href="../index.php">Home</a>';
        echo "<span>{$_SESSION['user_username']}</span>";

        echo '<ul class="list-group">';

            echo "<li class='list-group-item'><a href='#'>profil</a></li>";
            echo "<li class='list-group-item'><a href='../includes/logout.php'>log out</a></li>";

        echo '</ul>';

        echo "<span>Users online: <span class='usersonline'>0</span></span>";

        ?>

</div>
            
    