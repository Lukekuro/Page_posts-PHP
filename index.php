<!DOCTYPE HTML>
<html lang="en">
    <?php include 'header.php'; ?> 

    <body>
        <div class="container">
            <div class="d-flex flex-column gap-5">

                <?php include 'navigation.php'; ?> 
    
                <div class="row">
                    <h1>main site</h1>
                    <div class="col-lg-9">
                        <div class="block-post d-flex flex-column gap-1">
                            <?php

                                //pagination page
                                include 'includes/pagination-page.php'; 

                                //count of posts
                                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
                                $select_post_query_count = mysqli_query($connection, $post_query_count);
                                confirm( "count of posts" , $select_post_query_count );
                                $count_posts = mysqli_num_rows($select_post_query_count);
                                $count_posts = ceil($count_posts / $page_num_max);

                                //posts
                                $db_posts = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1,$page_num_max"; //LIMIT 5,5 (from,to)
                                $select_all_posts = mysqli_query($connection, $db_posts);
                                confirm( 'posts' , $select_all_posts );

                                //result of post
                                $is_result = false;

                                

                                while ( $post_row = mysqli_fetch_assoc($select_all_posts) ) {
                                    $is_result = true;
                                    $post_id = $post_row['post_id'];
                                    $post_title = $post_row['post_title'];
                                    $post_category_id = $post_row['post_category_id'];
                                    $post_author = $post_row['post_author'];
                                    $post_date = $post_row['post_date'];
                                    $post_image = $post_row['post_image'];
                                    $post_content = substr($post_row['post_content'], 0 , 200);
                                    $post_tags = $post_row['post_tags'];
                                    $post_comment_count = $post_row['post_comment_count'];
                                    $post_status = $post_row['post_status'];

                                    if ( $post_title ) {
                                        echo "<h2>{$post_title}</h2>";
                                    }
            
                                    echo '<div class="d-flex gap-2">';
                                        if ( $post_author ) {
                                            echo "<a href='author_posts.php?author={$post_author}&p_id={$post_id}'>{$post_author}</a>";
                                        }
                
                                        if ( $post_date ) {
                                            echo "<span>{$post_date}</span>";
                                        }
                                    echo '</div>';

                                    $get_db_cat_by_id = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                                    $get_db_cat = mysqli_query($connection, $get_db_cat_by_id);
                                    confirm( 'get cat' , $get_db_cat );

                                    while ( $get_cat_row = mysqli_fetch_assoc($get_db_cat) ) {
                                        $cat_title = $get_cat_row['cat_title'];

                                        echo "<span>Name of Category: {$cat_title}</span>";
                                    }
            
                                    if ( $post_image ) {
                                        echo "<img src='img/{$post_image}' style='width: 500px; height: auto;'>";
                                    }
            
                                    if ( $post_content ) {
                                        echo "<p>{$post_content}</p>";
                                    }
            
                                    if ( $post_tags ) {
                                        echo "<span>{$post_tags}</span>";
                                    }
            
            
                                    echo "<a class='btn btn-primary' href='post/{$post_id}'>Read more</a>";
                                }

                                if ( !$is_result ) {
                                    echo "<h2>No result</h2>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <?php include 'block-sidebar.php'; ?> 
                    </div>
                </div>

                <?php include 'includes/pagination.php'; ?> 

    
            </div>

            
        </div>

        <?php include 'footer.php'; ?> 

    
    </body>
</html>
