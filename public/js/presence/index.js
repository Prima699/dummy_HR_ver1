function error(){
	$.ajax({
		url: digitasLink + "/getSessionError",
		type: "GET",
		success: function(r){
			if(r!=false){
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
					
				$("div.container-presence-alert").append(div);
				var interval = setInterval(function(){
					$("button.closeButtonPlease").click();
					clearInterval(interval);
				},10000);
			}
		}
	});
}

function status(v){
	$.ajax({
		url: digitasLink + "/employee/presence/status",
		data: {v:v},
		success: function(data){
			error();
			if(data!=null){
				$(".menu").prop("hidden",true);
				$(".takeAphoto").prop("hidden",false);
				$.getScript(digitasLink  + "/public/js/presence/capture.js", function(){
					// script is now loaded and executed.
					// put your dependent JS here.
				});
			}
		}
	});	
}