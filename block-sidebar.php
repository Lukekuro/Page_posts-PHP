<div class="block-sidebar d-flex flex-column gap-5">
    <div class="block-sidebar__search">
        <h3>Search</h3>
        <form action="search.php" method="post">
            <input type="text" name="search">
            <button name="submit" type="submit">Search</button>
        </form>
    </div>

    <!-- Categories -->
    <div class="block-sidebar__categories">
        <h3>Bog categorues</h3>

        <?php 
            //categories
            $db_categories = "SELECT * FROM categories LIMIT 3";
            $select_all_cat = mysqli_query($connection, $db_categories);

            if ( !$select_all_cat ) {
                die( 'Query failed' . mysqli_error());
            }

            echo '<ul class="list-group">';

                while ( $cat_row = mysqli_fetch_assoc($select_all_cat) ) {
                    $cat_id = $cat_row['cat_id'];
                    $cat_title = $cat_row['cat_title'];
                    echo "<li class='list-group-item'><a href='category.php?c_id={$cat_id}'>{$cat_title}</a></li>";
                }

            echo '</ul>';
        ?>

    </div>


    <?php 
        if ( !isset($_SESSION['user_role']) ) {

        checkIfUserIsLoggedAndRedirect('/study_php/admin');

        if ( IfItIsMethod( 'post' ) ) {
            if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
                loginIn( $_POST['username'], $_POST['password'] );
            } else {
                redirect( "/study_php/login" );
            }
        }

    ?>
        <!-- Login -->
        <div class="block-sidebar__login well">
            <h3>Login</h3>

            <form method="post">
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
            <!-- <a href="/study_php/forgot/<?php echo uniqid(true); ?>">Forgot password?</a> -->
            <a href="/study_php/forgot?forgot=<?php echo uniqid(true); ?>">Forgot password?</a>
        </div>
    <?php } ?>

</div>

