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

                <div class="col-lg-10">
                    <div class="block-post d-flex flex-column gap-5 p-3" style="border: 1px solid #CCC; border-radius: 5px;">

                        <?php 
                            if ( isset($_GET['source']) ) {
                                $source = $_GET['source'];
                            } else {

                            }

                            switch ( $source ) {
                                case 'add_post';
                                include 'includes/add_post.php';
                                break;

                                case 'edit_post';
                                include 'includes/edit_post.php';
                                break;

                                case 'post_comments';
                                include 'includes/post_comments.php';
                                break;

                                default:
                                include 'includes/view_all_posts.php';


                            }
                        ?>


                    </div>
                </div>
                
            </div>

        </div>

        <?php include 'admin-footer.php'; ?> 
        

    </body>

</html>
