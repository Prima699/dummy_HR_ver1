$(document).ready(function(){
	setInterval(isSessionEnd, 30000); // 30 second 
	
	$("li.breadcrumb-item.active").html("<a>" + $("li.breadcrumb-item.active").html() + "</a>"); // adjusting breadcrumb
	
	setInterval(refreshToken, 60000); // 5 minute 
					
	var closeButton = setInterval(function(){
		$("button.close").click();
		clearInterval(closeButton);
	},10000);
});

function isSessionEnd(){ // check if session is ended or not
	var curr = window.location.href;
		curr = curr.replace(digitasLink,'');
	$.get(digitasLink + '/isSessionEnd?c='+curr).done(function(data){
		if(data==0){
			$("#app-notification-session-end").modal("show");
		}
	});
}

function refreshToken(){ // replenish csrf token
	$.get(digitasLink + '/refresh-csrf').done(function(data){
		var csrfToken = $('[name="csrf_token"]').attr('content');
		csrfToken = data; // the new token
	});
}