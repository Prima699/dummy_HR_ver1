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

function getSessionError(parent){
	$.ajax({
		url: digitasLink + "/getSessionError",
		type: "GET",
		success: function(r){
			if(r=="Access token not granted"){
				window.location = digitasLink + "/login";
			}else if(r!=false){
				var div = document.createElement("div");
					$(div).attr("class","alert alert-danger alert-dismissible fade show");
					$(div).attr("role","alert");
					
					var txt = document.createTextNode(r);
					$(div).append(txt);
					
					var btn = document.createElement("button");
						$(btn).attr("type","button");
						$(btn).attr("class","close closeButtonPlease");
						$(btn).attr("data-dismiss","alert");
						$(btn).attr("aria-label","Close");
						
						var span = document.createElement("span");
							$(span).attr("aria-hidden","true");
							$(span).html("&times;");
							$(btn).append(span);
							
					$(div).append(btn);
					
				$(parent).append(div);
				// var interval = setInterval(function(){
					// $("button.closeButtonPlease").click();
					// clearInterval(interval);
				// },10000);
			}
		}
	});
}

function showError(parent,text,color="danger"){
	var div = document.createElement("div");
		$(div).attr("class","alert alert-"+ color +" alert-dismissible fade show");
		$(div).attr("role","alert");
		
		var txt = document.createTextNode(text);
		$(div).append(txt);
		
		var btn = document.createElement("button");
			$(btn).attr("type","button");
			$(btn).attr("class","close closeButtonPlease");
			$(btn).attr("data-dismiss","alert");
			$(btn).attr("aria-label","Close");
			
			var span = document.createElement("span");
				$(span).attr("aria-hidden","true");
				$(span).html("&times;");
				$(btn).append(span);
				
		$(div).append(btn);
		
	$(parent).append(div);
}