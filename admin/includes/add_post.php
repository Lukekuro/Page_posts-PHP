<?php 
    if ( isset($_POST['submit-publish']) ) {
        $post_title = escape($_POST['post_title']);
        $post_category = escape($_POST['post_category_id']);
        $post_author = escape($_POST['post_author']);
        $post_image = escape($_FILES['post_image']['name']);
        $post_image_temp = escape($_FILES['post_image']['tmp_name']); //location
        $post_content = escape($_POST['post_content']);
        $post_tags = escape($_POST['post_tags']);
        $post_status = escape($_POST['post_status']);
        $post_comment_count = 0;

        move_uploaded_file( $post_image_temp, "../img/$post_image" );

        $add_db_post = "INSERT INTO posts(post_user_id, post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
        $add_db_post .= "VALUES('{$_SESSION['user_id']}', {$post_category}, '{$post_title}', '{$post_author}', '{$_SESSION['user_username']}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}') ";

        $create_post = mysqli_query($connection, $add_db_post);

        confirm( 'create post' , $create_post );
        
        header("Location: posts.php");
    }

?>
<h2>Add post</h2>
<form action="" method="post" enctype="multipart/form-data">
        
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="post_title" class="form-control">
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
            <!-- <option value="<?php echo isset($up_post_category_id) ? $up_post_category_id : ''; ?>" type="text" name="post_category_id" class="form-control"> -->

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
        <input type="text" name="post_author" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_image">Post image</label>
        <input type="file" name="post_image" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_content">Post content</label>
        <textarea type="text" name="post_content" class="form-control" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <label for="post_tags">Post tags</label>
        <input type="text" name="post_tags" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_status">Post status</label>
        <select name="post_status">
            <option value='draft'>draft</option>
            <option value='published'>published</option>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" name="submit-publish" class="btn btn-primary" value="publish post">
    </div>


</form>
