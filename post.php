<!DOCTYPE HTML>
<html lang="en">
<?php include 'header.php'; ?> 

    <body>
        <div class="container">
            <div class="d-flex flex-column gap-5">

                <?php include 'navigation.php'; ?> 

                <div class="row">
                    <div class="col-lg-9">
                        <div class="block-post d-flex flex-column gap-1">
                            <?php

                                //  likes
                                if ( isset( $_POST['liked'] ) ) {

                                    $post_id = $_POST['post_id'];
                                    $user_id = $_POST['user_id'];
                    
                                    echo 'like' . $user_id;
                                    echo 'post_id' . $post_id;

                                    $post_like = select_from_where( 'posts', 'post_id', $post_id, true );

                                    $likes = $post_like['post_likes'];

                                    udpdate_set_where( 'posts', 'post_likes', $likes+1, 'post_id', $post_id );

                                    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id) ");
                                    exit;
                                }

                                //  unlikes
                                if ( isset( $_POST['unliked'] ) ) {

                                    $post_id = $_POST['post_id'];
                                    $user_id = $_POST['user_id'];
                    
                                    $post_like = select_from_where( 'posts', 'post_id', $post_id, true );

                                    $likes = $post_like['post_likes'];

                                    delete_from_where( 'likes', 'post_id', $post_id, 'user_id', $user_id );

                                    udpdate_set_where( 'posts', 'post_likes', $likes-1, 'post_id', $post_id );

                                    exit;
                                }
                                
                            
                                //single post
                                if ( isset($_GET['p_id']) ) {
                                    $is_result = false;

                                    $the_post_id = escape($_GET['p_id']);

                                     //add count of views
                                     $add_query_count_views = "UPDATE posts SET post_views_count = post_views_count + 1 ";
                                     $add_query_count_views .= "WHERE post_id = {$the_post_id}";
                                     $add_count_views = mysqli_query($connection, $add_query_count_views);
                             
                                     confirm( 'add count views' , $add_count_views );

                                    if (isset($_SESSION['username']) && is_admin() ) {
                                        // $db_posts = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_user, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_comment_count, posts.post_status, posts.post_views_count, "; 
                                        // $db_posts .= "categories.cat_id, categories.cat_title ";
                                        // $db_posts .= "FROM posts ";
                                        // $db_posts .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC ";

                                        $stmt1 = mysqli_prepare($connection, "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_id = ?");
                            
                                    } else {
                                        $stmt2 = mysqli_prepare($connection , "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_id = ? AND post_status = ? ");
                                
                                        $published = 'published';
                                    }
                            
                            
                                    if (isset($stmt1)){
                                
                                        mysqli_stmt_bind_param($stmt1, "i", $the_post_id);
                                
                                        mysqli_stmt_execute($stmt1);
                                
                                        mysqli_stmt_bind_result($stmt1, $post_id, $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags, $cat_id, $cat_title );
                                
                                        $stmt = $stmt1;
                                
                                
                                    } else {
                                
                                        mysqli_stmt_bind_param($stmt2, "is", $the_post_id, $published);
                                
                                        mysqli_stmt_execute($stmt2);

                                        mysqli_stmt_bind_result($stmt2, $post_id, $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags, $cat_id, $cat_title );
                                
                                        $stmt = $stmt2;
                                
                                    }
                                    
                                      
                            
                                    // if ( isset( $_SESSION['user_role'] ) && $_SESSION['user_role'] == 'admin' ) {
                                    //     $the_db_post = "SELECT * FROM posts WHERE post_id = $the_post_id";
                                    // } else {
                                    //     $the_db_post = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
                                    // }

                                    // $the_post = mysqli_query($connection, $the_db_post);
                            
                                    // confirm( 'single post' , $the_post );


                                    while(mysqli_stmt_fetch($stmt)) {
                            
                                        // while ( $the_post_row = mysqli_fetch_assoc($the_post) ) {
                                        //     $post_title = $the_post_row['post_title'];
                                        //     $post_category_id = $the_post_row['post_category_id'];
                                        //     $post_author = $the_post_row['post_author'];
                                        //     $post_date = $the_post_row['post_date'];
                                        //     $post_image = $the_post_row['post_image'];
                                        //     $post_content = $the_post_row['post_content'];
                                        //     $post_tags = $the_post_row['post_tags'];
                                            // $post_status = $the_post_row['post_status'];

                                        $is_result = true;


                                        if ( $post_title ) {
                                            echo "<h2>{$post_title}</h2>";
                                        }
                
                                        echo '<div class="d-flex gap-2">';
                                            if ( $post_author ) {
                                                echo "<a href='autor.php?p_id={$the_post_id}'>{$post_author}</a>";
                                            }
                    
                                            if ( $post_date ) {
                                                echo "<span>{$post_date}</span>";
                                            }
                                        echo '</div>';

    
                                        echo "<span>Name of Category: {$cat_title}</span>";
                
                                        if ( $post_image ) {
                                            echo "<img src='/study_php/img/{$post_image}' style='width: 500px; height: auto;'>";
                                        }
                
                                        if ( $post_content ) {
                                            echo "<p>{$post_content}</p>";
                                        }
                
                                        if ( $post_tags ) {
                                            echo "<span>{$post_tags}</span>";
                                        }

                                        mysqli_stmt_free_result($stmt);
                                        ?>

                                        <div class="block-like">

                                            <?php if ( isLoggedIn() ) : ?>
                                                <p class="pull-right">
                                                    <a class="tooltip-main <?php echo userLikedThisPost($the_post_id) ? 'js-unlike' : 'js-like'; ?>" href="" data-id="<?php echo $the_post_id; ?>" data-user="<?php echo loggedInUserId(); ?>">
                                                        <span class="tooltiptext"><?php echo userLikedThisPost($the_post_id) ? 'I liked this before' : 'Want to like it?'; ?></span>
                                                        <?php echo userLikedThisPost($the_post_id) ? 'Unlike' : 'Like'; ?>
                                                    </a>
                                                </p>
                                            <?php else: ?>
                                                <p class="pull-right">Do you want like this? <a href="/study_php/login">Login in</a></p>
                                            <?php endif; ?>

                                            <span class="count-like">Like: <?php echo select_from_where_count('likes', 'post_id', $the_post_id); ?></span>
                                        </div>

                                        <?php
                                    }

                                    include 'includes/comments.php';
                

                                    if ( !$is_result ) {
                                        header("Location: index.php");
                                    }

                                } else {
                                    header("Location: index.php");
                                }

                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <?php include 'block-sidebar.php'; ?> 
                    </div>
                </div>
    
            </div>

            
        </div>

        <?php include 'footer.php'; ?> 

                                
        <script>
            $(document).ready(function(){

                // $("[data-toggle='tooltip']").tooltip(); //need check
                var js_like = $( '.js-like' ),
                js_unlike = $( '.js-unlike' );
                var type_post_id = <?php echo $the_post_id; ?>;
                var type_user_id = <?php echo loggedInUserId(); ?>;
                                    
                //like
                if ( js_like ) {    
                    js_like.on( 'click', function() {
                        console.log('clickedxs');
                        $.ajax({ 
                            url: "/study_php/post.php?p_id=<?php echo $type_post_id; ?>",
                            type: 'post',
                            data: {
                                liked: 1,
                                'post_id' : type_post_id,
                                'user_id' : type_user_id,
                            }
                        } );
                    } );
                }

                //Unlike
                if ( js_unlike ) {    
                    js_unlike.on( 'click', function() {
                        console.log('clickedxs');
                        $.ajax({ 
                            url: "/study_php/post.php?p_id=<?php echo $type_post_id; ?>",
                            type: 'post',
                            data: {
                                unliked: 1,
                                'post_id' : type_post_id,
                                'user_id' : type_user_id,
                            }
                        } );
                    } );
                }
            } );

        </script>
    </body>
</html>
