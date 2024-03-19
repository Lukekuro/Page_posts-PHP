<?php
//VIEW ALL users

//show all users - table
$db_users = "SELECT * FROM users";
$display_users = mysqli_query($connection, $db_users);

if ( !$display_users ) {
    die( 'Query failed display_users' . mysqli_error($connection));
}

//remove user
if ( isset($_GET['delete']) ) {
    $remove_get_user = $_GET['delete'];

    $remove_db_user = "DELETE FROM users WHERE user_id = {$remove_get_user}";
    $remove_user = mysqli_query($connection, $remove_db_user);
    
    confirm( 'delete' , $remove_user );
    redirect("users.php");
}

//change to admin 
if ( isset($_GET['change_to_admin']) ) {
    $the_user_id = $_GET['change_to_admin'];

    $change_to_admin_db = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id}";
    $change_to_admin = mysqli_query($connection, $change_to_admin_db);
    
    confirm( 'change_to_admin' , $change_to_admin );
    redirect("users.php");
}

//change to subscriber 
if ( isset($_GET['change_to_sub']) ) {
    $the_user_id = $_GET['change_to_sub'];

    $change_to_sub_db = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id}";
    $change_to_sub = mysqli_query($connection, $change_to_sub_db);
    
    confirm( 'change_to_sub' , $change_to_sub );
    redirect("users.php");
}

?>
<h2>View all users</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>username</th>
                <th>password</th>
                <th>firstname</th>
                <th>lastname</th>
                <th>Email</th>
                <th>image</th>
                <th>role</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                while ( $row = mysqli_fetch_assoc($display_users) ) {
                    echo '<tr>';
                        $user_id = $row['user_id'];
                        $user_username = $row['user_username'];
                        $user_password = $row['user_password'];
                        $user_firstname = $row['user_firstname'];
                        $user_lastname = $row['user_lastname'];
                        $user_email = $row['user_email'];
                        $user_image = $row['user_image'];
                        $user_role = $row['user_role'];


                        echo "<td>{$user_id}</td>";
                        echo "<td>{$user_username}</td>";
                        echo "<td>{$user_password}</td>";
                        echo "<td>{$user_firstname}</td>";
                        echo "<td>{$user_lastname}</td>";
                        echo "<td>{$user_email}</td>";
                        echo "<td><img src='../img/{$user_image}' class='img-thumbnail'></td>";
                        echo "<td>{$user_role}</td>";

                        //frist option
                        // if ( isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {

                        //second option
                        if ( is_admin() ) {
                            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                            echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
                            echo "<td><a href='users.php?source=edit_user&p_id={$user_id}'>Edit</a></td>";
                            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                        } 
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>

</div>

