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

                                checkIfUserIsLoggedAndRedirect('/study_php/admin');

                                if ( IfItIsMethod( 'post' ) ) {
                                    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
                                        loginIn( $_POST['username'], $_POST['password'] );
                                    } else {
                                        redirect( "/study_php/login" );
                                    }
                                }
                                
                            ?>

                            <div class="block-sidebar__login well">
                                <h3>Login</h3>

                                <form action="" method="post">
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control" placeholder="enter username">
                                    </div>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" placeholder="enter password">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" name="login" type="submit">Login</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        

                        </div>
                    </div>
                </div>
    
            </div>

            
        </div>


    
    </body>
</html>
