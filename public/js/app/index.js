// $(document).ready(function(){
	// $.ajax({
		// url: digitasLink + "/isSessionEnd",
		// success: function(result){
			// alert(result);
		// }
	// });
// });

setInterval(isSessionEnd, 30000); // 30 second 

function isSessionEnd(){
	var curr = window.location.href;
		curr = curr.replace(digitasLink,'');
	$.get(digitasLink + '/isSessionEnd?c='+curr).done(function(data){
		if(data==0){
			$("#app-notification-session-end").modal("show");
		}
	});
}