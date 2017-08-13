<?php
class PapertrailAdminPage
{
  private $options;

  public function __construct()
  {
    add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    add_action( 'admin_init', array( $this, 'page_init' ) );
    add_action( 'wp_ajax_test_papertrail_for_wordpress', array( $this, 'test_papertrail_for_wordpress') );
  }

  public function test_papertrail_for_wordpress() {
    throw new Exception('Papertrail for WordPress error test');
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

      <a href="#" onclick="jQuery('#running_test').removeClass('hidden'); jQuery.post(ajaxurl, {action: 'test_papertrail_for_wordpress'}, function(response) {jQuery('#running_test').addClass('hidden');alert('Check your papertrail logs for: Papertrail for WordPress error test')});"> Try out</a> your <strong>saved</strong> settings.   
      <div id="running_test" class="hidden">Running test...</div>
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
      'Papertrail host', 
      array( $this, 'host_callback' ), 
      'papertrail-for-wordpress-settings', 
      'papertrail_setting_section_id'
    );     

    add_settings_field(
      'port', 
      'Papertrail port', 
      array( $this, 'port_callback' ), 
      'papertrail-for-wordpress-settings', 
      'papertrail_setting_section_id'
    );  

    add_settings_field(
      'system', 
      'System name', 
      array( $this, 'system_callback' ), 
      'papertrail-for-wordpress-settings', 
      'papertrail_setting_section_id'
    ); 
  
    add_settings_field(
      'program', 
      'Program name', 
      array( $this, 'program_callback' ), 
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

      if( isset( $input['system'] ) )
        $new_input['system'] = sanitize_text_field( $input['system'] );

      if( isset( $input['program'] ) )
        $new_input['program'] = sanitize_text_field( $input['program'] );

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

  public function system_callback()
  {
    printf(
      '<input type="text" id="system" name="papertrail_for_wordpress_options[system]" value="%s" />
        <a href="#" onclick="document.getElementById(\'system\').value = \'%s\';"> Fill in server Hostname</a>
      or
        <a href="#" onclick="document.getElementById(\'system\').value = \'%s\';"> Fill in server IP</a>',
      isset( $this->options['system'] ) ? esc_attr( $this->options['system']) : gethostbyname(gethostname()),
      gethostname(),
      gethostbyname(gethostname())
    );
  }

  public function program_callback()
  {
    printf(
      '<input type="text" id="program" name="papertrail_for_wordpress_options[program]" value="%s" />
        <a href="#" onclick="document.getElementById(\'program\').value = \'%s\';"> Fill in Sitename</a>
        or
        <a href="#" onclick="document.getElementById(\'program\').value = \'%s\';"> Fill in current URL</a>',
      isset( $this->options['program'] ) ? esc_attr( $this->options['program']) : str_replace(' ', '_', get_bloginfo('name')) ,            
      str_replace(' ', '_', get_bloginfo('name')) ,               
      preg_replace('#^https?://#', '', get_option('siteurl'))                 
    );
  }
}

if( is_admin() )
  $papertrailAdminPage = new PapertrailAdminPage();