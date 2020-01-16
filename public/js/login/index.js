$(document).ready(function() {
	demo.checkFullPageBackgroundImage();
	
	getSessionError("div.container-login-alert");
});

var csrfToken = $('[name="csrf_token"]').attr('content');

setInterval(refreshToken, 60000); // 5 minute 

function refreshToken(){
	$.get(digitasLink + '/refresh-csrf').done(function(data){
		csrfToken = data; // the new token
	});
}