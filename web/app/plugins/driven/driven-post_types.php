<?php
class PostTypes {

	/**
	 * Constructor, uses hooks to integrate functionalities into WordPress
	 */
	public function __construct() {
		add_action( 'init', array( &$this, 'cars_post_type' ), 0 ); // Add post type 'cars'
		// add_action( 'init', array( &$this, 'taxonomy_brands') ); // Add taxonomy brands to post type 'cars'

		add_action( 'admin_head', array( &$this, 'post_type_icons') ); // set icons for post types
		add_filter( 'request', array( &$this, 'my_custom_archive_order'), 0 ); // Fix archive ordering for post types
		// add_action( 'nav_menu_css_class', array( &$this, 'add_current_nav_class'), 10, 2 );
		add_filter('nav_menu_css_class', array( &$this, 'theme_current_type_nav_class'), 1, 2);
		add_action('pre_get_posts', array( &$this, 'custom_front_page'));
	}

	// Register Custom Post Type 'cars'
	public function cars_post_type() {

		$labels = array(
			'name'                => _x( 'Cars', 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( 'Car', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( 'Cars', 'text_domain' ),
			'parent_item_colon'   => __( 'Parent car:', 'text_domain' ),
			'all_items'           => __( 'All cars', 'text_domain' ),
			'view_item'           => __( 'View car', 'text_domain' ),
			'add_new_item'        => __( 'Add car', 'text_domain' ),
			'add_new'             => __( 'New car', 'text_domain' ),
			'edit_item'           => __( 'Edit car', 'text_domain' ),
			'update_item'         => __( 'Save car', 'text_domain' ),
			'search_items'        => __( 'Search cars', 'text_domain' ),
			'not_found'           => __( 'Car not found', 'text_domain' ),
			'not_found_in_trash'  => __( 'Car not found in trash', 'text_domain' ),
		);
		$args = array(
			'label'               => __( 'cars', 'text_domain' ),
			'rewrite' 			  => array('slug' => 'cars'),
			'description'         => __( 'cars post type', 'text_domain' ),
			'labels'              => $labels,
			'taxonomies' 		  => array( 'brands' ),
			'supports'            => array( 'title','thumbnail', 'revisions' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page'
		);
		register_post_type( 'cars', $args );

	}


	public function taxonomy_brands() {

		$labels = array(
			'name'                       => _x( 'Brands', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Brand', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Brands', 'text_domain' ),
			'all_items'                  => __( 'All brands', 'text_domain' ),
			'parent_item'                => __( 'Parent brand', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent brand:', 'text_domain' ),
			'new_item_name'              => __( 'New Brand Name', 'text_domain' ),
			'add_new_item'               => __( 'Add new brand', 'text_domain' ),
			'edit_item'                  => __( 'Edit brand', 'text_domain' ),
			'update_item'                => __( 'Update brand', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate brands with commas', 'text_domain' ),
			'search_items'               => __( 'Search brands', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove brands', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used brandss', 'text_domain' ),
			'not_found'                  => __( 'No brands Found', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
		);
		register_taxonomy( 'brands', array( 'cars' ), $args );

	}

	// Add icons to Post types
	public function post_type_icons() { ?>
	    <style type="text/css" media="screen">
			#adminmenu .menu-icon-cars div.wp-menu-image:before {
				content: "\f159";
			}

	    </style><?php 
	} 
	// Use custom sort order post types
	public function my_custom_archive_order( $vars ) {
		if ( !is_admin() && isset($vars['post_type']) && is_post_type_hierarchical($vars['post_type']) ) {
			$vars['orderby'] = 'menu_order';
			$vars['order'] = 'ASC';
		}
		return $vars;
	}

	// Highlight post type in nav menu
	public function add_current_nav_class($classes, $item) {
		
		// Getting the current post details
		global $post;
		
		// Getting the post type of the current post
		$current_post_type = get_post_type_object(get_post_type($post->ID));
		$current_post_type_slug = $current_post_type->rewrite['slug'];
			
		// Getting the URL of the menu item
		$menu_slug = strtolower(trim($item->url));
		
		// If the menu item URL contains the current post types slug add the current-menu-item class
		if (strpos($menu_slug,$current_post_type_slug) !== false) {
		
		   $classes[] = 'current-menu-item';
		
		}
		
		// Return the corrected set of classes to be added to the menu item
		return $classes;
	
	}	

	public function theme_current_type_nav_class($css_class, $item) {
	    static $custom_post_types, $post_type, $filter_func;

	    if (empty($custom_post_types))
	        $custom_post_types = get_post_types(array('_builtin' => false));

	    if (empty($post_type))
	        $post_type = get_post_type();

	    if ('page' == $item->object && in_array($post_type, $custom_post_types)) {
	        if (empty($filter_func))
	            $filter_func = create_function('$el', 'return ($el != "current_page_parent");');

	        $css_class = array_filter($css_class, $filter_func);

	        $template = get_page_template_slug($item->object_id);
	        if (!empty($template) && preg_match("/^page(-[^-]+)*-$post_type/", $template) === 1)
	            array_push($css_class, 'current_page_parent');

	    }

	    return $css_class;
	}
	

	function custom_front_page($wp_query){
	    //Ensure this filter isn't applied to the admin area
	    if(is_admin()) {
	        return;
	    }

	    if($wp_query->get('page_id') == get_option('page_on_front')):

	        $wp_query->set('post_type', 'cars');
	        $wp_query->set('page_id', ''); //Empty

	        //Set properties that describe the page to reflect that
	        //we aren't really displaying a static page
	        $wp_query->is_page = 0;
	        $wp_query->is_singular = 0;
	        $wp_query->is_post_type_archive = 1;
	        $wp_query->is_archive = 1;

	    endif;

	}




}
new PostTypes; 

?>