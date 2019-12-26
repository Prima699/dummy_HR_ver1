$(document).ready(function(){
	setInterval(isSessionEnd, 30000); // 30 second 
	
	$("li.breadcrumb-item.active").html("<a>" + $("li.breadcrumb-item.active").html() + "</a>"); // adjusting breadcrumb
	
	setInterval(refreshToken, 60000); // 5 minute 
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
	if($('[name="_token"]').length!=0){
		$.get(digitasLink + '/refresh-csrf').done(function(data){
			var csrfToken = $('[name="_token"]').attr('value',data);
		});
	}
}