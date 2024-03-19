<?php 
    if ( isset($_POST['submit-user']) ) {
        $user_id = $_POST['user_id'];
        $user_username = $_POST['user_username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name']; //location
        $user_role = $_POST['user_role'];

        move_uploaded_file( $user_image_temp, "../img/$user_image" );

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array( 'cost' => 10 ));

        $add_db_user = "INSERT INTO users( user_username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
        $add_db_user .= "VALUES('{$user_username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}') ";

        $create_user = mysqli_query($connection, $add_db_user);

        confirm( 'create user' , $create_user );
        
        echo "<div class='d-flex gap-1'>User crrated: <a href='users.php'> View user</a></div>";

    }


?>
<h2>Add user</h2>


<form action="" method="post" enctype="multipart/form-data">
        
    <div class="form-group">
        <label for="user_username">username</label>
        <input type="text" name="user_username" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_password">password</label>
        <input type="text" name="user_password" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_firstname">firstname</label>
        <input type="text" name="user_firstname" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_lastname">lastname</label>
        <input type="text" name="user_lastname" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_email"> email</label>
        <input type="text" name="user_email" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_image">image</label>
        <input type="file" name="user_image" class="form-control">
    </div>

    <div class="form-group">
        <label for="user_role"> role</label>
        <input type="text" name="user_role" class="form-control">
    </div>


    <div class="form-group">
        <input type="submit" name="submit-user" class="btn btn-primary" value="add user">
    </div>


</form>