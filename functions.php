<?php
/*
Basic function 
---------------------------------------------------------------------
*/	
	function cafelite_setup() {
        load_theme_textdomain( 'cafelite', get_template_directory() . '/assets/languages' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'script', 'style', 'search-form' ) );
        add_theme_support( 'custom-background' );
        add_theme_support( 'custom-header' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'align-wide' );
        
        global $content_width;
        if ( ! isset( $content_width ) ) { $content_width = 1920; }

        register_nav_menus( array( 'primary' => esc_html__( 'Main Menu', 'cafelite') ) );

        if (function_exists('register_sidebar')) {
            register_sidebar(array(
                'name' => 'Sidebar Widgets',
                'id'   => 'sidebar-widgets',
                'class'=> 'sidebar-widgets',
                'description'   => 'These are widgets for the sidebar.',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'
            ));
        }
    }
    add_action( 'after_setup_theme', 'cafelite_setup' );

/*
WP Admin styles function 
---------------------------------------------------------------------
*/  

    function adjust_for_admin_bar() {
        if (is_admin_bar_showing()) {
            echo '<style>
                    body {
                        
                    }
                    @media screen and (max-width: 782px) {
                        body {
                            
                        }
                    }
                  </style>';
        }
    }
    add_action('wp_head', 'adjust_for_admin_bar');



/*
Remove frameborder function 
---------------------------------------------------------------------
*/
    function cafelite_remove_frameborder( $html, $url ) {
        if ( strpos( $url, 'youtube.com' ) !== false ) {
        // Replace the frameborder attribute with an empty string.
            $html = str_replace( 'frameborder="0"', '', $html );
        }
        return $html;
    }
    add_filter( 'embed_oembed_html', 'cafelite_remove_frameborder', 10, 2 );


/*
String limit function 
---------------------------------------------------------------------
*/

    function cafelite_string_limit_words($string, $word_limit)
        {
            $words = explode(' ', $string, ($word_limit + 1));
            if(count($words) > $word_limit)
            array_pop($words);
            return implode(' ', $words);
        }


/*
Breadcrumb function 
---------------------------------------------------------------------
*/        

    function get_breadcrumb() {
        echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
        if (is_category() || is_single()) {
            echo "&nbsp;&nbsp;&#47;&nbsp;&nbsp;";
            the_category(' &bull; ');
                if (is_single()) {
                    echo " &nbsp;&nbsp;&#47;&nbsp;&nbsp; ";
                    the_title();
                }
        } elseif (is_page()) {
            echo "&nbsp;&nbsp;&#47;&nbsp;&nbsp;";
            echo the_title();
        } elseif (is_search()) {
            echo "&nbsp;&nbsp;&#47;&nbsp;&nbsp;Search Results for... ";
            echo '"<em>';
            echo the_search_query();
            echo '</em>"';
        }
    }  


/*
Title separator function 
---------------------------------------------------------------------
*/       

    function cafelite_document_title_separator( $sep ) {
        $sep = '|';
        return $sep;
    }
    add_filter( 'document_title_separator', 'cafelite_document_title_separator' );


/*
Title function 
---------------------------------------------------------------------
*/    

    function cafelite_title( $title ) {
        if ( $title == '' ) {
        return '...';
        } else {
        return $title;
        }
    }
    add_filter( 'the_title', 'cafelite_title' );


/*
Read more function 
---------------------------------------------------------------------
*/  
    function cafelite_read_more_link() {
        if ( ! is_admin() ) {
        return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
        }
    }
    add_filter( 'the_content_more_link', 'cafelite_read_more_link' );


/*
Excerpt read more function 
---------------------------------------------------------------------
*/ 
    function cafelite_excerpt_read_more_link( $more ) {
        if ( ! is_admin() ) {
        global $post;
        return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
        }
    }    
    add_filter( 'excerpt_more', 'cafelite_excerpt_read_more_link' );

/*
Block script & style enqueue function 
---------------------------------------------------------------------
*/ 
    function enqueue_block_script_for_editor() {
        $current_screen = get_current_screen();
        if ($current_screen && ($current_screen->post_type === 'page' || $current_screen->post_type === 'post')) {
            wp_enqueue_script('wp-editor');


        }
    }
    add_action('enqueue_block_editor_assets', 'enqueue_block_script_for_editor');


/*
Ping back enqueue function 
---------------------------------------------------------------------
*/

    function cafelite_pingback_header() {
        if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
        }
    }
    add_action( 'wp_head', 'cafelite_pingback_header' );

/*
CSS enqueue function 
---------------------------------------------------------------------
*/
    function cafelite_styles() {
        wp_enqueue_style( 'cafelite-style', get_stylesheet_uri() );
        wp_enqueue_style( 'keycss', get_template_directory_uri() . '/assets/css/keycss.css', true );
        wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', true );

        if ( is_rtl() ) {
            wp_enqueue_style( 'wpcoupon_rtl', get_template_directory_uri() . '/assets/css/rtl.css', true );
        }
    }
    add_action( 'wp_enqueue_scripts', 'cafelite_styles' );

    
