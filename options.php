<?php
/*
Plugin Name: Google Dynamic Remarketing
Version:     2.2
Description: Automatic inclusion of Dynamic Remarketing tags. Only works for Dynamic Display Feed -> Custom
Author: <a target="_blank" href="http://www.sinaps.ro/?utm_source=plugin&utm_medium=link&utm_campaign=plugin_remarketing">Sinaps Marketing</a>
License: Sinaps Marketing is not liable for any damage caused by the use of this plugin.
License: All Rights Reserved.
Homepage: http://www.sinaps.ro

*/

class sin_remarketing_dinamic
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'sin_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'sin_page_init' ) );
    }

    /**
     * Add options page
     */
    public function sin_add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Dynamic Remarketing', 
            'Dynamic Remarketing', 
            'manage_options', 
            'remarketing_dinamic', 
            array( $this, 'sin_create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function sin_create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'gcid_name' );
        ?>
        <div class="wrap">
          <a target="_blank" href="http://www.sinaps.ro/?utm_source=plugin&utm_medium=link&utm_campaign=plugin_remarketing"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'sinaps-logo-15-s.png'; ?>"  width="170px;"></a>   
		  
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'gcid_group' );   
                do_settings_sections( 'remarketing_dinamic' );
                submit_button(); 
            ?>
			<h3> Example: </h3>
            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'code.jpg'; ?>" /><br/>
            </form>
			<h3> FEED: </h3>
			Your current feed url is <a href="<?php echo plugin_dir_url( __FILE__ ) . 'feed.php'; ?>"><?php echo plugin_dir_url( __FILE__ ) . 'feed.php'; ?></a><br/>
			You can use this for scheduled uploads or you can download it <a href="<?php echo plugin_dir_url( __FILE__ ) . 'feed.php'; ?>">here</a> and manually upload it to AdWords.

			
			
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function sin_page_init()
    {        
	
        register_setting(
            'gcid_group', // Option group
            'gcid_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Dynamic Remarketing Settings', // Title
            array( $this, 'sin_section_info' ), // Callback
            'remarketing_dinamic' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'Google Conversion ID', // Title 
            array( $this, 'sin_id_number' ), // Callback
            'remarketing_dinamic', // Page
            'setting_section_id' // Section           
        );      

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

      
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function sin_section_info()
    {
        print 'Insert the <b>google_conversion_id </b> value from your Dynamic Remarketing code: ';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function sin_id_number()
    {
        printf(
            '<input type="text" id="id_number" name="gcid_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

   
}

if( is_admin() )
    $sin_settings_page = new sin_remarketing_dinamic();


function rmkdin(){
require_once('remarketing-dinamic.php');

}


add_action( 'wp_footer', 'rmkdin' );