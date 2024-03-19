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
                                //single post
                                if ( isset($_GET['c_id']) ) {
                                    $is_result = false;

                                    $the_cat_id = escape($_GET['c_id']);

                                    $get_db_cat_by_id = "SELECT * FROM categories WHERE cat_id = {$the_cat_id}";
                                    $get_db_cat = mysqli_query($connection, $get_db_cat_by_id);
                                    confirm( 'get cat' , $get_db_cat );

                                    while ( $get_cat_row = mysqli_fetch_assoc($get_db_cat) ) {
                                        $cat_title = $get_cat_row['cat_title'];

                                        echo "<h2>Name of Category: {$cat_title}</h2>";
                                    }


                            
                                    $the_db_cat = "SELECT * FROM posts WHERE post_category_id = {$the_cat_id}";
                                    $the_cat = mysqli_query($connection, $the_db_cat);
                            
                                    confirm( 'single cat' , $the_cat );

                                    while ( $the_post_row = mysqli_fetch_assoc($the_cat) ) {
                                        $post_id = $the_post_row['post_id'];
                                        $post_title = $the_post_row['post_title'];
                                        $post_author = $the_post_row['post_author'];
                                        $post_date = $the_post_row['post_date'];
                                        $post_image = $the_post_row['post_image'];
                                        $post_content = substr($post_row['post_content'], 0 , 200);
                                        $post_tags = $the_post_row['post_tags'];
                                        // $post_status = $the_post_row['post_status'];
                            
                                        $is_result = true;

                                        if ( $post_title ) {
                                            echo "<h2>{$post_title}</h2>";
                                        }
                
                                        echo '<div class="d-flex gap-2">';
                                            if ( $post_author ) {
                                                echo "<span>{$post_author}</span>";
                                            }
                    
                                            if ( $post_date ) {
                                                echo "<span>{$post_date}</span>";
                                            }
                                        echo '</div>';
                
                                        if ( $post_image ) {
                                            echo "<img src='img/{$post_image}' style='width: 500px; height: auto;'>";
                                        }
                
                                        if ( $post_content ) {
                                            echo "<p>{$post_content}</p>";
                                        }
                
                                        if ( $post_tags ) {
                                            echo "<span>{$post_tags}</span>";
                                        }
                
                                        echo "<a class='btn btn-primary' href='post.php?p_id={$post_id}'>Read more</a>";
                
                                        
                                    }

                                    if ( !$is_result ) {
                                        echo ' IS empty';
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
