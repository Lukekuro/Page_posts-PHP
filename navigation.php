<?php 
    include 'db.php'; 
    include 'functions.php'; 
    ob_start(); // is need if here is e.g. header("Location: categories.php");
    session_start();

    if ( isset($_GET['lang']) && !empty($_GET['lang']) ) {
        $_SESSION['lang'] = $_GET['lang'];

        // if ( isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang'] ) { //idk if need?
        //     echo "<script type='text/javascript'>location.reload();</script>";
        // }

        if ( isset($_SESSION['lang']) ) {
            include "includes/languages/" . $_SESSION['lang'] . ".php";
        } else {
            include "includes/languages/en.php";
        }

    } else {
        include "includes/languages/en.php";
    }

?> 
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    
    <?php 
        echo "<a class='navbar-brand' href='/study_php'>Home</a>";
        
        //categories
        $db_categories = "SELECT * FROM categories";
        $select_all_cat = mysqli_query($connection, $db_categories);

        if ( !$select_all_cat ) {
            die( 'Query failed' . mysqli_error());
        }
    ?>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <?php
            

            while ( $cat_row = mysqli_fetch_assoc($select_all_cat) ) {
                $cat_id = $cat_row['cat_id'];
                $cat_title = $cat_row['cat_title'];

                $class_active = '';

                $registration_class = '';

                $registration = 'registration';

                $login_class = '';

                $login = 'login';

                $contact_class = '';

                $contact = 'contact';

                $pagename = basename($_SERVER['PHP_SELF']);

                if ( isset($_GET['c_id']) && $_GET['c_id'] == $cat_id ) {
                    $class_active = 'active';

                } else if ( $pagename == $registration ) {
                    $registration_class = 'active';
                }  else if ( $pagename == $contact ) {
                    $contact_class = 'active';
                }  else if ( $pagename == $login ) {
                    $login_class = 'active';
                }


                echo "<li class='nav-item $class_active'><a class='nav-link' href='/study_php/category/{$cat_id}'>{$cat_title}</a></li>";
            }



            if ( isLoggedIn() ) {
    
                echo "<li class='nav-item'><a class='nav-link' href='/study_php/admin'>Admin</a></li>";
        
                if (isset($_GET['p_id'])) {
                    $the_post_id = escape($_GET['p_id']);
                    echo "<li class='nav-item'><a class='nav-link' href='/study_php/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Post edit</a></li>";
                }

                echo "<li class='nav-item'><a class='nav-link' href='/study_php/includes/logout.php'>logout</a></li>";
    
            } else {
                echo "<li class='nav-item $registration'><a class='nav-link' href='/study_php/registration'>registration</a></li>";

                echo "<li class='nav-item $login'><a class='nav-link' href='/study_php/login'>login</a></li>";
            }
    
    
            echo "<li class='nav-item $contact_class'><a class='nav-link' href='/study_php/contact'>contact</a></li>";




            ?>
        </ul>
        <form method="get" class="navbar-form navbar-right" action="" id="language_form">
            <div class="form-group">
                <!-- need replace from onchange to another (maybe only id)? -->
                <select name="lang" class="form-control" onchange="changeLanguage()"> 
                    <option value="en" <?php if ( isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') { echo 'selected'; } ?>>English</option>
                    <option value="pl" <?php if ( isset($_SESSION['lang']) && $_SESSION['lang'] == 'pl') { echo 'selected'; } ?>>Polish</option>
                </select>
            </div>
        </form>
    </div>
    
</nav>

<script>

    function changeLanguage() {

        document.getElementById('language_form').submit();
    }

</script>
            
    