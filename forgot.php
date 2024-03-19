<!DOCTYPE HTML>
<html lang="en">
    <?php include 'header.php'; ?> 

    <body>
        <div class="container">
            <div class="d-flex flex-column gap-5">

                <?php include 'navigation.php'; ?> 

                <?php

                    if ( !IfItIsMethod( 'get' ) || !isset($_GET['forgot']) ) {
                        redirect( "/study_php" );
                    }

                    if ( IfItIsMethod( 'post' ) ) {
                        if ( isset( $_POST['email'] ) ) {

                            $email = escape($_POST['email']);

                            $length = 50;

                            $token = bin2hex(openssl_random_pseudo_bytes($length));


                            if ( email_exists( $email ) ) {

                                $stmt = mysqli_prepare($connection, "UPDATE users SET token = '{$token}' WHERE user_email = ?");
                                if ( $stmt ) {
                                    mysqli_stmt_bind_param($stmt, "s", $email);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_close($stmt);
                                } else {
                                    "wrong";
                                }
                            }

                        }
                    }
                    
                ?>
    
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="block-post d-flex flex-column gap-1">

                            <div class="block-sidebar__login well">
                                <h3>Forgot pass?</h3>

                                <form action="" method="post">
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control" placeholder="enter email">
                                    </div>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" name="forgot" type="submit">send email</button>
                                    </span>

                                    <input type="hidden" name="token">
                                </form>
                            </div>
                        

                        </div>
                    </div>
                </div>
    
            </div>

            
        </div>


    
    </body>
</html>
