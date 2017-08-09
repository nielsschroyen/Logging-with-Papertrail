<?php
class PapertrailAdminPage
{
    private $options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Papertrail for WordPress', 
            'Papertrail for WP', 
            'manage_options', 
            'papertrail-for-wordpress-settings', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'papertrail_for_wordpress_options' );
        ?>
        <div class="wrap">
            <h1>Papertrail for WordPress</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'papertrail_for_wordpress_options_group' );
                do_settings_sections( 'papertrail-for-wordpress-settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'papertrail_for_wordpress_options_group', // Option group
            'papertrail_for_wordpress_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'papertrail_setting_section_id', // ID
            'Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'papertrail-for-wordpress-settings' // Page
        );    

        add_settings_field(
            'host', 
            'Papertrail Host', 
            array( $this, 'host_callback' ), 
            'papertrail-for-wordpress-settings', 
            'papertrail_setting_section_id'
        );     

        add_settings_field(
            'port', 
            'Papertrail Port', 
            array( $this, 'port_callback' ), 
            'papertrail-for-wordpress-settings', 
            'papertrail_setting_section_id'
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
        
        if( isset( $input['host'] ) )
            $new_input['host'] = sanitize_text_field( $input['host'] );
        
        if( isset( $input['port'] ) )
            $new_input['port'] = sanitize_text_field( $input['port'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter <a href="https://papertrailapp.com/account/destinations" target="_blank"> your Papertrail settings</a> below.';
    }


    /** 
     * Get the settings option array and print one of its values
     */
    public function host_callback()
    {
        printf(
            '<input type="text" id="host" name="papertrail_for_wordpress_options[host]" value="%s" />',
            isset( $this->options['host'] ) ? esc_attr( $this->options['host']) : ''
        );
    }

    public function port_callback()
    {
        printf(
            '<input type="text" id="port" name="papertrail_for_wordpress_options[port]" value="%s" />',
            isset( $this->options['port'] ) ? esc_attr( $this->options['port']) : ''
        );
    }
}

if( is_admin() )
    $papertrailAdminPage = new PapertrailAdminPage();