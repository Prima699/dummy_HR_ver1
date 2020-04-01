$(document).ready(function() {
	$("#button-save").prop("disabled", true);
	
	$("#password").on("keyup", function(){
		buttonSave();
	});
	
	$("#repassword").on("keyup", function(){
		buttonSave();
	});
} );

function buttonSave(){
	$("#password").removeClass("is-invalid");
	$("#repassword").removeClass("is-invalid");
	$("#password-result").html("");
	
	p = $("#password").val();
	r = $("#repassword").val();
	
	if(p==r){
		$("#button-save").prop("disabled", false);
		return;
	}
	
	$("#password").addClass("is-invalid");
	$("#repassword").addClass("is-invalid");
	$("#password-result").html("Password does not match");
	return;;
}