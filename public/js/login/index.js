$(document).ready(function() {
	demo.checkFullPageBackgroundImage();
});

var csrfToken = $('[name="csrf_token"]').attr('content');

setInterval(refreshToken, 60000); // 5 minute 

function refreshToken(){
	$.get('refresh-csrf').done(function(data){
		csrfToken = data; // the new token
	});
}