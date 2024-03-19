$(document).ready(function() {
    $('#summernote').summernote({
        height: 200
    });

    if ( $( '#selectAllBoxes' ) ) {
        $( '#selectAllBoxes' ).on( 'click', function() {
            if ( this.checked ) {
                $( '.selectOneBox' ).each(function() {
                    this.checked = true;
                } );
            } else {
                $( '.selectOneBox' ).each(function() {
                    this.checked = false;
                } );
            }
        } );
    }

    // $( '.js-delete' ).on( 'click', function() {
    //     var data_location = $(this).data('id');

    //     $(this).toggleClass('is-active');

    //     if ( $(this).hasClass('is-active') ) {
    //         $(this).parent().append("<span class='confirm-block'><button class='js-turnoff-btn-delete btn btn-warning'>No</button><a href='posts.php?delete=" + data_location + "' class='btn btn-success'>Yes</a></span>");
    //     } else {
    //        $(this).parent().find('.confirm-block').remove();
    //     }
    // } );

    // $( '.js-turnoff-btn-delete' ).on( 'click', function() {
    //     $(this).parent().parent().removeClass('is-active');
    //     $(this).parent().remove();
    // } );


    var div_box_loader = "<div id='load-screen'><div id='loading'></div></div>";
    $('body').prepend(div_box_loader);

    $('#load-screen').delay(300).fadeOut(200, function() {
        $(this).remove();
    })


    
    
    function loadUsersOnline() {
        $.get("http://localhost/study_php/functions.php?onlineusers=result", function(data) {
            $( '.usersonline' ).text(data);
        } );
    }

    // setInterval( function() {
    //     loadUsersOnline();
    // }, 5000)


    

});

