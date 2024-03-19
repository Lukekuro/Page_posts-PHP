<?php
//VIEW ALL comments

//show all comments - table
$db_comments = "SELECT * FROM comments WHERE comment_post_id = " . mysqli_real_escape_string($connection, $_GET['p_id']) . "";
$display_comments = mysqli_query($connection, $db_comments);

if ( !$display_comments ) {
    die( 'Query failed display_comments: ' . mysqli_error($connection));
}

//remove comment
if ( isset($_GET['delete']) ) {
    if ( isset( $_SESSION['user_role'] == 'admin' ) ) {

        $remove_get_comment = mysqli_real_escape_string($connection, $_GET['delete']);

        $remove_db_comment = "DELETE FROM comments WHERE comment_id = {$remove_get_comment}";
        $remove_comment = mysqli_query($connection, $remove_db_comment);
        
        confirm( 'delete' , $remove_comment );

        header("Location: posts.php?source=post_comments&p_id=" . $_GET['p_id'] . "");
    }
}

//unapprove comment
if ( isset($_GET['unapprove']) ) {
    $unapprove_get_comment = $_GET['unapprove'];

    $unapprove_db_comment = "UPDATE comments SET comment_status = 'unapprove' WHERE comment_id = {$unapprove_get_comment}";
    $unapprove_comment = mysqli_query($connection, $unapprove_db_comment);
    
    confirm( 'unapprove' , $unapprove_comment );

    header("Location: posts.php?source=post_comments&p_id=" . $_GET['p_id'] . "");
}


//approve comment
if ( isset($_GET['approve']) ) {
    $approve_get_comment = $_GET['approve'];

    $approve_db_comment = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = {$approve_get_comment}";
    $approve_comment = mysqli_query($connection, $approve_db_comment);
    
    confirm( 'approve' , $approve_comment );

    header("Location: posts.php?source=post_comments&p_id=" . $_GET['p_id'] . "");
}
?>
<h2>View all POST comments</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Comment ID</th>
                <th>Author</th>
                <th>Email</th>
                <th>In response to</th>
                <th>Content</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                while ( $row = mysqli_fetch_assoc($display_comments) ) {
                    echo '<tr>';
                        $comment_id = $row['comment_id'];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_email = $row['comment_email'];
                        $comment_content = $row['comment_content'];
                        $comment_status = $row['comment_status'];
                        $comment_date = $row['comment_date'];

                        echo "<td>{$comment_id}</td>";
                        echo "<td>{$comment_post_id}</td>";
                        echo "<td>{$comment_author}</td>";
                        echo "<td>{$comment_email}</td>";

                        $query_comment_post_id = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
                        $select_comment_id_query = mysqli_query($connection, $query_comment_post_id);

                        while ($comment_row = mysqli_fetch_assoc($select_comment_id_query)) {
                            $post_id = $comment_row['post_id'];
                            $post_title = $comment_row['post_title'];
                            echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                        }

                        echo "<td>{$comment_content}</td>";
                        echo "<td>{$comment_status}</td>";
                        echo "<td>{$comment_date}</td>";

                        echo "<td><a href='posts.php?source=post_comments&p_id=" . $_GET['p_id'] . "&approve={$comment_id}'>Approve</a></td>";
                        echo "<td><a href='posts.php?source=post_comments&p_id=" . $_GET['p_id'] . "&unapprove={$comment_id}'>Unapprove</a></td>";
                        echo "<td><a href='posts.php?source=post_comments&p_id=" . $_GET['p_id'] . "&delete=$comment_id'>Delete</a></td>";
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>

</div>

