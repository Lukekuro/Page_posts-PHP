<?php 
     //update user - show form with input and submit
    if ( isset($_GET['p_id']) ) {
        $the_user_id = escape($_GET['p_id']);

        $update_db_user = "SELECT * FROM users WHERE user_id = $the_user_id";
        $update_user = mysqli_query($connection, $update_db_user);

        confirm( 'edit' , $update_user );

        while ( $update_user_row = mysqli_fetch_assoc($update_user) ) {
            $up_user_username = $update_user_row['user_username'];
            // $up_user_password = $update_user_row['user_password'];
            $up_user_firstname = $update_user_row['user_firstname'];
            $up_user_lastname = $update_user_row['user_lastname'];
            $up_user_email = $update_user_row['user_email'];
            $up_user_image = $update_user_row['user_image'];
            $up_user_image_temp = $update_user_row['user_image']['tmp_name']; //location


            ?>
                <h2>Edit user</h2>

                <form action="" method="post" enctype="multipart/form-data">
                        
                    <div class="form-group">
                        <label for="user_username">username</label>
                        <input value="<?php echo isset($up_user_username) ? $up_user_username : ''; ?>" type="text" name="user_username" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_password">password</label>
                        <input type="password" name="user_password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_firstname">firstname</label>
                        <input value="<?php echo isset($up_user_firstname) ? $up_user_firstname : ''; ?>" type="text" name="user_firstname" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">lastname</label>
                        <input value="<?php echo isset($up_user_lastname) ? $up_user_lastname : ''; ?>" type="text" name="user_lastname" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_image" class="d-block">image</label>
                        <img src="../img/<?php echo isset($up_user_image) ? $up_user_image : ''; ?>" alt="" class="img-thumbnail" style="max-width: 200px;">

                        <input type="file" name="user_image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_email">email</label>
                        <input value="<?php echo isset($up_user_email) ? $up_user_email : ''; ?>" type="email" name="user_email" class="form-control" >
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit-edit" class="btn btn-primary" value="edit user">
                    </div>


                </form>

            <?php
        }


        //update user - submit
        if ( isset($_POST['submit-edit']) ) {
            $up_sub_user_username = $_POST['user_username'];
            $up_sub_user_password = $_POST['user_password'];
            $up_sub_user_firstname = $_POST['user_firstname'];
            $up_sub_user_lastname = $_POST['user_lastname'];
            $up_sub_user_image = $_FILES['user_image'];
            $up_sub_user_image_temp = $_FILES['user_image']['tmp_name']; //location
            $up_sub_user_email = $_POST['user_email'];

            if ( empty($up_sub_user_image) ) {
                $update_image = "SELECT * FROM users WHERE user_id = {$the_user_id}";
                $select_image = mysqli_query($connection, $update_image);

                while ($row_image = mysqli_fetch_array($select_image)) {
                    $up_sub_user_image = $row_image['user_image'];
                }
            }

            if ( !empty($up_sub_user_password) ) {
                $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
                $select_query_password = mysqli_query($connection, $query_password);
                confirm( 'password' , $select_query_password );

                $row_password = mysqli_fetch_array($select_query_password);

                $db_user_password = $row_password['user_password'];
            }

            if ( $db_user_password != $up_sub_user_password ) {
                $hash_sub_user_password = password_hash($up_sub_user_password, PASSWORD_BCRYPT, array( 'cost' => 10 ));
            }

            if ( $up_sub_user_username == "" || empty($up_sub_user_username)  || empty($up_sub_user_password) || password_verify( $up_sub_user_password, $db_user_password ) ) {
                echo 'this field should not be empty';

            } else {

               
                move_uploaded_file( $up_sub_user_image_temp, "../img/$up_sub_user_image" );


                $update_sub_db_user = "UPDATE users SET ";
                $update_sub_db_user .= "user_username = '{$up_sub_user_username}', ";
                $update_sub_db_user .= "user_password = '{$hash_sub_user_password}', ";
                $update_sub_db_user .= "user_firstname = '{$up_sub_user_firstname}', ";
                $update_sub_db_user .= "user_lastname = '{$up_sub_user_lastname}', ";
                $update_sub_db_user .= "user_email = '{$up_sub_user_email}', ";
                $update_sub_db_user .= "user_image = '{$up_sub_user_image}' WHERE user_id = {$the_user_id}";
                $update_user = mysqli_query($connection, $update_sub_db_user);
                
                confirm( 'update' , $update_user );

                session_start();
                if ( $_SESSION['user_id'] == $the_user_id ) {
                    $_SESSION['user_username'] = $up_sub_user_username;
                }

                header("Location: users.php");

            }
        }

        
    }

?>
