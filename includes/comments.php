<?php 
    //create comment
    if ( isset($_POST['create_comment']) ) {
        $the_post_id = $_GET['p_id'];

        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];

        if ( !empty($comment_author) && !empty($comment_email) && !empty($comment_content) ) {
            $query_comment = "INSERT INTO comments (comment_user_id, comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
            $query_comment .= "VALUES ('{$_SESSION['user_id']}', $the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
    
            $create_comment_query = mysqli_query($connection, $query_comment);
    
            confirm( 'create comment' , $create_comment_query );
    
            //add count of comment
    
            // $add_query_count_comment = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
            // $add_query_count_comment .= "WHERE post_id = {$the_post_id}";
            // $add_count_comment = mysqli_query($connection, $add_query_count_comment);
    
            // confirm( 'add count comment' , $add_count_comment );

        } else {
            echo "<script>alert('field cannor be empty')</script>";
        }

        header( "Location: post.php?p_id={$the_post_id}");
    }
?>

<div class="well">
    <h4>leave a comment:</h4>
    <form action="" method="post" role="form">
        <div class="form-group">
            <label for="comment_author">Author</label>
            <input type="text" class="form-control" name="comment_author">
        </div>
        <div class="form-group">
            <label for="comment_email">Email</label>
            <input type="email" class="form-control" name="comment_email">
        </div>
        <div class="form-group">
            <label for="comment_content">Comment</label>
            <textarea class="form-control" name="comment_content" rows="3"></textarea>
        </div>
        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php 
    //show all comments
    $query_show_all_comments = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} "; 
    $query_show_all_comments .= "AND comment_status = 'approve' ";
    $query_show_all_comments .= "ORDER BY comment_id DESC";
    $select_show_all_comments = mysqli_query($connection, $query_show_all_comments);
    
    confirm( 'show all comments' , $select_show_all_comments );

    while ( $row_show_all = mysqli_fetch_array($select_show_all_comments)) {
        $comment_author = $row_show_all['comment_author'];
        $comment_date = $row_show_all['comment_date'];
        $comment_content = $row_show_all['comment_content'];

    ?>

        <div class="media">
            <div class="media-body" style="border: 1px solid #DEDEDE; border-radius: 5px; padding: 10px;">
                <h4 class="media-heading">
                    <?php echo $comment_author; ?>
                    <small style="color: #adb5bd; font-size: 14px;"><?php echo $comment_date; ?></small>
                </h4>
                <div class="media-content">
                    <?php echo $comment_content; ?>
                </div>
            </div>
        </div>
    <?php


    }

?>

