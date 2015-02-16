jQuery(document).ready(function($) {

	var easyLikeData = $('#wpLikeButton').data();
	var sendLikeData = {
		'action': 'send_like',
		'postId': easyLikeData.easyId,
		'easyLikeSec': easyLikeData.easyNonce
	};
	$('#wpLikeButton').click(function(e) {
		e.preventDefault();
		$.post(easyLikeData.easyAjaxUrl, sendLikeData, function(response) {
			console.log(response);
			if(response.status === 'clicked') {
				$("#wpLikeButton").prop("disabled",true);
			}
		})
	});
});