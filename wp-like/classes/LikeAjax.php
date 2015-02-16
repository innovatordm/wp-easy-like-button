<?php
namespace WPLike\Classes;
/**
* 
*/
class LikeAjax
{
	
	function __construct()
	{
		add_action('wp_ajax_nopriv_send_like', array($this, 'doLike'));
		add_action('wp_ajax_send_like', array($this, 'doLike'));
	}

	public function doLike()
	{	
		check_ajax_referer( "easyNonce", "easyLikeSec", true );
		$postId = intval($_POST['postId']);
		
		
		if($postId == 0) {
			wp_die();
		}
		header('Content-Type: application/json');

		if(isset($_COOKIE['easy_like_cookie'])) {
			$newCookieData = unserialize(base64_decode($_COOKIE['easy_like_cookie']));
			if(!in_array($postId, $newCookieData)) {
				array_push($newCookieData, $postId);
				$cookieData = base64_encode(serialize(array($newCookieData)));
				setcookie('easy_like_cookie', $cookieData, time() + (3600*24*100), '/');
				$this->addLikeCountToPost($postId);
			}
			echo json_encode(array('status' => 'clicked'));
			wp_die();
		}
		$this->addLikeCountToPost($postId);
		echo json_encode(array('status' => 'clicked'));
		// Set cookie 
		$cookieData = base64_encode(serialize(array($postId)));
		setcookie('easy_like_cookie', $cookieData, time() + (3600*24*100), '/');
		wp_die();
	}

	public function addLikeCountToPost($postId)
	{
		$count = get_post_meta( $postId, '_easy_like_count', true );
		if($count === '') {
			add_post_meta( $postId, '_easy_like_count', 1, true );
			return;
		}
		$count = $count + 1;
		update_post_meta( $postId, '_easy_like_count', $count);
	}
}

?>