/*
JS enqueue function 
---------------------------------------------------------------------
*/ 
    function cafelite_footer_scripts() {

        wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), true );
    }
    add_action( 'wp_footer', 'cafelite_footer_scripts' );


/*
Dashicon Enqueue
---------------------------------------------------------------------
*/

    function inna_add_dashicon_frontend() {
        wp_enqueue_style('dashicons');
    }
    add_action('wp_enqueue_scripts', 'inna_add_dashicon_frontend');


    function inna_add_dashicon_backend() {
        wp_enqueue_style('dashicons');
    }
    add_action('admin_enqueue_scripts', 'inna_add_dashicon_backend');    


/*
Theme Option function 
---------------------------------------------------------------------
*/ 

    if ( class_exists( 'ReduxFramework' ) ) {
        require_once get_template_directory() . '/assets/inc/option-config.php';
    }

    if ( ! function_exists( 'cafelite_get_option' ) ) {
        function cafelite_get_option( $id, $fallback = false, $key = false ) {
            global $st_option;
            if ( ! $st_option ) {
                $st_option = get_option( 'st_options' );
            }
            if ( ! is_array( $st_option ) ) {
                return $fallback;
            }
            if ( $fallback == false ) {
                $fallback = '';
            }
            $output = ( isset( $st_option[ $id ] ) && $st_option[ $id ] !== '' ) ? $st_option[ $id ] : $fallback;
            if ( ! empty( $st_option[ $id ] ) && $key ) {
                $output = $st_option[ $id ][ $key ];
            }
            return $output;
        }
    }


/*
Author image function 
---------------------------------------------------------------------
*/ 
    function display_author_image() {
        global $post;
        $author_id = $post->post_author;
        $author_avatar = get_avatar_url($author_id, array('size' => 45));
        echo '<img src="' . $author_avatar . '" alt="' . get_the_author_meta('display_name', $author_id) . '" />';
    }


/*
Comment function 
---------------------------------------------------------------------
*/ 
    function cafelite_custom_comment_form_defaults( $defaults ) {
        $defaults['title_reply'] = ''; // Leave it empty to remove or add your custom text here
        return $defaults;
    }
    add_filter( 'comment_form_defaults', 'cafelite_custom_comment_form_defaults' );

    
    function cafelite_custom_text_replacements( $translated_text, $text, $domain ) {
        $check_box_text = cafelite_get_option( 'check_box_text', 'cafelite' );
        $comment_text = cafelite_get_option( 'comment_text', 'cafelite' );
        $leave_your_reply_text = cafelite_get_option( 'leave_your_reply_text', 'cafelite' );
        $comment_meta_reply = cafelite_get_option( 'comment_meta_reply', 'cafelite' );
        $comment_meta_post_by = cafelite_get_option( 'comment_meta_post_by', 'cafelite' );
        $comment_meta_at = cafelite_get_option( 'comment_meta_at', 'cafelite' );
        $comment_meta_reply_to = cafelite_get_option( 'comment_meta_reply_to', 'cafelite' );
        $comment_meta_cancel_reply = cafelite_get_option( 'comment_meta_cancel_reply', 'cafelite' );
        $category_text = cafelite_get_option( 'category_text', 'cafelite' );

        $text_replacements = array(
            "Save my name, email, and website in this browser for the next time I comment." => $check_box_text,
            "Comments" => $comment_text,
            "Leave Your Reply" => $leave_your_reply_text,
            "Reply" => $comment_meta_reply,
            "Posted By" => $comment_meta_post_by,
            "at" => $comment_meta_at,
            "Reply to" => $comment_meta_reply_to,
            "Cancel reply" => $comment_meta_cancel_reply,
            "Category:" => $category_text,
        );

        if ( array_key_exists( $text, $text_replacements ) ) {
            $translated_text = $text_replacements[ $text ];
        }

        return $translated_text;
    }
    add_filter( 'gettext', 'cafelite_custom_text_replacements', 20, 3 );

/*
Include files
---------------------------------------------------------------------
*/ 
    require_once( get_template_directory()  . '/assets/inc/comments-function.php');
    require_once( get_template_directory()  . '/assets/inc/activation.php');



/*
Disable page title
---------------------------------------------------------------------
*/ 
function add_disable_title_meta_box() {
    add_meta_box(
        'disable_title_meta_box', 
        'Disable Title', 
        'disable_title_meta_box_callback', 
        'page', 
        'side' 
    );
}
add_action('add_meta_boxes', 'add_disable_title_meta_box');


function disable_title_meta_box_callback($post) {
    $value = get_post_meta($post->ID, '_disable_page_title', true);
    ?>
    <label for="disable_page_title">
        <input type="checkbox" name="disable_page_title" id="disable_page_title" value="1" <?php checked($value, '1'); ?> />
        <?php _e('Disable Page Title', 'your-text-domain'); ?>
    </label>
    <?php
}


function save_disable_title_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['disable_page_title'])) return;
    update_post_meta($post_id, '_disable_page_title', $_POST['disable_page_title']);
}
add_action('save_post', 'save_disable_title_meta_box');


?>