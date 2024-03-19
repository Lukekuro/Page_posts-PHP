<?php
//VIEW ALL POSTS

//show all posts - table

//display all posts
// $db_posts = "SELECT * FROM posts ORDER BY post_id DESC";

//display all posts and get some from categories
$db_posts = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_user, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_comment_count, posts.post_status, posts.post_views_count, "; 
$db_posts .= "categories.cat_id, categories.cat_title ";
$db_posts .= "FROM posts ";
$db_posts .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE posts.post_user_id = ".loggedInUserId()." ORDER BY post_id DESC ";
$display_posts = mysqli_query($connection, $db_posts);
confirm( 'display_posts' , $display_posts );



//remove post - without form
// if ( isset($_GET['delete']) ) {
//     if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] == 'admin' ) {
//         $remove_get_post = escape($_GET['delete']); 

//         delete_from_where( 'posts', 'post_id', $remove_get_post );
    
//         header("Location: posts.php");
//     }
// }

//remove post - with form
if ( isset($_POST['delete']) ) {
    if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] == 'admin' ) {
        $remove_the_post = escape($_POST['post_id']); 

        delete_from_where( 'posts', 'post_id', $remove_the_post );
    
        header("Location: posts.php");
    }
}

//reset view
if ( isset($_GET['reset']) ) {
    $reset_views_get_post = $_GET['reset'];

    udpdate_set_where( 'posts', 'post_views_count', 0, 'post_id', escape($reset_views_get_post) );

    header("Location: posts.php");
}

if ( isset($_POST['checkBoxArray']) ) {


    foreach ( $_POST['checkBoxArray'] as $postValueId ) {

        $bulk_options = $_POST['bulk-options'];

        switch ( $bulk_options ) {
            case 'published';
                udpdate_set_where( 'posts', 'post_status', $bulk_options, 'post_id', $postValueId );
                header("Location: posts.php");
                break;

            case 'draft';
                udpdate_set_where( 'posts', 'post_status', $bulk_options, 'post_id', $postValueId );
                header("Location: posts.php");
                break;

            case 'delete';
                delete_from_where( 'posts', 'post_id', $postValueId );
                header("Location: posts.php");
                break;

            case 'clone';
                $query_clone = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $update_to_clone = mysqli_query( $connection, $query_clone );
                confirm( 'update_to_clone' , $update_to_clone );

                while ( $row_clone = mysqli_fetch_assoc($update_to_clone) ) {
                    $post_category_id = $row_clone['post_category_id'];
                    $post_title = $row_clone['post_title'];
                    $post_user = $row_clone['post_user'];
                    $post_author = $row_clone['post_author'];
                    $post_date = $row_clone['post_date'];
                    $post_image = $row_clone['post_image'];
                    $post_content = $row_clone['post_content'];
                    $post_tags = $row_clone['post_tags'];
                }

                if ( empty($post_user) ) {
                    $post_user = 'no user';
                }

                if ( empty($post_tags) ) {
                    $post_tags = 'no tags';
                }

                $query_clone_insert = "INSERT INTO posts( post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status, post_views_count) ";
                $query_clone_insert .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '0', 'draft', '0') ";

                $clone_posts = mysqli_query($connection, $query_clone_insert);

                confirm( 'clone post' , $clone_posts );

                header( "Location: posts.php");
                break;
        }

    }
}


?>
<h2>View all posts</h2>

    <form action="" method="post">
        <div class="d-flex gap-1 align-items-center">
            <div class="options">
                <select name="bulk-options" id="" class="from-control">
                    <option value="">Select options</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                    <option value="clone">clone</option>
                </select>
            </div>
            <input type="submit" name="submit-options" class="btn btn-success" value="Apply">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add new post</a>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Category Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Content</th>
                    <th>Tags</th>
                    <th>Count of comment</th>
                    <th>Post status</th>
                    <th>Views</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while ( $row = mysqli_fetch_assoc($display_posts) ) {
                        //posts
                        $post_id = $row['post_id'];
                        $post_category_id = $row['post_category_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        // $post_comment_count = $row['post_comment_count'];
                        $post_status = $row['post_status'];
                        $post_views_count = $row['post_views_count'];

                        //categories
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        //count_all_comments
                        $count_comments = select_from_where_count( 'comments', 'comment_post_id', $post_id );

                        echo '<tr>';

                            echo "<td><input class='selectOneBox' type='checkbox' name='checkBoxArray[]' value='{$post_id}'></td>";
                            echo "<td>{$post_id}</td>";
                            echo "<td>{$post_user}</td>";
                            echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                            echo "<td>{$cat_title}</td>";
                            echo "<td>{$post_author}</td>";
                            echo "<td>{$post_date}</td>";
                            echo "<td><img src='../img/{$post_image}' class='img-thumbnail'></td>";
                            echo "<td>{$post_content}</td>";
                            echo "<td>{$post_tags}</td>";

                            echo "<td><a href='posts.php?source=post_comments&p_id={$post_id}'>{$count_comments}</a></td>";
                            echo "<td>{$post_status}</td>";
                            echo "<td>{$post_views_count}</td>";

                            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                            // echo "<td><span class='js-delete btn btn-primary' data-id='{$post_id}'>Delete</span></td>";
                            echo "<td><a href='posts.php?reset={$post_id}'>Reset views</a></td>";

                            ?>  
                                <form method="post">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                    <td>
                                        <input class="btn btn-danger" type="submit" name="delete" value="delete">
                                    </td>
                                </form>

                            <?php 
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </form>

    <?php 
     ?>

</div>

