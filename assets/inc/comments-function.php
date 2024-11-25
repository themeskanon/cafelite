<?php if(!function_exists('cafelite_comment')):

        function cafelite_comment($comment, $args, $depth)
        {
            $GLOBALS['comment'] = $comment;
            switch ( $comment->comment_type ) :
                case 'pingback' :
                case 'trackback' :
                // Display trackbacks differently than normal comments.
            ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p>
                    <?php echo esc_html__( 'Pingback:', 'cafelite' ); ?> 
                    <?php comment_author_link(); ?> 
                    <?php edit_comment_link( esc_html__( '(Edit)', 'cafelite' ), '<span class="edit-link">', '</span>' ); ?> 
                </p>
            <?php
                break;
                default :
                global $post;
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment-body media row">
                    <div class="comment-avartar">
                        <?php
                            echo get_avatar( $comment, $args['avatar_size'] );
                        ?>
                    </div>

                    <div class="comment-context media-body">
                        <div class="comment-content">
                            <?php comment_text(); ?>
                        </div>
                        <div class="comment-head">
                            <span><?php echo esc_html__( 'Posted By', 'cafelite' ); ?></span>
                            <?php
                                printf( '<span class="comment-author">%1$s</span>',
                                    get_comment_author_link());
                            ?>
                            <span><?php echo esc_html__( 'at', 'cafelite' ); ?></span>
                            <span class="comment-date"><?php echo get_comment_date() ?></span>

                            <?php edit_comment_link( esc_html__( 'Edit', 'cafelite' ), '<span class="edit-link">', '</span>' ); ?>
                            <span class="comment-reply">
                                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'cafelite' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            </span>
                        </div>

                        <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php esc_html__( 'Your comment is awaiting moderation.', 'cafelite' ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
                break;
            endswitch; 
        }
    endif;


// Function to modify the "Leave a Reply" heading in comment form
function modify_comment_form_title( $defaults ) {
    $defaults['title_reply'] = esc_html__( 'Leave Your Reply', 'cafelite' );
    return $defaults;
}
add_filter( 'comment_form_defaults', 'modify_comment_form_title' );

// Function to modify the "Logged in" message in comment form
function modify_logged_in_message( $logged_in_text ) {
    $user = wp_get_current_user();
    $message = sprintf(
        __( 'Logged in as %s. <a href="%s">Edit your profile</a>. <a href="%s">Log out?</a>', 'cafelite' ),
        $user->display_name,
        get_edit_user_link(),
        wp_logout_url()
    );

    // Wrap the message in <p> tags
    $message = '<p class="logged-in-as">' . $message . '</p>';

    return $message;
}
add_filter( 'comment_form_logged_in', 'modify_logged_in_message' );
