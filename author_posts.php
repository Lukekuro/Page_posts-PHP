<!DOCTYPE HTML>
<html lang="en">
<?php include 'header.php'; ?> 

    <body>
        <div class="container">
            <div class="d-flex flex-column gap-5">

                <?php include 'navigation.php'; ?> 
    
                <div class="row">
                    <h1>main autor - <?php echo $_GET['author']; ?></h1>
                    <div class="col-lg-9">
                        <div class="block-post d-flex flex-column gap-1">
                            <?php
                                //single post
                                if ( isset($_GET['p_id']) ) {
                                    $the_post_id = escape($_GET['p_id']);
                                    $the_author_posts = escape($_GET['author']);
                            
                                    $the_db_post = "SELECT * FROM posts WHERE post_author = '{$the_author_posts}'";
                                    $the_post = mysqli_query($connection, $the_db_post);
                            
                                    confirm( 'single post' , $the_post );
                            
                                    while ( $the_post_row = mysqli_fetch_assoc($the_post) ) {
                                        $post_title = $the_post_row['post_title'];
                                        $post_category_id = $the_post_row['post_category_id'];
                                        $post_author = $the_post_row['post_author'];
                                        $post_date = $the_post_row['post_date'];
                                        $post_image = $the_post_row['post_image'];
                                        $post_content = $the_post_row['post_content'];
                                        $post_tags = $the_post_row['post_tags'];
                                        // $post_status = $the_post_row['post_status'];


                            
                                        if ( $post_title ) {
                                            echo "<h2>{$post_title}</h2>";
                                        }
                
                                        echo '<div class="d-flex gap-2">';
                                            if ( $post_author ) {
                                                echo "<a href='author_posts.php?author={$post_author}&p_id={$the_post_id}'>{$post_author}</a>";
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


                                        include 'includes/comments.php';
                
                
                                        
                                    }

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


    
    </body>
</html>
