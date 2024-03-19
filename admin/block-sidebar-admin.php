<div class="block-sidebar-admin">
    <ul class="list-group">
        <li class="list-group-item"><a href="index.php">Dashboard</a></li>
        <li class="list-group-item"><a href="posts.php">View all posts</a></li>
        <li class="list-group-item"><a href="posts.php?source=add_post">Add posts</a></li>
        <li class="list-group-item"><a href="categories.php">categories</a></li>
        <li class="list-group-item"><a href="comments.php">comments</a></li>
        <?php if ( is_admin() ): ?>
            <li class="list-group-item"><a href="users.php">users</a></li>
        <?php endif; ?>
        <li class="list-group-item"><a href="users.php?source=add_user">Add user</a></li>
        <li class="list-group-item"><a href="profile.php">profile</a></li>
        <li class="list-group-item"><a href="#">log out</a></li>


    </ul>

    
</div>

