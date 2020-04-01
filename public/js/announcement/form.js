var openSubmitBtni = 0;
var openSubmitBtnLimit = 2;

function openSubmitBtn(i){
	openSubmitBtni += i;
	if(openSubmitBtnLimit<=openSubmitBtni){
		$("#btn-submit").prop("disabled",false);
	}
}

function getCategory(){
	$("#category").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/announcement/category",
		type: "GET",
		success: function(r){
			$("#category").empty();
			if(r==false){
				getSessionError("div.container-announcement-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].message_category_id);
						$(opt).html(r[i].message_category_name);
						if(r[i].message_category_id==$("#category").data("value")){
							$(opt).prop("selected",true);
						}
					$("#category").append(opt);
				}
				$("#category").prop("disabled",false);
				openSubmitBtn(1);
				getDepartment();
			}
		}, error: function(xhr,status,error){
			showError("div.container-announcement-alert",status+": "+error);
			$("#category").prop("disabled",true);
		}
	});
}

function getDepartment(){
	$("#department").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/announcement/department",
		type: "GET",
		success: function(r){
			$("#department").empty();
			if(r==false){
				getSessionError("div.container-announcement-alert");
			}else{
				opt = document.createElement("option");
					$(opt).attr("value",0);
					$(opt).html("All");
				$("#department").append(opt);
				for(var i=0; i<r.length; i++){
					opt = document.createElement("option");
						$(opt).attr("value",r[i].departemen_id);
						$(opt).html(r[i].departemen_name);
						if(r[i].departemen_id==$("#department").data("value")){
							$(opt).prop("selected",true);
						}
					$("#department").append(opt);
				}
				$("#department").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-announcement-alert",status+": "+error);
			$("#department").prop("disabled",true);
		}
	});
}

$(document).ready(function(){
	$("#btn-submit").prop("disabled",true);
	
	getCategory();
});