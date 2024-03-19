<!DOCTYPE HTML>
<html lang="en">
    <?php include 'header.php'; ?> 

    <body>
        <div class="container">
            <div class="d-flex flex-column gap-5">

                <?php include 'navigation.php'; ?> 
    
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="block-post d-flex flex-column gap-1">
                            <?php
                                //register
                                if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
                                    
                                    if ( isset($_POST['submit-registration']) ) {

                                        $is_sent = false;

                                        $username = trim($_POST['username']);
                                        $email = trim($_POST['email']);
                                        $password = trim($_POST['password']);
    
                                        $error = [
                                            'username' => '',
                                            'email' => '',
                                            'password' => ''
                                        ];
    
                                        if ( strlen( $username ) < 4 ) {
                                            $error['username'] = 'Username needs to longer than 4';
                                        }
    
                                        if ( username_exists($username) ) {
                                            $error['username'] =  'username_exists';
                                        }
    
                                        if ( empty($username) ) {
                                            $error['username'] =  'empty username';
                                        }
    
                                        if ( email_exists($email) ) {
                                            $error['email'] =  'email_exists';
                                        }
    
                                        if ( empty($email) ) {
                                            $error['email'] =  'empty email';
                                        }
    
                                        if ( empty($password) ) {
                                            $error['password'] =  'empty password';
                                        }
    
                                        if ( strlen( $password ) < 8 ) {
                                            $error['password'] =  'password needs to longer than 8';
                                        }

                                        foreach ( $error as $key => $value ) {
                                            if ( empty($value) ) {
                                                unset($error[$key]);
                                            }
                                        }

                                        if ( empty( $error ) ) {
                                            $username = mysqli_real_escape_string($connection, $username);
                                            $email = mysqli_real_escape_string($connection, $email);
                                            $password = mysqli_real_escape_string($connection, $password);
        
                                            //get number from DB - users as user_randSalt
                                            // $query_randsalt = "SELECT user_randSalt FROM users";
                                            // $select_randsalt_query = mysqli_query( $connection, $query_randsalt);
        
                                            // confirm( 'randsalr ' , $select_randsalt_query );
                                            // $row_randsalt = mysqli_fetch_array($select_randsalt_query);
                                            // $user_randSalt = $row_randsalt['user_randSalt'];
        
                                            //add password with crypt from user_randSalt
                                            // $password = crypt($password, $user_randSalt);
                                            $password = password_hash($password, PASSWORD_BCRYPT, array( 'cost' => 10 ));
        
                                            //add new register to db
                                            $query_registration_db = "INSERT INTO users (user_username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
                                            $query_registration_db .= "VALUES ('{$username}', '{$password}','','', '{$email}', '', 'subscriber' )";
                                        
                                            $select_user_query = mysqli_query($connection, $query_registration_db);
                                        
                                            confirm( 'registration ' , $select_user_query );
    

                                            $is_sent = true;
                                        }
                                    }
                                }
                            ?>

                            <h1><?php echo _REGISTER; ?></h1>
                            <form action="" method="post" role="form" autocomplete="off" class="d-flex flex-column gap-3">
                                <div class="form-group">
                                    <label for="username"><?php echo _USERNAME; ?></label>
                                    <input type="text" name="username" class="form-control" value="<?php echo isset($username) ? $username : '' ?>" placeholder="<?php echo _PLACEHOLDER_USERNAME; ?>">
                                    <span style="color: red;"><?php echo isset($error['username']) ? $error['username'] : ''; ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="email"><?php echo _EMAIL; ?></label>
                                    <input type="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : '' ?>" placeholder="<?php echo _PLACEHOLDER_EMAIL; ?>">
                                    <span style="color: red;"><?php echo isset($error['email']) ? $error['email'] : ''; ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="password"><?php echo _PASSWORD; ?></label>
                                    <input type="password" name="password" class="form-control" role="presentation" autoComplete="off" placeholder="<?php echo _PLACEHOLDER_PASSWORD; ?>">
                                    <span style="color: red;"><?php echo isset($error['password']) ? $error['password'] : ''; ?></span>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="confirm-password"> confirm-password</label>
                                    <input type="password" name="confirm-password" class="form-control">
                                </div> -->

                                <input type="submit" name="submit-registration" class="btn btn-primary btn-block btn-lg" style="width:100%;" value="Register">
                                <span style="color: green;"><?php echo $is_sent ? 'your registration is done' : ''; ?></span>

                            </form>
                        

                        </div>
                    </div>
                </div>
    
            </div>

            
        </div>


    
    </body>
</html>
