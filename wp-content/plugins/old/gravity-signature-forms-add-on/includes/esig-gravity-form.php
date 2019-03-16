<?php
/**
 * 
 * @package ESIG_GRAVITY
 * @author  Approve me <abushoaib73@gmail.com>
 */
if (!class_exists('ESIG_GRAVITY')) :
class ESIG_GRAVITY {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.1
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';
	
	

	/**
	 *
	 * Unique identifier for plugin.
	 *
	 * @since     0.1
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'esig-gf';

	/**
	 * Instance of this class.
	 *
	 * @since     1.0.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     0.1
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array($this, 'load_plugin_textdomain') );
	
                add_action( 'admin_init',array($this, 'esign_gravity_after_install') );
                
                // add action for 
                add_action("after_plugin_row",array($this,"esig_gravity_core_missing"),10,2);
	}
        
        public function esig_gravity_core_missing($plugin_file, $plugin_data)
        {
            if(function_exists('WP_E_Sig'))
                     return;
            
            if ( strpos( $plugin_file, 'esig-gravity-form.php' ) !== false ) 
                {
                    echo '<tr class="plugin-update-tr active">

       <td colspan="3" class="plugin-update colspanchange">
       <div class="update-message">
       This plugin is missing some required plugins by <a href="https://www.approveme.com/?utm_source=wprepo&utm_medium=link&utm_campaign=gravityforms">Approve Me</a> Which is available to Business License holders <a href="https://www.approveme.com/?utm_source=wprepo&utm_medium=link&utm_campaign=gravityforms">Purchase License Today</a>

       </div> </div></td></tr>' ; 
            }
             
        }
   
   public function esign_gravity_after_install() 
	{
		
		if( ! is_admin() )
		return;
		
		// Delete the transient
		//delete_transient( '_esign_activation_redirect' );
		if(delete_transient( '_esign_gravity_redirect' )) 
		{
			wp_safe_redirect( admin_url( 'index.php?page=esign-gravity-about' ));
			exit;
		}
		
	}
	/**
	 * Returns the plugin slug.
	 *
	 * @since     0.1
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Returns an instance of this class.
	 *
	 * @since     0.1
	 * @return    object    A single instance of this class.
	 */
	 
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since     0.1
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	 
	public static function activate( $network_wide ) {
		self::single_activate();
        
        set_transient( '_esign_gravity_redirect', true, 30 );
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since     0.1
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		self::single_deactivate();
	}

	

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since     0.1
	 */
	private static function single_activate() {
		//@TODO: Define activation functionality here
		if(get_option('WP_ESignature__Gravity Form_documentation'))
        {
			update_option('WP_ESignature__Gravity Form_documentation','https://www.approveme.com/wp-digital-signature-plugin-docs/article/gravity-form-add-on/?utm_source=wprepo&utm_medium=link&utm_campaign=gravityforms');
            
        }
        else
        {
           
			add_option('WP_ESignature__Gravity Form_documentation','https://www.approveme.com/wp-digital-signature-plugin-docs/article/gravity-form-add-on/?utm_source=wprepo&utm_medium=link&utm_campaign=gravityforms');
        }
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since     0.1
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since     0.1
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}
	
	
}
endif;
