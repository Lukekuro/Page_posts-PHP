<!DOCTYPE HTML>
<html lang="en">
    <?php include 'admin-header.php'; ?> 

    <body>
        <div class="d-flex flex-column gap-5">

            <?php include 'admin-navigation.php'; ?> 

            <div class="row">
                <div class="col-lg-2">
                    <?php include 'block-sidebar-admin.php'; ?> 
                </div>

                <div class="col-lg-10">
                    <div class="block-post d-flex flex-column gap-5 p-3" style="border: 1px solid #CCC; border-radius: 5px;">
                        <h2>profile</h2>
                        <?php 
                        

                            if ( $_SESSION['user_username'] ) {
                                $user_username = $_SESSION['user_username'];

                                $query_user = "SELECT * FROM users WHERE user_username = '{$user_username}' ";

                                $select_user_profile_query = mysqli_query($connection, $query_user);

                                confirm( 'profile ' , $select_user_profile_query );

                                while ( $row = mysqli_fetch_array($select_user_profile_query) ) {
                                    $user_id = $row['user_id'];
                                    $db_user_username = $row['user_username'];
                                    $db_user_password = $row['user_password'];
                                    $db_user_firstname = $row['user_firstname'];
                                    $db_user_lastname = $row['user_lastname'];
                                    $db_user_email = $row['user_email'];
                                    $db_user_image = $row['user_image'];
                                    $db_user_role = $row['user_role'];
                                }
                            }
                        ?>

                        <form action="" method="post" >
                        
                            <div class="form-group">
                                <label for="user_username">username</label>
                                <input value="<?php echo isset($db_user_username) ? $db_user_username : ''; ?>" type="text" name="user_username" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="user_password">password</label>
                                <input value="<?php echo isset($db_user_password) ? $db_user_password : ''; ?>" type="password" name="user_password" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="user_firstname">firstname</label>
                                <input value="<?php echo isset($db_user_firstname) ? $db_user_firstname : ''; ?>" type="text" name="user_firstname" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="user_lastname">lastname</label>
                                <input value="<?php echo isset($db_user_lastname) ? $db_user_lastname : ''; ?>" type="text" name="user_lastname" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="user_image" class="d-block">image</label>
                                <img src="../img/<?php echo isset($db_user_image) ? $db_user_image : ''; ?>" alt="" class="img-thumbnail" style="max-width: 200px;">
        
                                <input type="file" name="user_image" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="user_email">email</label>
                                <input value="<?php echo isset($db_user_email) ? $db_user_email : ''; ?>" type="email" name="user_email" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label for="user_role"> role</label>
                                <input value="<?php echo isset($db_user_role) ? $db_user_role : ''; ?>" type="text" name="user_role" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit-edit" class="btn btn-primary" value="edit profil">
                            </div>
        
        
                        </form>

                        <?php 
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
                                $update_image = "SELECT * FROM users WHERE user_id = {$user_id}";
                                $select_image = mysqli_query($connection, $update_image);

                                while ($row_image = mysqli_fetch_array($select_image)) {
                                    $up_sub_user_image = $row_image['user_image'];
                                }
                            }

                            if ( $up_sub_user_username == "" || empty($up_sub_user_username) ) {
                                echo 'this field should not be empty';

                            } else {

                                move_uploaded_file( $up_sub_user_image_temp, "../img/$up_sub_user_image" );


                                $update_sub_db_user = "UPDATE users SET ";
                                $update_sub_db_user .= "user_username = '{$up_sub_user_username}', ";
                                $update_sub_db_user .= "user_password = '{$up_sub_user_password}', ";
                                $update_sub_db_user .= "user_firstname = '{$up_sub_user_firstname}', ";
                                $update_sub_db_user .= "user_lastname = '{$up_sub_user_lastname}', ";
                                $update_sub_db_user .= "user_email = '{$up_sub_user_email}', ";
                                $update_sub_db_user .= "user_image = '{$up_sub_user_image}' WHERE user_id = {$user_id}";
                                $update_user = mysqli_query($connection, $update_sub_db_user);
                                
                                confirm( 'update' , $update_user );
                                
                                header("Location: profil.php");
                            }
                        }
                        ?> 


                    </div>
                </div>
                
            </div>

        </div>
            
        <?php include 'admin-footer.php'; ?> 

    </body>

</html>
