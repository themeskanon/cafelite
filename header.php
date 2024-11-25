<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
	
	<style>
        <?php 
            $container = cafelite_get_option( 'container' );
            $container_md = cafelite_get_option( 'container_md' );
            $container_sm = cafelite_get_option( 'container_sm' );
        ?>
		.container{
			width: <?php echo $container;?>;
		}
        .container .alignwide .inner-container{
            width: <?php echo $container;?>;
            margin: 0 auto;
        }
        .container .inner-container{
            width: 100%;
            padding: 0 30px;
        }
        @media screen and (max-width: <?php echo $container;?>) {
            .container{
                width: 100%;
                padding: 0 20px;
            }
            .inner-container{
                width: 100%;
                padding: 0 20px;
            }
            .container .alignwide .inner-container, .container .alignfull .inner-container{
                width: 100%;
                padding: 0 20px;
            }
        }
        @media screen and (max-width: <?php echo $container_md;?>) {
            .container{
                width: 100%;
            }
            .inner-container{
                width: 100%;
            }
            .container .alignwide .inner-container, .container .alignfull .inner-container{
                width: 100%;
            }
        }
        @media screen and (max-width: <?php echo $container_sm;?>) {
            .container{
                width: 100%;                
            }
            .inner-container{
                width: 100%;
            }
            .container .alignwide .inner-container, .container .alignfull .inner-container{
                width: 100%;
                padding: 0 20px;
            }
        }
	</style>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<div class="wrapper">
        <div class="page-wrap">
    		<div id="mySidebar" class="sidebar">
    		  	<a id="closebtn" class="closebtn">
    		  		<svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#fff">
    					<path d="m334-318 146-146 146 146 16-16-146-146 146-146-16-16-146 146-146-146-16 16 146 146-146 146 16 16Zm146.3 186q-72.21 0-135.43-27.52-63.22-27.53-110.62-74.85-47.4-47.33-74.82-110.26Q132-407.57 132-479.7q0-72.21 27.52-135.93 27.53-63.72 74.85-110.87 47.33-47.15 110.26-74.32Q407.57-828 479.7-828q72.21 0 135.94 27.39 63.72 27.39 110.87 74.35 47.14 46.96 74.31 110.39Q828-552.43 828-480.3q0 72.21-27.27 135.43-27.28 63.22-74.35 110.62-47.08 47.4-110.51 74.82Q552.43-132 480.3-132Zm-.37-22q135.57 0 230.82-95.18Q806-344.37 806-479.93q0-135.57-95.18-230.82Q615.63-806 480.07-806q-135.57 0-230.82 95.18Q154-615.63 154-480.07q0 135.57 95.18 230.82Q344.37-154 479.93-154Zm.07-326Z"/>
    				</svg>
    		  	</a>
    		  	<div class="branding">
    				<?php if ( cafelite_get_option('site_logo', false, 'url') != '' ) { ?>
                        <div class="site-info">
                            <div class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-permalink" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home">
    								<img src="<?php echo cafelite_get_option('site_logo', false, 'url'); ?>" alt="<?php echo get_bloginfo( 'name' ) ?>" />
                                </a>
                            </div>
                        </div>
    				<?php } ?>    
                </div>	

                <nav class="header-menu">
                    <?php
                        wp_nav_menu(array( 
                            'menu_id'           => 'menu-menu',
                            'menu_class'        => 'menu-menu',
                            'link_before'       => '<span>',
                            'link_after'        => '</span>',
                            'theme_location'    => 'primary',
                        )); 
                    ?>
                </nav> 	

                <div class="widget-wrap">
                    <?php 
                        if (is_active_sidebar('sidebar-widgets')) : 
                            dynamic_sidebar('sidebar-widgets');
                        endif; 
                    ?>

                </div>    
    		</div>
    		<div id="main" class="full-content">
    			<button class="openbtn" id="openbtn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000">
                        <path d="M172-278v-22h616v22H172Zm0-191v-22h616v22H172Zm0-191v-22h616v22H172Z"/>
                    </svg>
                </button> 
                <div class="content-wrap"> 