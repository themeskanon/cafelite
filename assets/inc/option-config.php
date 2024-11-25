<?php

/**
 * Theme Options Config
 */

if ( ! class_exists( 'inna_Theme_Options_Config' ) ) {

	class inna_Theme_Options_Config {

		public $args = array();
		public $sections = array();
		public $theme; 
		public $ReduxFramework;

		public function __construct() {

			if ( ! class_exists( 'ReduxFramework' ) ) {
				return;
			}
			$this->initSettings();
		}


		public function initSettings() {

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}

			$this->args = apply_filters( 'st_redux_theme_options_args', $this->args );

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id'      => 'redux-help-tab-1',
				'title'   => esc_html__( 'Theme Information 1', 'cafelite' ),
				'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'cafelite' ),
			);

			$this->args['help_tabs'][] = array(
				'id'      => 'redux-help-tab-2',
				'title'   => esc_html__( 'Theme Information 2', 'cafelite' ),
				'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'cafelite' ),
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'cafelite' );
		}

		/**
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'           => 'st_options',
				// This is where your data is stored in the database and also becomes your global variable name.
				'display_name'       => $theme->get( 'Name' ),
				// Name that appears at the top of your panel
				'display_version'    => false,
				// Version that appears at the top of your panel
				'menu_type'          => 'menu', // submenu , menu
				// Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     => false,
				// Show the sections below the admin menu item or not
				'menu_title'         => esc_html__( 'Cafelite', 'cafelite' ),
				'page_title'         => esc_html__( 'Cafelite', 'cafelite' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'     => '',
				// Must be defined to add google fonts to the typography module
				'async_typography'   => false,
				// Use a asynchronous font on the front end or font string
				'admin_bar'          => false,
				// Show the panel pages on the admin bar
				'global_variable'    => 'st_option',
				// Set a different name for your global variable other than the opt_name
				'dev_mode'           => false,
				// Show the time the page took to load, etc
				'customizer'         => true,
				// Enable basic customizer support
				// OPTIONAL -> Give you extra features
				 'page_priority'      => 65,
				// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'        => 'themes.php', // themes.php
				// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'   => 'manage_options',
				// Permissions needed to access the options panel.
				'menu_icon'          => '',
				// Specify a custom URL to an icon
				'last_tab'           => '',
				// Force your panel to always open to a specific tab (by id)
				'page_icon'          => 'icon-themes',
				// Icon displayed in the admin panel next to your menu_title
				'page_slug'          => 'cafelite_options',
				// Page slug used to denote the panel
				'save_defaults'      => true,
				// On load save the defaults to DB before user clicks save or not
				'default_show'       => false,
				// If true, shows the default value next to each field that is not the default value.
				'default_mark'       => '',
				// What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export' => true,
				// Shows the Import/Export panel when not used as a field.
				// CAREFUL -> These options are for advanced use only
				'transient_time'     => 60 * MINUTE_IN_SECONDS,

				'output'             => true,
				// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'         => true,
				// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				'footer_credit'     => ' ',
				// Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'           => '',
				// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'system_info'        => false,
				// REMOVE
				// HINTS
				'hints'              => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				),
			);

			// Panel Intro text -> before the form
			if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
				if ( ! empty( $this->args['global_variable'] ) ) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace( '-', '_', $this->args['opt_name'] );
				}
				// $this->args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'cafelite' ), $v );
			} else {
				// $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'cafelite' );
			}

			// Add content after the form.
			// $this->args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'cafelite' );
		}

		public function setSections() {

			/*
			--------------------------------------------------------*/
			/*
			 GENERAL SETTINGS
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'General', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-cog el-icon-large',
				'submenu' => true, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
				'fields' => array(

					array(
						'id'       => 'site_logo',
						'url'      => false,
						'type'     => 'media',
						'title'    => esc_html__( 'Site Logo', 'cafelite' ),
						'default'  => array( 'url' => get_template_directory_uri() . '/assets/images/logo.png' ),
						'subtitle' => esc_html__( 'Upload your logo here.', 'cafelite' ),
					),
					
					array(
						'id'      => 'container',
						'type'    => 'text',
						'title'   => esc_html__( 'Large Screen Container Width', 'cafelite' ),
						'default'  => '1200px',
					),
					
					array(
						'id'      => 'container_md',
						'type'    => 'text',
						'title'   => esc_html__( 'Medium Screen Container Width', 'cafelite' ),
						'default'  => '768px',
					),
					
					array(
						'id'      => 'container_sm',
						'type'    => 'text',
						'title'   => esc_html__( 'Small Screen Container Width', 'cafelite' ),
						'default'  => '575px',
					),
				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 STYLING
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Styling', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-idea',
				'submenu' => true,
				'fields' => array(

					array(
						'id'       => 'style_primary',
						'type'     => 'color',
						'title'    => esc_html__( 'Primary', 'cafelite' ),
						'default'  => '#ff6a1a',
						'output'    => array(
							'background-color' => '
								.openbtn:hover, .wp-block-search__button
                            ',

							'color'  => '
    							.menu-menu li.current_page_item a
                                ',
							'border-color' => '
								.wp-block-search__button
                            ',
							'border-top-color' => '
								
                            ',
							'border-left-color' => '
								
							',
							'border-bottom-color' => '
								
							',
							'border-right-color' => '
								
							',
						),
					),

					array(
						'id'       => 'style_link_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Link text color', 'cafelite' ),
						'default'  => '#ff6a1a',
						'output'    => array(
							
							'color'  => '
    							
                                ',
						),
					),

					array(
						'id'       => 'style_link_hover_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Link text hover color', 'cafelite' ),
						'default'  => '#ff6a1a',
						'output'    => array(
							
							'color'  => '
    							.widget ul li a:hover
                                ',
						),
					),

					array(
						'id'       => 'style_button_bg',
						'type'     => 'color',
						'title'    => esc_html__( 'Button background color', 'cafelite' ),
						'default'  => '#ff6a1a',
						'output'    => array(
							
							'background-color'  => '
    							.openbtn
                                ',
						),
					),

					array(
						'id'       => 'style_button_bg_hover',
						'type'     => 'color',
						'title'    => esc_html__( 'Button background hover color', 'cafelite' ),
						'default'  => '#ff5400',
						'output'    => array(
							
							'background-color'  => '
    							.openbtn:hover, .wp-block-search__button:hover
                                ',
						),
					),

					array(
						'id'       => 'style_button_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Button text color', 'cafelite' ),
						'default'  => '#2b2e31',
						'output'    => array(
							
							'color'  => '
    							.openbtn, .wp-block-search__button
                                ',
                            'fill'  => '
    							.openbtn svg
                                ',    
						),
					),

					array(
						'id'       => 'style_button_hover_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Button text hover color', 'cafelite' ),
						'default'  => '#2b2e31',
						'output'    => array(
							
							'color'  => '
    							.openbtn:hover, .wp-block-search__button:hover
                                ',
						),
					),

					array(
						'id'       => 'style_body_bg',
						'type'     => 'background',
						'title'    => esc_html__( 'Body background', 'cafelite' ),
						'default'  => array(
							'background-color' => '#ffffff',
						),
						'output' => array( 'body' ),
					),
				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 HEADER
			/*--------------------------------------------------------*/

			$this->sections[] = array(
				'title'  => esc_html__( 'Header', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-file',
				'submenu' => true,
				'fields' => array(

					array(
						'id'       => 'header_custom_color',
						'type'     => 'switch',
						'title'    => esc_html__( 'Custom your header style?', 'cafelite' ),
						'default'  => true,
					),

					array(
						'id'       => 'header_bg',
						'type'     => 'background',
						'output'   => array( '.header' ),
						'title'    => esc_html__( 'Header Background', 'cafelite' ),
						'required' => array( 'header_custom_color', '=', true ),
						'default'  => array(
							'background-color' => '#282828',
						),
					),

				
					array(
						'id'       => 'header_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Color', 'cafelite' ),
						'required' => array( 'header_custom_color', '=', true ),
						'default'  => '#ffffff',
						'output'   => array(
							
							'color'=> '
    								.inner_header,  .inner_header a, .sm_header_inner, .sm_header_menu .single-menu a
                                	
                                	',
						
						),
					),

				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 TYPOGRAPHY
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'      => esc_html__( 'Typography', 'cafelite' ),
				'header'     => '',
				'desc'       => '',
				'icon_class' => 'el-icon-large',
				'icon'       => 'el-icon-font',
				'submenu'    => true,
				'fields'     => array(
					array(
						'id'             => 'font_body',
						'type'           => 'typography',
						'title'          => esc_html__( 'Body', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'font-weight'    => false,
						'all_styles'     => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => true,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => false,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'body, p, .wp-block-search__button, .wp-block-search__input' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for your main body text.', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Happy Monkey'
                        ),
					),
					array(
						'id'             => 'font_heading1',
						'type'           => 'typography',
						'title'          => esc_html__( 'Heading 1', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'all_styles'     => false,
						'font-weight'    => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => false,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'h1' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for heading like h1', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Sacramento'
                        ),
					),

					array(
						'id'             => 'font_heading2',
						'type'           => 'typography',
						'title'          => esc_html__( 'Heading 2', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'all_styles'     => false,
						'font-weight'    => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => false,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'h2' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for heading like h2', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Sacramento'
                        ),
					),

					array(
						'id'             => 'font_heading3',
						'type'           => 'typography',
						'title'          => esc_html__( 'Heading 3', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'all_styles'     => false,
						'font-weight'    => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => false,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'h3' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for heading like h3', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Happy Monkey'
                        ),
					),

					array(
						'id'             => 'font_heading4',
						'type'           => 'typography',
						'title'          => esc_html__( 'Heading 4', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'all_styles'     => false,
						'font-weight'    => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => false,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'h4' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for heading like h4', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Happy Monkey'
                        ),
					),

					array(
						'id'             => 'font_heading5',
						'type'           => 'typography',
						'title'          => esc_html__( 'Heading 5', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'all_styles'     => false,
						'font-weight'    => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => false,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'h5' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for heading like h5', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Happy Monkey'
                        ),
					),

					array(
						'id'             => 'font_heading6',
						'type'           => 'typography',
						'title'          => esc_html__( 'Heading 6', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => true,
						'all_styles'     => false,
						'font-weight'    => false,
						'font-style'     => false,
						'subsets'        => false,
						'font-size'      => false,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'output'         => array( 'h6' ),
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Select custom font for heading like h6', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Happy Monkey'
                        ),
					),
				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 MENU BAR
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Menu Bar', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-credit-card',
				'submenu' => true,
				'fields' => array(
					array(
						'id'             => 'primary_menu_typography',
						'type'           => 'typography',
						'output'         => array(
							'.menu-menu li a',
						),
						'title'          => esc_html__( 'Primary Menu Typography', 'cafelite' ),
						'compiler'       => true,
						'google'         => true,
						'font-backup'    => false,
						'text-align'     => false,
						'text-transform' => true,
						'font-weight'    => true,
						'all_styles'     => false,
						'font-style'     => true,
						'subsets'        => true,
						'font-size'      => true,
						'line-height'    => false,
						'word-spacing'   => false,
						'letter-spacing' => true,
						'color'          => true,
						'preview'        => true,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Custom typography for primary menu.', 'cafelite' ),
						'default'        => array(
                            'font-family' => 'Happy Monkey',
                            'font-size'   => '18px',
                        ),
					),
				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 PAGE
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Page', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-file',
				'submenu' => true,
				'fields' => array(

					array(
						'id'      => 'page_header',
						'title'   => esc_html__( 'Page header', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'on',
						'options' => array(
							'on'    => esc_html__( 'Show page header', 'cafelite' ),
							'off'   => esc_html__( 'Hide page header ', 'cafelite' ),
						),
					),

					array(
						'id'      => 'page_header_breadcrumb',
						'type'    => 'switch',
						'title'   => esc_html__( 'Page breadcrumb', 'cafelite' ),
						'required' => array( 'page_header', '=', array( 'on' ) ),
						'default'  => true,
						'desc'  => esc_html__( 'Check this if you want to show breadcrumb. NOTE: you must install plugin Breadcrumb Navxt to use this function.', 'cafelite' ),
					),

					array(
						'id'       => 'page_header_alignment',
						'type'     => 'select',
						'default'  => 'center',
						'title'    => esc_html__( 'Page header alignment', 'cafelite' ),
						'required' => array( 'page_header', '=', array( 'on' ) ),
						'options'  => array(
							'left'      => esc_html__( 'Left', 'cafelite' ),
							'center'    => esc_html__( 'Center', 'cafelite' ),
							'right'     => esc_html__( 'Right', 'cafelite' ),
						),
					),

					array(
						'id'      => 'page_header_height',
						'type'    => 'text',
						'title'   => esc_html__( 'Page header size', 'cafelite' ),
						'required' => array( 'page_header', '=', array( 'on' ) ),
						'default'  => '150px',
					),

					array(
						'id'       => 'page_header_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Page header text color', 'cafelite' ),
						'required' => array( 'page_header', '=', array( 'on' ) ),
						'default'  => '#ffffff',
						'output'    => array(
							
							'color'  => '
								.page-h h2.entry-title, .page-h .breadcrumb, .page-h .breadcrumb a
                                ',
						),
					),
				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 BLOG
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Blog', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-blogger',
				'submenu' => true,
				'fields' => array(

					array(
						'id'      => 'blog_header',
						'title'   => esc_html__( 'Blog header', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'on',
						'options' => array(
							'on'    => esc_html__( 'Show page header', 'cafelite' ),
							'off'   => esc_html__( 'Hide page header ', 'cafelite' ),
						),
					),

					array(
						'id'       => 'blog_header_alignment',
						'type'     => 'select',
						'default'  => 'center',
						'title'    => esc_html__( 'Blog header alignment', 'cafelite' ),
						'required' => array( 'blog_header', '=', array( 'on' ) ),
						'options'  => array(
							'left'      => esc_html__( 'Left', 'cafelite' ),
							'center'    => esc_html__( 'Center', 'cafelite' ),
							'right'     => esc_html__( 'Right', 'cafelite' ),
						),
					),

					array(
						'id'      => 'blog_header_height',
						'type'    => 'text',
						'title'   => esc_html__( 'Blog header size', 'cafelite' ),
						'required' => array( 'blog_header', '=', array( 'on' ) ),
						'default'  => '150px',
					),

					array(
						'id'      => 'blog_header_title',
						'type'    => 'text',
						'title'   => esc_html__( 'Custom blog title', 'cafelite' ),
						'required' => array( 'blog_header', '=', array( 'on' ) ),
						'default'  => 'Our Blog',
					),

					array(
						'id'       => 'archive_title',
						'type'     => 'text',
						'title'    => esc_html__( 'Archive Page Title', 'cafelite' ),
						'subtitle' => esc_html__( 'If you want to change the text title of the Archive Page then use this option .', 'cafelite' ),
						'default'  => 'Archive',
						'required' => array( 'blog_header', '=', array( 'on' ) ),
					),

					array(
						'id'      => 'blog_header_des',
						'type'    => 'textarea',
						'title'   => esc_html__( 'Custom blog description', 'cafelite' ),
						'required' => array( 'blog_header', '=', array( 'on' ) ),
						'default'  => 'Proin ultricies, nisl in imperdiet interdum, est tortor viverra neque, eu molestie dolor lacus sollicitudin sem. Aenean fringilla suscipit justo. Curabitur sagittis quam dolor',
					),

					array(
						'id'       => 'blog_header_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.blog-header-content h1, .blog-header-content p' ),
						'title'    => esc_html__( 'Blog header text color', 'cafelite' ),
						'required' => array( 'blog_header', '=', array( 'on' ) ),
						'default'  => '#ffffff',
					),

					array(
						'id'       => 'blog_header_bg',
						'type'     => 'background',
						'output'   => array( '.blog-header' ),
						'title'    => esc_html__( 'Blog header background', 'cafelite' ),
						'required' => array( 'blog_header', '=', array( 'on' ) ),
						'default'  => array(
							'background-color' => '#393939',
						),
					),

					array(
						'id'       => 'blog_post_read_more_text',
						'type'     => 'text',
						'title'    => esc_html__( 'Read more text', 'cafelite' ),
						'subtitle' => esc_html__( 'Add your read more text if you want to change the text.', 'cafelite' ),
						'default'  => 'Read More',
					),

					array(
						'id'   => 'divider_1',
						'desc' => '',
						'type' => 'divide',
					),

					array(
						'id'      => 'search_header',
						'title'   => esc_html__( 'Search header', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'on',
						'options' => array(
							'on'    => esc_html__( 'Enable', 'cafelite' ),
							'off'   => esc_html__( 'Disable', 'cafelite' ),
						),
					),

					array(
						'id'       => 'search_title',
						'type'     => 'text',
						'title'    => esc_html__( 'Search Page Title', 'cafelite' ),
						'subtitle' => esc_html__( 'If you want to change the text title of the Search Page then use this option .', 'cafelite' ),
						'default'  => 'Search Page',
						'required' => array( 'search_header', '=', array( 'on' ) ),
					),

					array(
						'id'       => 'search_description',
						'type'     => 'textarea',
						'title'    => esc_html__( 'Search Page Description', 'cafelite' ),
						'subtitle' => esc_html__( 'If you want to change the text of description for the Search Page then use this option .', 'cafelite' ),
						'default'  => 'Proin ultricies, nisl in imperdiet interdum, est tortor viverra neque, eu molestie dolor lacus sollicitudin sem. Aenean fringilla suscipit justo. Curabitur sagittis quam dolor',
						'required' => array( 'search_header', '=', array( 'on' ) ),
					),

					array(
						'id'       => 'search_title_label',
						'type'     => 'text',
						'title'    => esc_html__( 'Search Form label', 'cafelite' ),
						'subtitle' => esc_html__( 'If you want to change the label of text of the Search Form then use this option.', 'cafelite' ),
						'default'  => 'Search for:',
					),

					array(
						'id'       => 'search_title_placeholder',
						'type'     => 'text',
						'title'    => esc_html__( 'Search Form placeholder', 'cafelite' ),
						'subtitle' => esc_html__( 'If you want to change the placeholder of text of the Search Form then use this option.', 'cafelite' ),
						'default'  => 'Search',
					),

					array(
						'id'   => 'divider_2',
						'desc' => '',
						'type' => 'divide',
					),

					array(
						'id'      => 'author_header',
						'title'   => esc_html__( 'Author header', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'on',
						'options' => array(
							'on'    => esc_html__( 'Enable', 'cafelite' ),
							'off'   => esc_html__( 'Disable', 'cafelite' ),
						),
					),

					array(
						'id'       => 'author_description',
						'type'     => 'textarea',
						'title'    => esc_html__( 'Author Page Description', 'cafelite' ),
						'subtitle' => esc_html__( 'If you want to change the text of description for the Author Page then use this option .', 'cafelite' ),
						'default'  => 'Proin ultricies, nisl in imperdiet interdum, est tortor viverra neque, eu molestie dolor lacus sollicitudin sem. Aenean fringilla suscipit justo. Curabitur sagittis quam dolor',
						'required' => array( 'author_header', '=', array( 'on' ) ),
					),

				),
			);
			

			/*
			--------------------------------------------------------*/
			/*
			 BLOG SINGLE
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Blog Single', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-blogger',
				'submenu' => true,
				'fields' => array(

					array(
						'id'      => 'single_blog_header',
						'title'   => esc_html__( 'Blog details header', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'on',
						'options' => array(
							'on'    => esc_html__( 'Show blog details', 'cafelite' ),
							'off'   => esc_html__( 'Hide blog details ', 'cafelite' ),
						),
					),

					array(
						'id'       => 'single_blog_header_alignment',
						'type'     => 'select',
						'default'  => 'center',
						'title'    => esc_html__( 'Blog details header alignment', 'cafelite' ),
						'required' => array( 'single_blog_header', '=', array( 'on' ) ),
						'options'  => array(
							'left'      => esc_html__( 'Left', 'cafelite' ),
							'center'    => esc_html__( 'Center', 'cafelite' ),
							'right'     => esc_html__( 'Right', 'cafelite' ),
						),
					),

					array(
						'id'      => 'single_blog_header_height',
						'type'    => 'text',
						'title'   => esc_html__( 'Blog details header size', 'cafelite' ),
						'required' => array( 'single_blog_header', '=', array( 'on' ) ),
						'default'  => '150px',
					),

					array(
						'id'      => 'single_blog_header_title',
						'type'    => 'text',
						'title'   => esc_html__( 'Custom Blog details header title', 'cafelite' ),
						'required' => array( 'single_blog_header', '=', array( 'on' ) ),
						'default'  => 'Blog Details',
					),

					array(
						'id'      => 'single_blog_header_des',
						'type'    => 'textarea',
						'title'   => esc_html__( 'Custom Blog details header description', 'cafelite' ),
						'required' => array( 'single_blog_header', '=', array( 'on' ) ),
						'default'  => 'Proin ultricies, nisl in imperdiet interdum, est tortor viverra neque, eu molestie dolor lacus sollicitudin sem. Aenean fringilla suscipit justo. Curabitur sagittis quam dolor',
					),

					array(
						'id'       => 'single_blog_header_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.blog-header-content h1, .blog-header-content p' ),
						'title'    => esc_html__( 'Blog details header text color', 'cafelite' ),
						'required' => array( 'single_blog_header', '=', array( 'on' ) ),
						'default'  => '#ffffff',
					),

					array(
						'id'       => 'single_blog_header_bg',
						'type'     => 'background',
						'output'   => array( '.single-blog-header' ),
						'title'    => esc_html__( 'Blog details header background', 'cafelite' ),
						'required' => array( 'single_blog_header', '=', array( 'on' ) ),
						'default'  => array(
							'background-color' => '#393939',
						),
					),

					array(
						'id'       => 'post_title_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Post title color', 'cafelite' ),
						'default'  => '#000000',
						'output'    => array(
							
							'color'  => '
    							.single-post-title .post-title a, .single-post-title .post-title a:hover
                                ',
						),
					),

					array(
						'id'      => 'single_blog_sidebar',
						'title'   => esc_html__( 'Blog single sidebar', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'no-sidebar',
						'options' => array(
							'left'    		=> esc_html__( 'Left Sidebar', 'cafelite' ),
							'right'   		=> esc_html__( 'Right Sidebar ', 'cafelite' ),
							'no-sidebar'   	=> esc_html__( 'No Sidebar ', 'cafelite' ),
						),
					),

					array(
						'id'      => 'single_post_container_width',
						'type'    => 'text',
						'title'   => esc_html__( 'Blog details container size', 'cafelite' ),
						'required' => array( 'single_blog_sidebar', '=', array( 'no-sidebar' ) ),
						'default'  => '791px',
					),

					array(
						'id'      => 'category_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Category: text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Category: form the comments template.', 'cafelite' ),
						'default'  => 'Category:',
					),


				),
			);

			/*
			--------------------------------------------------------*/
			/*
			 FOOTER
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Footer', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-photo',
				'submenu' => true,
				'fields' => array(

					array(
						'id'       => 'before_footer_heading',
						'type'     => 'text',
						'title'    => esc_html__( 'Before footer title', 'cafelite' ),
						'subtitle' => esc_html__( 'Add the section title of the Before Footer section.', 'cafelite' ),
						'default'  => 'You may connect with us',
					),


					array(
						'id'       => 'before_footer',
						'type'     => 'editor',
						'title'    => esc_html__( 'Before footer', 'cafelite' ),
						'subtitle' => esc_html__( 'Note: This field only display on homepage', 'cafelite' ),
						'default'  => '311 Beacon Road, Bradford, West Yorkshire, BD6 3DQ, United Kingdom.',
					),

					array(
						'id'       => 'before_footer_bg',
						'type'     => 'background',
						'output'   => array( '.footer-sidebar' ),
						'title'    => esc_html__( 'Background of before footer', 'cafelite' ),
						'default'  => array(
							'background-color' => '#282828',
						),
					),

					array(
						'id'       => 'before_footer_bg_text_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.foo-heading, .foo-address-text, foo-address-text p' ),
						'title'    => esc_html__( 'Before footer text color', 'cafelite' ),
						'default'  => '#ffffff',
					),
					array(
						'id'       => 'before_footer_bg_link_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( 'foo-address-text a' ),
						'title'    => esc_html__( 'Before footer text link color', 'cafelite' ),
						'default'  => '#ffffff',
					),

					array(
						'id'       => 'before_footer_bg_link_color_hover',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( 'foo-address-text a:hover' ),
						'title'    => esc_html__( 'Before footer text link Hover color', 'cafelite' ),
						'default'  => '#ffffff',
					),

					array(
						'id'       => 'footer_social_link',
						'type'     => 'switch',
						'title'    => esc_html__( 'Footer Social URL', 'cafelite' ),
						'default'  => true,
					),

					array(
						'id'       => 'inna_fb_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter your facebook social URL in here.', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#',
					),

					array(
						'id'       => 'inna_tw_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter your twitter social URL in here.', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#',
					),

					array(
						'id'       => 'inna_ins_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter your instagram social URL in here.', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#',
					),

					array(
						'id'       => 'inna_linkedin_link',
						'type'     => 'text',
						'title'    => esc_html__( 'LinkedIn', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter your linkedIn social URL in here.', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#',
					),

					array(
						'id'       => 'inna_pinterest_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter your Pinterest social URL in here.', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#',
					),

					array(
						'id'       => 'inna_yt_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Youtube', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter your youtube social URL in here.', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#',
					),

					array(
						'id'       => 'inna_social_link_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.social a' ),
						'title'    => esc_html__( 'Social icon color', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#ff6a1a',
					),

					array(
						'id'       => 'inna_social_link_color_hover',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.social a:hover' ),
						'title'    => esc_html__( 'Social icon hover color', 'cafelite' ),
						'required' => array( 'footer_social_link', '=', true ),
						'default'  => '#ff6a1a',
					),
					
					array(
						'id'       => 'footer_copyright',
						'type'     => 'textarea',
						'title'    => esc_html__( 'Footer copyright', 'cafelite' ),
						'subtitle' => esc_html__( 'Enter the copyright section text.', 'cafelite' ),
					),

					array(
						'id'       => 'footer_copyright_color',
						'type'     => 'switch',
						'title'    => esc_html__( 'Footer copyright style', 'cafelite' ),
						'default'  => true,
					),
					array(
						'id'       => 'footer_copyright_bg',
						'type'     => 'background',
						'output'   => array( '.copyright' ),
						'title'    => esc_html__( 'Footer copyright background', 'cafelite' ),
						'required' => array( 'footer_copyright_color', '=', true ),
						'default'  => array(
							'background-color' => '#ffffff',
						),
					),
					array(
						'id'       => 'footer_copyright_text_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.copyright' ),
						'title'    => esc_html__( 'Footer Text Color', 'cafelite' ),
						'default'  => '#111111',
						'required' => array( 'footer_copyright_color', '=', true ),
					),
					array(
						'id'       => 'footer_copyright_link_color',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.copyright a' ),
						'title'    => esc_html__( 'Footer Link Color', 'cafelite' ),
						'default'  => '#ff6a1a',
						'required' => array( 'footer_copyright_color', '=', true ),
					),
					array(
						'id'       => 'footer_copyright_link_color_hover',
						'type'     => 'color',
						'compiler' => true,
						'output'   => array( '.copyright a' ),
						'title'    => esc_html__( 'Footer Link Color Hover', 'cafelite' ),
						'default'  => '#ff6a1a',
						'required' => array( 'footer_copyright_color', '=', true ),
					),

					array(
						'id'       => 'enable_footer_author',
						'type'     => 'switch',
						'title'    => esc_html__( 'Enable theme author links.', 'cafelite' ),
						'default'  => true,
					),
				),
			);

			
			/*
			--------------------------------------------------------*/
			/*
			 Comments 
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Comment', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-comment',
				'submenu' => true,
				'fields' => array(

					array(
						'id'      => 'name_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Name Text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text name Comments form the comments template.', 'cafelite' ),
						'default'  => 'Name',
					),

					array(
						'id'      => 'mail_text',
						'type'    => 'text',
						'title'   => esc_html__( 'E-mail Text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text mail Comments form the comments template.', 'cafelite' ),
						'default'  => 'E-Mail',
					),

					array(
						'id'      => 'website_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Website URL Text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Website URL Comments form the comments template.', 'cafelite' ),
						'default'  => 'Website URL',
					),

					array(
						'id'      => 'leave_your_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Leave your text', 'cafelite' ),
						'subtitle' => esc_html__( 'Change text Leave your text Comments form the comments template.', 'cafelite' ),
						'default'  => 'Leave your text',
					),

					array(
						'id'      => 'check_box_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Check box text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Check box text Comments form the comments template.', 'cafelite' ),
						'default'  => 'Save my name, email, and website in this browser for the next time I comment.',
					),

					array(
						'id'      => 'submit_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Submit Your Comment Text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Submit Your Comment Comments form the comments template.', 'cafelite' ),
						'default'  => 'Submit Your Comment',
					),


					array(
						'id'      => 'comment_meta_reply',
						'type'    => 'text',
						'title'   => esc_html__( 'Reply Text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Comments form the comments template.', 'cafelite' ),
						'default'  => 'Reply',
					),

					array(
						'id'      => 'comment_meta_post_by',
						'type'    => 'text',
						'title'   => esc_html__( 'Posted By Text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Comments form the comments template.', 'cafelite' ),
						'default'  => 'Posted By',
					),

					array(
						'id'      => 'comment_meta_at',
						'type'    => 'text',
						'title'   => esc_html__( 'At text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Comments form the comments template.', 'cafelite' ),
						'default'  => 'at',
					),

					array(
						'id'      => 'comment_meta_reply_to',
						'type'    => 'text',
						'title'   => esc_html__( 'Reply to text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Reply to form the comments template.', 'cafelite' ),
						'default'  => 'Reply to',
					),

					array(
						'id'      => 'comment_meta_cancel_reply',
						'type'    => 'text',
						'title'   => esc_html__( 'Cancel reply text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Cancel reply form the comments template.', 'cafelite' ),
						'default'  => 'Cancel reply',
					),

					array(
						'id'   => 'divider_2',
						'desc' => '',
						'type' => 'divide',
					),

					array(
						'id'      => 'comment_text',
						'type'    => 'text',
						'title'   => esc_html__( 'Comment text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Comments form the comments template.', 'cafelite' ),
						'default'  => 'Comments',
					),

					array(
						'id'      => 'comment_navigation',
						'type'    => 'text',
						'title'   => esc_html__( 'Comment navigation text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Comment navigation form the comments template.', 'cafelite' ),
						'default'  => 'Comment navigation',
					),

					array(
						'id'      => 'older_comment',
						'type'    => 'text',
						'title'   => esc_html__( 'Older Comments text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Older Comments form the comments template.', 'cafelite' ),
						'default'  => 'Older Comments',
					),

					array(
						'id'      => 'newer_comment',
						'type'    => 'text',
						'title'   => esc_html__( 'Newer Comments text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Newer Comments form the comments template.', 'cafelite' ),
						'default'  => 'Newer Comments',
					),

					array(
						'id'      => 'comments_close',
						'type'    => 'text',
						'title'   => esc_html__( 'Comments are closed text', 'cafelite' ),
						'subtitle'   => esc_html__( 'Change text Comments are closed form the comments template.', 'cafelite' ),
						'default'  => 'Comments are closed.',
					),

				),
			);


			/*
			--------------------------------------------------------*/
			/*
			 404 Error
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( '404 Page', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-error-alt',
				'submenu' => true,
				'fields' => array(

					array(
						'id'      => 'error_header',
						'title'   => esc_html__( 'Blog header', 'cafelite' ),
						'type'    => 'button_set',
						'default' => 'on',
						'options' => array(
							'on'    => esc_html__( 'Show page header', 'cafelite' ),
							'off'   => esc_html__( 'Hide page header ', 'cafelite' ),
						),
					),

					array(
						'id'       => 'error_header_alignment',
						'type'     => 'select',
						'default'  => 'center',
						'title'    => esc_html__( 'Error header alignment', 'cafelite' ),
						'required' => array( 'error_header', '=', array( 'on' ) ),
						'options'  => array(
							'left'      => esc_html__( 'Left', 'cafelite' ),
							'center'    => esc_html__( 'Center', 'cafelite' ),
							'right'     => esc_html__( 'Right', 'cafelite' ),
						),
					),

					array(
						'id'      => 'error_header_height',
						'type'    => 'text',
						'title'   => esc_html__( 'Error header size', 'cafelite' ),
						'required' => array( 'error_header', '=', array( 'on' ) ),
						'default'  => '150px',
					),

					array(
						'id'      => 'error_header_title',
						'type'    => 'text',
						'title'   => esc_html__( 'Error heading', 'cafelite' ),
						'required' => array( 'error_header', '=', array( 'on' ) ),
						'default'  => '404 Not Found',
					),

					array(
						'id'      => 'error_header_sub_title',
						'type'    => 'textarea',
						'title'   => esc_html__( 'Error sub-heading', 'cafelite' ),
						'required' => array( 'error_header', '=', array( 'on' ) ),
						'default'  => 'Proin ultricies, nisl in imperdiet interdum, est tortor viverra neque, eu molestie dolor lacus sollicitudin sem. Aenean fringilla suscipit justo. Curabitur sagittis quam dolor',
					),

					array(
						'id'      => 'error_content_title',
						'type'    => 'text',
						'title'   => esc_html__( 'Error content heading', 'cafelite' ),
						'default'  => 'Opps &#58;&#x28;',
					),

					array(
						'id'      => 'error_content_des',
						'type'    => 'textarea',
						'title'   => esc_html__( 'Error content description', 'cafelite' ),
						'default'  => 'Nothing found for the requested page. Try a search instead?',
					),


				),
			);


			/*
			--------------------------------------------------------*/
			/*
			 Galfilter Plugin
			/*--------------------------------------------------------*/
			$this->sections[] = array(
				'title'  => esc_html__( 'Galfilter', 'cafelite' ),
				'desc'   => '',
				'icon'   => 'el-icon-th-large',
				'submenu' => true,
				'fields' => array(

					array(
						'id'      => 'text_all',
						'type'    => 'text',
						'title'   => esc_html__( 'Change text All form Galfilter Plugin Demo 1 and Demo 2', 'cafelite' ),
						'default'  => 'All',
					),

					array(
						'id'      => 'text_load_more',
						'type'    => 'text',
						'title'   => esc_html__( 'Change text Load More form Galfilter Plugin Demo 3 and Demo 4', 'cafelite' ),
						'default'  => 'Load More',
					),

					array(
						'id'      => 'text_prev',
						'type'    => 'text',
						'title'   => esc_html__( 'Change text Prev form Galfilter Plugin Demo 5 and Demo 6', 'cafelite' ),
						'default'  => 'Prev',
					),

					array(
						'id'      => 'text_next',
						'type'    => 'text',
						'title'   => esc_html__( 'Change text Next form Galfilter Plugin Demo 5 and Demo 6', 'cafelite' ),
						'default'  => 'Next',
					),

				),
			);



			$this->sections = apply_filters( 'inna_more_options_settings', $this->sections );

		}

	}

	global $reduxConfig;
	function inna_options_init() {
		global $reduxConfig;
		// force remove sample redux demo option
		delete_option( 'ReduxFrameworkPlugin' );
		$reduxConfig = new inna_Theme_Options_Config();
	}
	add_action( 'init', 'inna_options_init' );

}


/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if ( ! function_exists( 'wp_coupon_remove_demo' ) ) {
	function wp_coupon_remove_demo() {
		// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter(
				'plugin_row_meta',
				array(
					ReduxFrameworkPlugin::instance(),
					'plugin_metalinks',
				),
				null,
				2
			);

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
		}
	}
}
wp_coupon_remove_demo();



/*
 * Load Redux extensions
 */
function inna_register_redux_extensions( $ReduxFramework ) {
	$path    = get_template_directory() . '/assets/inc/redux-extensions/';

	$folders = scandir( $path, 1 );

	foreach ( $folders as $folder ) {
		if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
			continue;
		}
		$extension_class = 'ReduxFramework_extension_' . $folder;
		if ( ! class_exists( $extension_class ) ) {
			// In case you wanted override your override, hah.
			$class_file = $path . $folder . '/extension_' . $folder . '.php';

			if ( is_file( $class_file ) ) {
				require_once $class_file;
			}
		}

		if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
			$ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
		}
	}
}
add_action( 'redux/extensions/before', 'inna_register_redux_extensions' );
