<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Moove_Activity_Actions File Doc Comment
 *
 * @category  Moove_Activity_Actions
 * @package   moove-activity-tracking
 * @author    Gaspar Nemes
 */

/**
 * Moove_Activity_Actions Class Doc Comment
 *
 * @category Class
 * @package  Moove_Activity_Actions
 * @author   Gaspar Nemes
 */
class Moove_Activity_Actions {
	/**
	 * Global cariable used in localization
	 *
	 * @var array
	 */
	var $activity_loc_data;
	/**
	 * Construct
	 */
	function __construct() {
		$this->moove_register_scripts();

		add_action( 'wp_ajax_moove_activity_track_pageview', array( 'Moove_Activity_Controller', 'moove_track_user_access_ajax' ) );
		add_action( 'wp_ajax_nopriv_moove_activity_track_pageview', array( 'Moove_Activity_Controller', 'moove_track_user_access_ajax' ) );
		add_action( 'moove-activity-tab-content', array( &$this, 'moove_activity_tab_content' ), 5, 1 );
		add_action( 'moove-activity-tab-extensions', array( &$this, 'moove_activity_tab_extensions' ), 5, 1 );
		add_action( 'moove-activity-filters', array( &$this, 'moove_activity_filters' ), 5, 2 );
		add_action( 'moove-activity-top-filters', array( &$this, 'moove_activity_top_filters' ) );
	}

