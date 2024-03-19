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
                        <h2>Categories</h2>
                        
                        <?php

                        //show all categories - table
                        $db_cat = "SELECT * FROM categories";
                        $select_cat = mysqli_query($connection, $db_cat);

                        confirm( 'db_categories' , $select_cat );


                        //add category
                        if ( isset($_POST['submit'])) {
                            $add_cat_title = escape($_POST['cat_title']);

                            if ( $add_cat_title == "" || empty($add_cat_title)) {
                                echo 'this field should not be empty';
                            } else {
                                $add_db_category = "INSERT INTO categories(cat_title)";
                                $add_db_category .= "VALUE('{$add_cat_title}')";
                                $create_category = mysqli_query($connection, $add_db_category);
                                
                                confirm( 'submit' , $create_category );
                                
                                header("Location: categories.php");
                            }
                        }


                        //remove category
                        if ( isset($_GET['delete']) ) {
                            $remove_get_cat = escape($_GET['delete']);

                            $remove_db_cat = "DELETE FROM categories WHERE cat_id = {$remove_get_cat}";
                            $remove_cat = mysqli_query($connection, $remove_db_cat);
                            
                            confirm( 'delete' , $remove_cat );

                            header("Location: categories.php");
                        }

                        ?>
                        <div class="d-flex gap-3 justify-content-between">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Add Cateogory </label>
                                    <input type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add category">
                                </div>
                            </form>

                            <?php 
                                //update category - show form with input and submit
                                if ( isset($_GET['edit']) ) {
                                    $update_get_cat = escape($_GET['edit']);

                                    $udpate_db_cat = "SELECT * FROM categories WHERE cat_id = {$update_get_cat}";
                                    $update_cat = mysqli_query($connection, $udpate_db_cat);
    
                                    confirm( 'edit' , $update_cat );

                                    while ( $update_cat_row = mysqli_fetch_assoc($update_cat) ) {
                                        $up_cat_id = $update_cat_row['cat_id'];
                                        $up_cat_title = $update_cat_row['cat_title'];

                                        if ( isset($up_cat_title) ) {
                                            ?>
                                                <form action="" method="post">
                                                    <div class="form-group">
                                                        <label for="cat_title">Edit Cateogory </label>
                                                        
                                                        <input type="text" name="cat_title" value="<?php echo $up_cat_title; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="btn btn-primary" type="submit" name="submit-update" value="Edit category">
                                                    </div>
                                                </form>
                                            <?php
                                        }
                                    }

                                        //update category - submit
                                    if ( isset($_POST['submit-update']) ) {
                                        $up_sub_cat_id = escape($_POST['cat_id']);
                                        $up_sub_cat_title = escape($_POST['cat_title']);

                                        if ( $up_sub_cat_title == "" || empty($up_sub_cat_title) ) {
                                            echo 'this field should not be empty';
                                        } else {

                                            $update_sub_db_category = "UPDATE categories SET cat_title = '{$up_sub_cat_title}' WHERE cat_id = {$up_cat_id}";
                                            $update_category = mysqli_query($connection, $update_sub_db_category);
                                            
                                            confirm( 'update' , $update_category );
                                            
                                            header("Location: categories.php");
                                        }
                                    }
                                }
                            ?>
                            
                        </div>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        while ( $show_all_row = mysqli_fetch_assoc($select_cat) ) {
                                            echo '<tr>';
                                                $show_cat_id = $show_all_row['cat_id'];
                                                $show_cat_title = $show_all_row['cat_title'];
                                                echo "<td>{$show_cat_id}</td>";
                                                echo "<td>{$show_cat_title}</td>";
                                                echo "<td><a href='categories.php?delete={$show_cat_id}'>Delete</a></td>";
                                                echo "<td><a href='categories.php?edit={$show_cat_id}'>Edit</a></td>";
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>

                    </div>
                </div>
                
            </div>
    
        </div>
        
        <?php include 'admin-footer.php'; ?> 
    
    </body>

</html>
