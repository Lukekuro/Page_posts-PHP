<?php 
     //update category - show form with input and submit
    if ( isset($_GET['p_id']) ) {
        $the_post_id = $_GET['p_id'];

        $update_db_post = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
        $update_post = mysqli_query($connection, $update_db_post);

        confirm( 'edit' , $update_post );

        while ( $update_post_row = mysqli_fetch_assoc($update_post) ) {
            $up_post_title = $update_post_row['post_title'];
            $up_post_category_id = $update_post_row['post_category_id'];
            $up_post_author = $update_post_row['post_author'];
            $up_post_date = $update_post_row['post_date'];
            $up_post_image = $update_post_row['post_image'];
            $up_post_image_temp = $update_post_row['post_image']['tmp_name']; //location
            $up_post_content = $update_post_row['post_content'];
            $up_post_tags = $update_post_row['post_tags'];
            $up_post_status = $update_post_row['post_status'];


            ?>
                <h2>Edit post</h2>

                <form action="" method="post" enctype="multipart/form-data">
                        
                    <div class="form-group">
                        <label for="post_title">Post Title</label>
                        <input value="<?php echo isset($up_post_title) ? $up_post_title : ''; ?>" type="text" name="post_title" class="form-control">
                    </div>

                    <?php 
                        //show all categories
                        $db_cat = "SELECT * FROM categories";
                        $select_cat = mysqli_query($connection, $db_cat);

                        confirm( 'db_categories' , $select_cat );
                    ?>     
                    <div class="form-group">
                        <label for="post_category_id" class="d-block">Post category_id</label>
                        <select name="post_category_id">
                            <?php 
                                while ( $show_all_row = mysqli_fetch_assoc($select_cat) ) {
                                    $show_cat_id = $show_all_row['cat_id'];
                                    $show_cat_title = $show_all_row['cat_title'];
                                    echo "<option value='{$show_cat_id}'>{$show_cat_title}</option>";
                                }
                            ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="post_author">Post author</label>
                        <input value="<?php echo isset($up_post_author) ? $up_post_author : ''; ?>" type="text" name="post_author" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="post_date">Post date</label>
                        <input value="<?php echo isset($up_post_date) ? $up_post_date : ''; ?>" type="date" name="post_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="post_image" class="d-block">Post image</label>
                        <img src="../img/<?php echo isset($up_post_image) ? $up_post_image : ''; ?>" alt="" class="img-thumbnail" style="max-width: 200px;">

                        <input value="" type="file" name="post_image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="post_content">Post content</label>
                        <textarea type="text" name="post_content" class="form-control" id="summernote" cols="30" rows="10"><?php echo isset($up_post_content) ? $up_post_content : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="post_tags">Post tags</label>
                        <input value="<?php echo isset($up_post_tags) ? $up_post_tags : ''; ?>" type="text" name="post_tags" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="post_status">Post status</label>
                        <select name="post_status">
                            <option value="<?php echo $up_post_status; ?>"><?php echo $up_post_status; ?></option>
                            <?php 
                                if ( $up_post_status == 'published' ) {
                                    echo "<option value='draft'>draft</option>";
                                } else {
                                    echo "<option value='published'>published</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit-edit" class="btn btn-primary" value="edit post">
                    </div>


                </form>

            <?php
        }


        //update post - submit
        if ( isset($_POST['submit-edit']) ) {
            $up_sub_post_id = escape($_POST['post_id']);
            $up_sub_post_title = escape($_POST['post_title']);
            $up_sub_post_category_id = escape($_POST['post_category_id']);
            $up_sub_post_author = escape($_POST['post_author']);
            $up_sub_post_date = escape($_POST['post_date']);
            $up_sub_post_image = escape($_FILES['post_image']['name']);
            $up_sub_post_image_temp = escape($_FILES['post_image']['tmp_name']); //location
            $up_sub_post_content = escape($_POST['post_content']);
            $up_sub_post_tags = escape($_POST['post_tags']);
            $up_sub_post_status = escape($_POST['post_status']);

            if ( empty($up_sub_post_image) ) {
                $update_image = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
                $select_image = mysqli_query($connection, $update_image);

                while ($row_image = mysqli_fetch_array($select_image)) {
                    $up_sub_post_image = $row_image['post_image'];
                }
            }

            if ( $up_sub_post_title == "" || empty($up_sub_post_title) ) {
                echo 'this field should not be empty';
            } else {

                move_uploaded_file( $up_sub_post_image_temp, "../img/$up_sub_post_image" );


                $update_sub_db_post = "UPDATE posts SET ";
                $update_sub_db_post .= "post_title = '{$up_sub_post_title}', ";
                $update_sub_db_post .= "post_category_id = '{$up_sub_post_category_id}', ";
                $update_sub_db_post .= "post_author = '{$up_sub_post_author}', ";
                $update_sub_db_post .= "post_date = '{$up_sub_post_date}', ";
                $update_sub_db_post .= "post_image = '{$up_sub_post_image}', ";
                $update_sub_db_post .= "post_content = '{$up_sub_post_content}', ";
                $update_sub_db_post .= "post_tags = '{$up_sub_post_tags}', ";
                $update_sub_db_post .= "post_status = '{$up_sub_post_status}' WHERE post_id = {$the_post_id}";
                $update_post = mysqli_query($connection, $update_sub_db_post);
                
                confirm( 'update' , $update_post );
                
                header("Location: posts.php");
            }
        }

        
    }

?>
