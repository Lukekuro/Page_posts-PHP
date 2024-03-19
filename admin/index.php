<!DOCTYPE HTML>
<html lang="en">
    <?php include 'admin-header.php'; ?> 
    
    <body>
        <div class="d-flex flex-column gap-5">

            <?php include 'admin-navigation.php'; ?> 

            <div class="row">
                <div class="col-lg-2">
                    <?php include 'block-sidebar-admin.php'; ?> 
                </div>

                <div class="col-lg-10 d-flex flex-column gap-5">
                    <div class="block-post d-flex flex-column gap-1">
                            <h1>welcome to <?php echo $_SESSION['user_role']; ?>
                                <small style="color:#CCC; font-size: 26px;"><?php echo $_SESSION['user_username']; ?></small>
                            </h1>
                        <?php

                            // $post_counts = select_from_count('posts');
                            $post_counts = select_from_where_count('posts', 'post_user_id', loggedInUserId());

                            $comment_counts = select_from_where_count('comments', 'comment_user_id', loggedInUserId());

                            $user_counts = select_from_count('users');

                            $categories_counts = select_from_count('categories');

                            $post_published_counts = select_from_where_and_count('posts', 'post_status', 'published', 'post_user_id', loggedInUserId());
                            
                            $post_draft_counts = select_from_where_and_count('posts', 'post_status', 'draft', 'post_user_id', loggedInUserId());
                            
                            $comment_unapprove_counts = select_from_where_and_count('comments', 'comment_status', 'unapprove', 'comment_user_id', loggedInUserId());
                            
                            // $user_subscriber_counts = select_from_count("users WHERE user_role = 'subscriber'");
                            //OR
                            $user_subscriber_counts = select_from_where_count('users', 'user_role', 'subscriber');

                            

                        ?>
                        <div class="d-flex align-center gap-5">
                            <div class="d-flex flex-column gap-1 p-3" style="color: white; background-color: darkblue;">
                                <h2><?php echo $post_counts; ?></h2>
                                <small>Posts</small>
                                <a href="posts.php" class="footer-block p-4" style="background-color: #CCC; color: black;">View</a>
                            </div>

                            <div class="d-flex flex-column gap-1 p-3" style="color: white; background-color: darkgreen;">
                                <h2><?php echo $comment_counts; ?></h2>
                                <small>comments</small>
                                <a href="comments.php" class="footer-block p-4" style="background-color: #CCC; color: black;">View</a>
                            </div>

                            <div class="d-flex flex-column gap-1 p-3" style="color: white; background-color: darkgoldenrod;">
                                <h2><?php echo $user_counts; ?></h2>
                                <small>users</small>
                                <a href="users.php" class="footer-block p-4" style="background-color: #CCC; color: black;">View</a>
                            </div>

                            <div class="d-flex flex-column gap-1 p-3" style="color: white; background-color: darkred;">
                                <h2><?php echo $categories_counts; ?></h2>
                                <small>categories</small>
                                <a href="categories.php" class="footer-block p-4" style="background-color: #CCC; color: black;">View</a>
                            </div>
                        </div>

                    </div>


                    <div class="charts">
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['bar']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],

                                <?php 
                                    $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'C. Unapprove', 'Users', 'Subscriber', 'Categories'];
                                    $element_count = [$post_counts, $post_published_counts, $post_draft_counts, $comment_counts, $comment_unapprove_counts, $user_counts, $user_subscriber_counts, $categories_counts];
                                    $all_tabs = count( $element_text );
                                    for ( $i = 0; $i < $all_tabs; $i++ ) {
                                        echo "['{$element_text[$i]}', {$element_count[$i]}],";
                                    }
                                ?>
                                
                                ]);

                                var options = {
                                chart: {
                                    title: '',
                                    subtitle: '',
                                }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                chart.draw(data, google.charts.Bar.convertOptions(options));
                            }
                        </script>

                        <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
                    </div>

                </div>


                

            </div>


            

        </div>

        <?php include 'admin-footer.php'; ?> 
            
    
    </body>

</html>
