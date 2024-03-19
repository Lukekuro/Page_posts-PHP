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

                                if ( isset($_POST['submit'])) {
                                    $to = "lukekuro4@gmail.com";
                                    $email = "FROM: " . $_POST['email'];
                                    $subject = wordwrap($_POST['subject'], 20);
                                    $message = wordwrap($_POST['message'], 70);

                                    if ( !empty($subject) && !empty($email) ) {

                                        $email = mysqli_real_escape_string($connection, $email);
    
                                        mail($to,$subject, $message, $email );
                                        echo 'sent';
                                    } else {
                                        echo ' error';
                                    }
                                }
                            ?>

                            <h1>Contact</h1>
                            <form action="" method="post" role="form" class="d-flex flex-column gap-3">
                                
                                <div class="form-group">
                                    <label for="email"> email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject"> Subject</label>
                                    <input type="text" name="subject" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="message"> message</label>
                                    <textarea name="message" class="form-control"></textarea>
                                </div>

                                <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg" style="width:100%;" value="Register">
                            </form>
                        

                        </div>
                    </div>
                </div>
    
            </div>

            
        </div>


    
    </body>
</html>
