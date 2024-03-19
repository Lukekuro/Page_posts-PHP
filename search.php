<!DOCTYPE HTML>
<html lang="en">
<?php include 'header.php'; ?> 

    <body>
        <div class="container">
            <div class="d-flex flex-column gap-5">

                <?php include 'navigation.php'; ?> 
    
                <div class="row">
                    <div class="col-lg-8">
                        <div class="block-post d-flex flex-column gap-5">
                            <?php

                                if ( isset($_POST['submit'])) {
                                    $search = $_POST['search'];
        
                                    $db_search = "SELECT * FROM posts WHERE post_status = 'published' AND ( post_tags LIKE '%$search%' OR post_title LIKE '%$search%' OR post_author LIKE '%$search%' OR post_content LIKE '%$search%')";
                                    $search_query = mysqli_query($connection, $db_search);
        
                                    if ( !$search_query ) {
                                        die( 'Query failed' . mysqli_error($connection) . '</br>' . mysqli_error() );
                                    }
        
                                    $count = mysqli_num_rows($search_query);
        
                                    if ( $count == 0 ) {
                                        echo ' no result';
                                    } else {
                                        echo "<h2>Result is: {$search}</h2>";
                                        
                                        //posts
                                        while ( $post_row = mysqli_fetch_assoc($search_query) ) {
                                            $post_id = $post_row['post_id'];
                                            $post_title = $post_row['post_title'];
                                            $post_author = $post_row['post_author'];
                                            $post_date = $post_row['post_date'];
                                            $post_image = $post_row['post_image'];
                                            $post_content = $post_row['post_content'];
                                            $post_tags = $post_row['post_tags'];
                                            $post_comment_count = $post_row['post_comment_count'];
                                            // $post_status = $post_row['post_status'];

                                        echo '<div class="d-flex flex-column gap-1">';

                    
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
                        
                        
                                                echo "<a class='btn btn-primary' href='{$post_id}'>Read more</a>";
                                                echo '</div>';

                                        }

                                    }
                                }
                                
                            
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <?php include 'block-sidebar.php'; ?> 
                    </div>
                </div>
    
            </div>

            
        </div>


    
    </body>
</html>
