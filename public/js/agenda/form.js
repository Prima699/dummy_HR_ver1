var openSubmitBtni = 0;
var openSubmitBtnLimit = 4;

function openSubmitBtn(i){
	openSubmitBtni += i;
	if(openSubmitBtnLimit<=openSubmitBtni){
		$("#btn-submit").prop("disabled",false);
	}
}

function getCategory(){
	$("#category").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/category",
		type: "GET",
		success: function(r){
			if(r==false){
				getSessionError("div.container-agenda-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].category_agenda_id);
						$(opt).html(r[i].category_agenda_name);
						if(r[i].category_agenda_id==$("#category").data("value")){
							$(opt).prop("selected",true);
						}
					$("#category").append(opt);
				}
				$("#category").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			$("#category").prop("disabled",true);
		}
	});
}

function getProvince(){
	$("#province").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/province",
		type: "GET",
		success: function(r){
			if(r==false){
				getSessionError("div.container-agenda-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_province);
						$(opt).html(r[i].name_province);
						if(r[i].ID_t_md_province==$("#province").data("value")){
							$(opt).prop("selected",true);
						}
					$("#province").append(opt);
				}
				$("#province").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			$("#province").prop("disabled",true);
		}
	});
}

function getCity(){
	$("#city").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/city",
		type: "GET",
		success: function(r){
			if(r==false){
				getSessionError("div.container-agenda-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_city);
						$(opt).html(r[i].name_city);
						if(r[i].ID_t_md_city==$("#city").data("value")){
							$(opt).prop("selected",true);
						}
					$("#city").append(opt);
				}
				$("#city").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			$("#city").prop("disabled",true);
		}
	});
}

function getEmployee(){
	$(".employee").prop("disabled",true);
	$("#adddt2").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/employee",
		type: "GET",
		success: function(r){
			if(r==false){
				getSessionError("div.container-agenda-alert");
				getSessionError("div.container-agenda-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					for(var ii=0; ii<$(".employee").length; ii++){
						var opt = document.createElement("option");
							$(opt).attr("value",r[i].pegawai_id);
							$(opt).html(r[i].pegawai_name);
							if(r[i].pegawai_id==$($(".employee")[ii]).data("value")){
								$(opt).prop("selected",true);
							}
						$($(".employee")[ii]).append(opt);
					}
				}
				$(".employee").prop("disabled",false);
				$("#adddt2").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			showError("div.container-agenda-employee-alert",status+": "+error);
			$(".employee").prop("disabled",true);
			$("#adddt2").prop("disabled",true);
		}
	});
}

function adds(dt){
	$("#"+dt+" tbody tr:first").clone().appendTo("#"+dt+" tbody");
	
	$("#"+dt+" tbody tr:last input").val(null);
	$("#"+dt+" tbody tr:last textarea").val(null);
	$("#"+dt+" tbody tr:last select").val(null);
	$("#"+dt+" tbody tr:last input[type='hidden']").val(-1);
}

function deletes(dt,type,a){
	if($("#" + dt + " tbody tr").length<2){
		showError("div.container-agenda-"+type+"-error","You can not leave it empty. At least one "+type+" per agenda.");
	}else{		
		$(a).parents("tr").remove();
	}
}

$(document).ready(function() {
	getCategory();
	getProvince();
	getCity();
	getEmployee();
	
	$('#dt1').DataTable({
		"lengthChange": false,
		"searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
	});
	$('#dt2').DataTable({
		"lengthChange": false,
		"searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
	});
} );