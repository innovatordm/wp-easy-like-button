<?php
use WPLike\Classes\LikeRender;
use WPLike\Classes\LikeAjax;
/*
Plugin Name: WP Like
Plugin URI: http://www.innovator.se
Description: A simple like button
Version: 1.0
Author: Innovator Digital Markets AB
Author URI: http://www.innovator.se
Text Domain: wp-hooker
*/

require_once 'classes/LikeRender.php';
require_once 'classes/LikeAjax.php';

/**
* Main class for WP Like
*/
class WPLike
{
	
	function __construct()
	{
		new LikeRender();
		new LikeAjax();
	}
}

add_action( 'init', function() {
	new WPLike();
});

?>