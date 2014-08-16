<?php /*
	Plugin Name: Driven
	Plugin URI: http://www.driven.bramwillemse.nl
	Description: Custom functions for Driven website
	Version: 1.0
	Author: Bram Willemse
	Author URI: http://www.bramwillemse.nl
	Tested up to: 3.9.2
*/

/* 	==============================================================
   	Load Custom Post Types
   	============================================================== */  

	include_once('driven-post_types.php');


/* 	==============================================================
   	Advanced Custom Fields functions
   	============================================================== */  

	include_once('driven-acf_fields.php'); // Load ACF fields as functions
	// define( 'ACF_LITE', true ); // Remove ACF interface completely


/*  ==============================================================
   	Wishlist
   	==============================================================

	# Autocomplete for car brands
	http://support.advancedcustomfields.com/forums/topic/ajax-autocomplete/ 
*/
?>