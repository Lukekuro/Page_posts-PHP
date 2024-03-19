


<nav class="Page navigation example d-flex align-items-center justify-content-center">
    <ul class="pagination" >
    
        <?php
        $url_base = basename($_SERVER['PHP_SELF']);
        // echo  $url_base;
        if ( $page_num == 1 ) {
            echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
        } else {
            $page_num_prev = $page_num - 1;
            echo "<li class='page-item'><a class='page-link' href='{$url_base}?page={$page_num_prev}' >Previous</a></li>";
        }

        for ( $i = 1; $i <= $count_posts; $i++) {
            if ( $i == $page_num ) {
                echo "<li class='page-item active' style='pointer-events: none;'><span class='page-link'>{$i}</span></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='{$url_base}?page={$i}'>{$i}</a></li>";
            }
        }
    
        if ( $page_num == $count_posts ) {
            echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
        } else {
            $page_num_next = $page_num + 1;
            echo "<li class='page-item'><a class='page-link' href='{$url_base}?page={$page_num_next}' >Next</a></li>";
        }
    
    
        ?> 
    
    </ul>

</nav>