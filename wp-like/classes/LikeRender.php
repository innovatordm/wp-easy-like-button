<?php
namespace WPLike\Classes;
/**
* 
*/
class LikeRender
{
	function __construct($cookieSet=false)
	{
		add_shortcode( 'wp_like_button', array($this, 'renderButton') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueueScriptsandStyles') ); 
	}

	public function enqueueScriptsandStyles()
	{
		wp_register_style( 'easy_like_fontawesome', plugins_url('../assets/css/font-awesome.min.css', __FILE__));
		wp_register_style( 'easy_like_bootstrap', plugins_url('../assets/css/bootstrap.min.css', __FILE__));
		wp_register_script( 'easy_like_ajax', plugins_url('../assets/js/wp_like.js', __FILE__), array('jquery'), '1.0', true);
	}

	public function renderButton($atts)
	{
		$atts = shortcode_atts(
		array(
			'use_bootstrap' => 'true',
			'use_fontawesome' => 'true'
		), $atts, 'wp_like_button' );
		global $post;
		if($atts['use_fontawesome'] == 'true') {
			wp_enqueue_style('easy_like_fontawesome');
		}
		if($atts['use_bootstrap'] == 'true') {
			wp_enqueue_style('easy_like_bootstrap');
		}
		wp_enqueue_script('easy_like_ajax');

		$disabled = ($this->checkCookie()) ? 'disabled' : '';
		$count = get_post_meta( $post->ID, '_easy_like_count', true );
		$count = ($count !== '') ? $count : '';
		$button = '<button type="button" id="wpLikeButton" class="btn btn-default btn-lg" data-easy-id="' . $post->ID . '" data-easy-nonce="' . wp_create_nonce( "easyNonce" ) . '" ' . ' data-easy-ajax-url="' . admin_url( 'admin-ajax.php' ) . '" ' . $disabled . '><i class="fa fa-heart text-danger"></i> <span>' . $count . '</span> | Like Me</button>';

		return $button;
	}
	/**
	 * Check if cookie is set
	 * @return boolean returns true/false if set/not set
	 */
	public function checkCookie()
	{
		global $post;
		//echo $_COOKIE['easy_like_cookie'];
		if(isset($_COOKIE['easy_like_cookie']) && isset($post->ID)) {
			$easyCookie = unserialize(base64_decode($_COOKIE['easy_like_cookie']));
			if(in_array($post->ID, $easyCookie))
				return true;
		}
		return false;
	}
}

?>