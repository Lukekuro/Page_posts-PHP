<!DOCTYPE HTML>
<html lang="en">
</head>
<body>
<?php 
    //SET COOKIES
    // $name = "Somename";
    // $value = 100;
    // $expiration = time() + (60*60*24*7);
    // setcookie($name,$value,$expiration);

    // if ($_COOKIE['Somename']) {
    //     $someone = $_COOKIE['Somename'];
    // } else {
    //     $someone = '';
    // }

    // echo $someone; 

    //get information from index.php -> $_SESSION['gretting'];
    session_start();
    echo $_SESSION['gretting'];

        

    //code from index.php!!!!!!!!

    //SET COOKIES
    // $name = "Somename";
    // $value = 100;
    // $expiration = time() + (60*60*24*7);
    // setcookie($name,$value,$expiration);

    // if ($_COOKIE['Somename']) {
    //     $someone = $_COOKIE['Somename'];
    // } else {
    //     $someone = '';
    // }

    // echo $someone; 

    //Set information for seccion2.php -> $_SESSION['gretting'];
    // session_start();
    // $_SESSION['gretting'] = "hello";

    // class Car {

    //     public $wheels = 4;
    //     protected $hood = 1; // you can display this this way - function as showProtected(  )
    //     private $engine = 1;
    //     var $doors = 4;
    //     static $windows = 5;

    //     function MoveWheels() {
    //         // echo 'Move wheels';
    //         $this->wheels = 10;
    //     }

    //     function MoveWindows() { //if error then maybe do it: public static function MoveWheels() 
    //         // echo 'Move wheels';
    //         Car::$windows = 6; // only when is static
    //     }

    //     // function __construct() {  //show all wheels is 10, it is look like a important. Display this method enought use it $bmw = new Car();
    //     //     // echo 'Move wheels';
    //     //     echo $this->wheels = 10;
    //     // }

    //     function showProtected() { // display by protected
    //         echo $this->hood;
    //     }

    // }

    // // class Plane extends Car {  //extends (copy from Car)

    // //     var $wheels = 20;

    // //     // function MoveWheels() {
    // //     //     // echo 'Move wheels';
    // //     //     $this->wheels = 10;
    // //     // }

    // // }

    // // if ( class_exists('car') ) { //check if has class as Car or car
    // if ( method_exists('Car', 'MoveWheels') ) { //check if has class as Car and in Car has method ( function) ?
    //     // echo 'is method';
    //     $bmw = new Car();

        
    //     // $bmw->wheels = 8; //set for special var as wheels to 8
    //     $bmw->MoveWheels();
        
    //     echo $bmw->wheels;
    //     echo '</br>';
    //     // echo $bmw->showProtected();
        
    //     // $jet = new Plane();
        
    //     // echo '</br> jet ' . $jet->wheels;
    //     Car::MoveWindows(); // change number of windows by method with static
    //     echo Car::$windows; //display this static

    // } else {
    //     echo 'no';
    // }

   
    
    // //create file
    // $file = "example.txt";

    // $handle = fopen($file, 'w');
    // $handle_r = fopen($file, 'r');

    // if ( $handle ) {

    //     fwrite( $handle, 'testssaa22a' );

    //     fclose($handle);
    // } else {
    //     echo 'file is base';
    // }

    // if ( $handle_r ) {
    // //    echo fread( $handle_r, 2); //each bite equals a character czyli zobaczyc tylko tych literki
    //    echo fread( $handle_r, filesize($file)); //get full bit of file
    //     fclose($handle_r);

    // }

    // unlink("example1.txt"); // delete file
?>



<!-- study php -->

