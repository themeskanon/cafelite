<?php
    
    require_once( get_template_directory()  . '/assets/inc/class-tgm-plugin-activation.php');

    function tgm_plugins(){
        $plugins=array(
        
            
			array(
				'name'      		=> 'Redux Framework',
				'slug'      		=> 'redux-framework',
				'required'  		=> true,
                'force_activation'  => true,
			),
			
            array(
                'name'              => 'Contact Form 7',
                'slug'              => 'contact-form-7',
                'required'          => true,
                'force_activation'  => true,
            ),

        );

        $config=array(
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => get_template_directory().'/assets/plugins/',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );

        tgmpa($plugins, $config);
    }
    add_action('tgmpa_register','tgm_plugins');


?>