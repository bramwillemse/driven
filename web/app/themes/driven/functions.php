<?php
/* 	==============================================================
   	Load theme base
   	============================================================== */  

	include_once('inc/functions-base.php');
	

class GoldMine {

	/**
	 * Constructor, uses hooks to integrate functionalities into WordPress
	 */
	public function __construct() {
		
		# Disable XML-RPC
		add_filter( 'xmlrpc_enabled', '__return_false' );

		# Activate thumbnail support

		# Theme defaults
		$this->theme_defaults();
		
		# Register menu locations
		add_action('init', array(&$this, 'register_menus'));

		# Give editors full access to gravity forms
		add_action('admin_init', array(&$this, 'add_grav_forms'));

		# Add shortcodes
		# add_action( 'init', array( &$this, 'register_shortcodes') );
		
		# # Add sidebars
		# add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );

		# Enqueue stylesheets
		# add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );

		# Enqueue javascripts
		# add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		 
		# Redirect login attempts for user "admin"
		add_action( 'wp_login_failed', array(&$this, 'redirect_unwanted_login'), 1 );

		# Add custom query vars
		// add_filter( 'query_vars', array(&$this, 'add_custom_query_var'));
	}

	public function theme_defaults() {
		if (function_exists('add_theme_support')) {

			// Activatet thumbnail support
			add_theme_support( 'post-thumbnails' );

		    // Add Menu Support
		    add_theme_support('menus');

		    // Add Thumbnail Theme Support
		    add_theme_support('post-thumbnails');
		    
		    // Set tiny image sizes 
			add_image_size('tiny', 240, '', true);
			add_image_size('tiny-square', 240, 240, true);
			add_image_size('tiny-wide', 240, 135, true);

		    // Set thumbnail image sizes
		    update_option('thumbnail_size_w', 480);
			update_option('thumbnail_size_h', '');
			update_option('thumbnail_crop', 1);
			add_image_size('thumbnail-square', 480, 480, true); // Square Thumbnail
			add_image_size('thumbnail-wide', 480, 270, true);

			// Set medium image sizes
			update_option('medium_size_w', 768);
			update_option('medium_size_h', '');
			update_option('medium_crop', 1);
		    add_image_size('medium-square', 768, 768, true);
			add_image_size('medium-wide', 768, 432, true);


			// Set large image sizes
			update_option('large_size_w', 1280);
			update_option('large_size_h', '');
			update_option('large_crop', 1);			
			add_image_size('large-square', 1280, 1280, true);
			add_image_size('large-wide', 1280, 720, true);

		    // Set huge image sizes 
			add_image_size('huge', 1600, '', true);
			add_image_size('huge-square', 1600, 1600, true);
			add_image_size('huge-wide', 1600, 900, true);


		    
		    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
		    /*add_theme_support('custom-background', array(
				'default-color' => 'FFF',
				'default-image' => get_template_directory_uri() . '/img/bg.jpg'
		    ));*/

		    // Add Support for Custom Header - Uncomment below if you're going to use
		    add_theme_support('custom-header', array(
				// 'default-image'			=> get_template_directory_uri() . 'assets/img/headers/default.jpg',
				'header-text'			=> false,
				'default-text-color'		=> '000',
				'width'				=> 1280,
				'height'			=> '',
				'random-default'		=> false,
				// 'wp-head-callback'		=> $wphead_cb,
				// 'admin-head-callback'		=> $adminhead_cb,
				// 'admin-preview-callback'	=> $adminpreview_cb
		    ));

		    // Enables post and comment RSS feed links to head
		    add_theme_support('automatic-feed-links');

		    // Localisation Support
		    // load_theme_textdomain('goldmine', get_template_directory() . '/languages');
		}
	}


	/**
	 * Register the menu locations for our theme
	 */
	public function register_menus() {
	    register_nav_menus(array( // Using array to specify more menus if needed
	        'nav-main' => __('Hoofdmenu', 'goldmine'), // Main menu
	        'nav-footer' => __('Footer menu', 'goldmine'), // Footer menu
	        'nav-mobile' => __('Mobile Menu', 'goldmine') // Mobile menu

	    ));
	}

	/**
	 * Add full access for gravity forms to editor's rights
	 */
	public function add_grav_forms(){
	    $role = get_role('editor');
	    $role->add_cap('gform_full_access');
	}

	/**
	 * Register sidebars
	 */
	public function register_sidebars() {
		
		// register_sidebar( array(
		// 	'name' => __( 'Super sidebar', 'super-theme' ),
		// 	'id' => 'super-sidebar',
		// 	'before_widget' => '<div class="widget %2$s">',
		// 	'after_widget' => '</div>',
		// 	'before_title' => "<h3>",
		// 	'after_title' => "</h3>"
		// ));

	}

	public function register_shortcodes() {

		// add_shortcode( 'highlight', function( $atts, $content ) {
			
		// 	if( ! empty( $atts ) ) 
		// 		extract( $atts );

		// 	return '<p class="intro highlight">'.$content.'</p>';
		// });

	}

	
	/**
	 * Method to easily get the right URL when wanting to reference the theme folder URI.
	 * For wonderful convenience!
	 */
	public static function theme_url( $url ) {
		return trailingslashit( get_template_directory_uri() ) . $url;
	}


	/**
	 * Detect bot trying to log in as admin and redirect it to itself
	 */
	public function redirect_unwanted_login( $username ) {
		
		if( $username == 'admin' ) # Bye
			wp_redirect( $_SERVER['REMOTE_ADDR'], 301 );

	}

	/**
	 * Add custom query variables
	 */
	// public function add_custom_query_var( $vars ){
	// 	$vars[] = "naam";
	// 	return $vars;
	// }

}
new GoldMine;


/**
* Set another title for Options page
*/
if( function_exists('acf_add_options_page_title') ) {
	acf_set_options_page_title( 'Opties' );
}
/**
* Create options page(s) that sits under the General options menu
*/
if( function_exists('acf_add_options_sub_page') )
{
    acf_add_options_sub_page(array(
        'title' => 'Bedrijfsgegevens',
        'parent' => 'options-general.php',
        'capability' => 'manage_options'
    ));
}

/**
* Register general sidebar
*/
if ( function_exists('register_sidebar') ) {
	register_sidebar();
}

// Custom function for main menu
function nav_main() {
	// Load nav-main
	wp_nav_menu(
		array(
			'theme_location'  => 'nav-main',
			'menu'            => '',
			'container'       => false,
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'nav nav-main',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		)
	);
}

// Custom function for footer menu
function nav_footer() {
	// Load nav-main
	wp_nav_menu(
		array(
			'theme_location'  => 'nav-footer',
			'menu'            => '',
			'container'       => false,
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'nav nav-footer',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		)
	);
}

?>