	function moove_activity_top_filters() {
		ob_start();
		$user_options = get_user_meta( get_current_user_id(), 'moove_activity_screen_options', true );
		?>
		<div class="moove-activity-screen-meta">
		  <div id="screen-meta" class="metabox-prefs" style="display: none;">

			<div id="screen-options-wrap" class="hidden" tabindex="-1" aria-label="Screen Options Tab" style="display: none;">
			  <form id="adv-settings" method="post">
				<input type="hidden" name="wp_user_id" id="wp_user_id" value="<?php echo get_current_user_id(); ?>" />
				<fieldset class="metabox-prefs">
				  <legend><?php _e( 'Columns', 'user-activity-tracking-and-log' ); ?></legend>
				  <label>
					<input class="moove-activity-columns-tog" name="posttype-hide" type="checkbox" id="posttype-hide" value="posttype" <?php echo ( isset( $user_options['posttype-hide'] ) || ! is_array( $user_options ) ) ? 'checked="checked"' : ''; ?>><?php _e( 'Post type', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <label>
					<input class="moove-activity-columns-tog" name="user-hide" type="checkbox" id="user-hide" value="user" <?php echo ( isset( $user_options['user-hide'] ) || ! is_array( $user_options ) ) ? 'checked="checked"' : ''; ?>><?php _e( 'User', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <label>
					<input class="moove-activity-columns-tog" name="activity-hide" type="checkbox" id="activity-hide" value="activity" <?php echo ( isset( $user_options['activity-hide'] ) || ! is_array( $user_options ) ) ? 'checked="checked"' : ''; ?>><?php _e( 'Activity', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <label>
					<input class="moove-activity-columns-tog" name="ip-hide" type="checkbox" id="ip-hide" value="ip" <?php echo ( isset( $user_options['ip-hide'] ) || ! is_array( $user_options ) ) ? 'checked="checked"' : ''; ?>><?php _e( 'Client IP', 'user-activity-tracking-and-log' ); ?>
				  </label>
				   <label>
					<input class="moove-activity-columns-tog" name="city-hide" type="checkbox" id="city-hide" value="city" <?php echo ( isset( $user_options['city-hide'] ) || ! is_array( $user_options ) ) ? 'checked="checked"' : ''; ?>><?php _e( 'Client Location', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <label>
					<input class="moove-activity-columns-tog" name="referrer-hide" type="checkbox" id="referrer-hide" value="referrer" <?php echo ( isset( $user_options['referrer-hide'] ) || ! is_array( $user_options ) ) ? 'checked="checked"' : ''; ?>><?php _e( 'Referrer', 'user-activity-tracking-and-log' ); ?>
				  </label>
				</fieldset>
				<br />
				<fieldset class="screen-options">
				  <legend><?php _e( 'Pagination', 'user-activity-tracking-and-log' ); ?></legend>
				  <label for="edit_post_per_page"><?php _e( 'Number of items per page', 'user-activity-tracking-and-log' ); ?>:</label>
				  <?php
					$ppp_val = 10;
					if ( isset( $user_options['wp_screen_options']['value'] ) && intval( $user_options['wp_screen_options']['value'] ) ) :
						$ppp_val = intval( $user_options['wp_screen_options']['value'] );
					endif;
					?>

				  <input type="number" step="1" min="1" max="999" class="screen-per-page" name="wp_screen_options[value]" id="edit_post_per_page" maxlength="3" value="<?php echo $ppp_val; ?>">
				  <input type="hidden" name="wp_screen_options[option]" value="edit_post_per_page">
				</fieldset>
				<br />
				<?php
				if ( isset( $user_options['moove-activity-dtf'] ) ) :
					$radio = $user_options['moove-activity-dtf'];
					if ( $radio === 'c' ) :
						$offset = $user_options['timezone'];
					elseif ( $radio === 'b' ) :
						$offset = get_option( 'gmt_offset' );
					else :
						$offset = 0;
					endif;
				  else :
						$radio  = 'a';
						$offset = 0;
				  endif;
					update_option( 'moove-activity-timezone-offset', $offset );

					?>
				<fieldset class="metabox-prefs">
				  <legend><?php _e( 'Date / Time - Timezone', 'user-activity-tracking-and-log' ); ?></legend>
				  <label>
					<input class="moove-activity-columns-tog" name="moove-activity-dtf" <?php echo $radio === 'a' ? 'checked="checked"' : ''; ?> type="radio" id="moove-activity-dtf-a" value="a"><?php _e( 'Use UTC time for logs', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <br />

				  <label>
					<input class="moove-activity-columns-tog" <?php echo $radio === 'b' ? 'checked="checked"' : ''; ?> name="moove-activity-dtf" type="radio" id="moove-activity-dtf-b" value="b"><?php _e( 'Use website timezone for logs (defined here: Settings -> General -> Timezone)', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <br />

				  <label>
					<input class="moove-activity-columns-tog" <?php echo $radio === 'c' ? 'checked="checked"' : ''; ?> name="moove-activity-dtf" type="radio" id="moove-activity-dtf-c" value="c"><?php _e( 'Select custom timezone', 'user-activity-tracking-and-log' ); ?>
				  </label>
				  <br />
				  <?php
					$class           = isset( $user_options['moove-activity-dtf'] ) && $user_options['moove-activity-dtf'] === 'c' ? '' : 'moove-hidden';
					$custom_timezone = isset( $user_options['moove-activity-dtf'] ) && $user_options['moove-activity-dtf'] === 'c' ? $user_options['timezone'] : 0;
					?>
				  <div class="moove-activity-screen-ctm <?php echo $class; ?>">

					<label><strong><?php _e( 'Custom Timezone', 'user-activity-tracking-and-log' ); ?></strong></label><br />
					<?php
					  moove_activity_get_timezone_dropdown( $custom_timezone );
					?>
				  </div>
				  <!--  .moove-activity-screen-ctm -->

				</fieldset>

				<p class="submit">
				  <input type="button" name="moove-activity-screen-options-apply" id="moove-activity-screen-options-apply" class="button button-primary" value="<?php _e( 'Apply', 'user-activity-tracking-and-log' ); ?>">
				</p>
			  </form>
			</div>
			<!-- #screen-options-wrap -->
		  </div>
		  <!-- #screen-meta -->
		  <div id="screen-meta-links">

			<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
			  <button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false"><?php _e( 'Screen Options', 'user-activity-tracking-and-log' ); ?></button>
			</div>
			<!-- #creen-options-link-wrap -->
		  </div>
		  <!-- #screen-meta-links -->
		</div>
		<!--  .moove-activity-screen-meta -->
		<?php
		echo ob_get_clean();
	}

	function moove_activity_tab_content( $data ) {
		$uat_view = new Moove_Activity_View();
		if( $data['tab'] == 'post_type_activity' ) : ?>
            <form action="options.php" method="post" class="moove-activity-form">
                <?php
                settings_fields( 'moove_post_activity' );
                do_settings_sections( 'moove-activity' );
                submit_button();
                ?>
            </form>
        <?php elseif( $data['tab'] == 'plugin_documentation' ): ?>
            <?php echo $uat_view->load( 'moove.admin.settings.documentation' , true ); ?>
        <?php endif;
	}

	function moove_activity_tab_extensions( $active_tab ) {
		?>
		 <a href="?page=moove-activity&tab=post_type_activity" class="nav-tab <?php echo $active_tab == 'post_type_activity' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Post type activity tracking','user-activity-tracking-and-log'); ?>
        </a>
		<?php
	}

	/**
	 * Register Front-end / Back-end scripts
	 *
	 * @return void
	 */
	function moove_register_scripts() {
		if ( is_admin() ) :
			add_action( 'admin_enqueue_scripts', array( &$this, 'moove_activity_admin_scripts' ) );
		else :
			add_action( 'wp_enqueue_scripts', array( &$this, 'moove_frontend_activity_scripts' ) );
		endif;
	}

	function moove_activity_filters( $filters, $content ) {
		echo $filters;
	}

	/**
	 * Register global variables to head, AJAX, Form validation messages
	 *
	 * @param  string $ascript The registered script handle you are attaching the data for.
	 * @return void
	 */
	public function moove_localize_script( $ascript ) {
		$this->activity_loc_data = array(
				'activityoptions'		=> 	get_option( 'moove_activity-options' ),
				'referer'				=> 	wp_get_referer(),
				'ajaxurl'				=>	admin_url( 'admin-ajax.php' ),
				'post_id'				=>	get_the_ID(),
				'is_page'				=>	is_page(),
				'is_single'				=>	is_single(),
				'current_user'			=>	get_current_user_id(),
				'referrer'				=>	esc_url( wp_get_referer() )
		);
		wp_localize_script( $ascript, 'moove_frontend_activity_scripts', $this->activity_loc_data );
	}

	/**
	 * Registe FRONT-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function moove_frontend_activity_scripts() {
		wp_enqueue_script( 'moove_activity_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/js/moove_activity_frontend.js', array( 'jquery' ), MOOVE_UAT_VERSION, true );
		// wp_enqueue_style( 'moove_activity_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/css/moove_activity_frontend.css' );
		$this->moove_localize_script( 'moove_activity_frontend' );
	}
	/**
	 * Registe BACK-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function moove_activity_admin_scripts() {
		wp_enqueue_script( 'moove_activity_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/js/moove_activity_backend.js', array( 'jquery' ), MOOVE_UAT_VERSION, true );
		wp_enqueue_style( 'moove_activity_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/css/moove_activity_backend.css', '', MOOVE_UAT_VERSION );
	}
}
$moove_activity_actions_provider = new Moove_Activity_Actions();