<?php 

        /**
         * SET COOKIES
         */
        $name = "Somename";
        $value = 100;
        $expiration = time() + (60*60*24*7);
        setcookie($name,$value,$expiration);

        if ($_COOKIE['Somename']) {
            $someone = $_COOKIE['Somename'];
        } else {
            $someone = '';
        }

        echo $someone;
        
		// $numberlist = array(); //or =[];

        //switch with case, break, default
		// $number = 10;

		// switch( $number ) {
		// 	case 9 :
		// 		echo '9';
		// 		echo '</br>';
        //         break;
		// 	case 10 :
		// 		echo '10';
		// 		echo '</br>';
        //         break;

		// 	case 11 :
		// 		echo '11';
        //         break;

        //     default :
        //         echo 'nothing';
        //         break;
		// }

        // //function get message and echo this
        // function greeting($message) {
        //     echo $message;
        // }

        // greeting('welcome');

        // echo '</br>';

        // //function global and local
        // $x_text = 'out'; // text on global

        // function convert_text() { // not works
        //     global $x_text; //get text from global
        //     $x_text = 'in'; // text on local, 
        // }

        // echo $x_text;
        // echo '</br>';

        // convert_text();
        
        // echo $x_text;

        // define('name', 1000);
        // echo name;
        // echo '</br>';

        // var_dump($_GET); // pobiera url po /?... e.g. /?id=10

        $connection = mysqli_connect('localhost', 'root', 'root', 'example');

        if ( !$connection ) {
            die( 'NO connect'  . mysqli_error($connection) );
        }

        //UPDATE
        if ( isset($_POST['submit-update'])) {

            // $name = ['alan', 'lukekuro'];
            
            $username = $_POST['username'];
            $password = $_POST['password'];
            $db_id = $_POST['id'];


            $username = mysqli_real_escape_string($connection, $username);
            $password = mysqli_real_escape_string($connection, $password);

            $password = crypt($password, '$1$batman$');

            //get from DB and set by ID (where)
            $db_query = "UPDATE users SET "; // get from DB
            $db_query .= "username = '$username', "; 
            $db_query .= "password = '$password' "; 
            $db_query .= "WHERE id = $db_id"; 

            $db_result = mysqli_query( $connection, $db_query );


            if ( !$db_result ) {
                die( 'Query failed - update' . mysqli_error($connection));
            }

            if ($username && $password ) {
                if ( strlen($username) < 5) {
                    echo 'username has to be longer than 5 ';
                // } else if ( in_array($username, $name)) {
                //     echo 'is base';
                } else {
                    echo 'Welcome';
                }
            }
            
        }
        //END - UPDATE

        //CREATE
        if ( isset($_POST['submit-create'])) {
            
            $username = $_POST['username'];
            $password = $_POST['password'];

            $username = mysqli_real_escape_string($connection, $username);
            $password = mysqli_real_escape_string($connection, $password);

            $password = crypt($password, '$1$batman$');

            $db_query = "INSERT INTO users(username,password) "; // sent to DB
            $db_query .= "VALUES ('$username', '$password')"; // sent to DB


            $db_result = mysqli_query( $connection, $db_query );


            
            if ( !$db_result ) {
                die( 'Query failed' . mysqli_error());
            }

            if ($username && $password ) {
                if ( strlen($username) < 5) {
                    echo 'username has to be longer than 5 ';
                } else {
                    echo 'Welcome';
                }
            }
        }
        //END - CREATE

        //delete
        if ( isset($_POST['submit-delete'])) {

            $db_id = $_POST['id'];

            //get from DB and remove by ID (where)
            $db_query = "DELETE FROM users "; 
            $db_query .= "WHERE id = $db_id"; 

            $db_result = mysqli_query( $connection, $db_query ); 


            if ( !$db_result ) {
                die( 'Query failed - delete' . mysqli_error($connection));
            }

            if ($db_id ) {
                echo 'removed';
            }

            
        }
        //END - delete

         


        // while ($db_row_inside = mysqli_fetch_assoc($get_db_result)) {
        //     print_r($db_row_inside);
        // }




	?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <!-- UPDATE DB BY ID -->
            <h2>UPDATE</h2>
            <form action="<?php echo get_permalink(); ?>" method="post">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password">

                <select name="id">
                    <?php 
                    
                        //get from DB
                        $get_db_query = "SELECT * FROM users"; 
                        $get_db_result = mysqli_query( $connection, $get_db_query );

                        if ( !$get_db_result ) {
                            die( 'Query DB failed' . mysqli_error());
                        }

                        while ($db_row = mysqli_fetch_assoc($get_db_result)) { // mysqli_fetch_assoc - pokazuje bardzo szczegolowo, a ten mysqli_fetch_row - mniej
                            // print_r($db_row);
                            // echo $db_row['id'];
                            // echo '</br>';
                            echo '<option value="' . $db_row['id'] . '">' . $db_row['id'] . '</option>';

                        }
                    ?>
                </select>

                <input type="submit" name="submit-update" value="Update">
            </form>
            <!-- END - UPDATE DB BY ID -->
        </div>
        <div class="col-lg-6">
            <!-- CREATE DB -->
            <h2>CREATE</h2>
            <form action="<?php echo get_permalink(); ?>" method="post">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password">

                <input type="submit" name="submit-create" value="Create">
            </form>
            <!-- END - CREATE DB -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <!-- DELETE ROWS BY ID -->
            <h2>DELETE ROWS</h2>
            <form action="<?php echo get_permalink(); ?>" method="post">
                <select name="id">
                    <?php 
                    
                        //get from DB
                        $get_db_query = "SELECT * FROM users"; 
                        $get_db_result = mysqli_query( $connection, $get_db_query );

                        if ( !$get_db_result ) {
                            die( 'Query DB failed' . mysqli_error());
                        }

                        while ($db_row = mysqli_fetch_assoc($get_db_result)) { // mysqli_fetch_assoc - pokazuje bardzo szczegolowo, a ten mysqli_fetch_row - mniej
                            // print_r($db_row);
                            // echo $db_row['id'];
                            // echo '</br>';
                            echo '<option value="' . $db_row['id'] . '">' . $db_row['id'] . '</option>';

                        }
                    ?>
                </select>

                <input type="submit" name="submit-delete" value="Delete">
            </form>
            <!-- END - UPDATE DB BY ID -->
        </div>
    </div>
</div>

</body>
</html>