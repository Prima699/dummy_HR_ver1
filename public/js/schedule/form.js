var type = null;

function openSubmitBtn(){
	var e = $("#employee").prop("disabled");
	var v = $("#variant").prop("disabled");
	var t = $("#type").prop("disabled");
	if(e==false && v==false && t==false && type!=null){
		$("#btn-submit").prop("disabled",false);
	}
}

function getEmployee(){
	$("#employee").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/schedule/employee",
		type: "GET",
		success: function(r){
			$("#employee").empty();
			if(r==false){
				getSessionError("div.container-schedule-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].pegawai_id);
						$(opt).data("type",r[i].presensi_type_id);
						$(opt).html(r[i].pegawai_name);
						if(r[i].pegawai_id==$("#employee").data("value")){
							$(opt).prop("selected",true);
						}
					$("#employee").append(opt);
				}
				$("#employee").prop("disabled",false);
				openSubmitBtn();
				getType($("#employee option:selected").data("type"));
			}
		}, error: function(xhr,status,error){
			showError("div.container-schedule-alert",status+": "+error);
			$("#employee").prop("disabled",true);
		}
	});
}

function getType(id){
	$("#type").prop("disabled",true);
	if(id==null){
		showError("div.container-schedule-alert","Please complete this employee profile and configuration.");
	}else{
		type = id;
		$.ajax({
			url: digitasLink + "/admin/schedule/type",
			type: "GET",
			success: function(r){
				$("#type").empty();
				if(r==false){
					getSessionError("div.container-schedule-alert");
				}else{
					for(var i=0; i<r.length; i++){
						var opt = document.createElement("option");
							$(opt).attr("value",r[i].presensi_type_id);
							$(opt).html(r[i].presensi_type_name);
							if(r[i].presensi_type_id==id){
								$(opt).prop("selected",true);
							}
						$("#type").append(opt);
					}
					// $("#type").prop("disabled",false);
					openSubmitBtn();
				}
			}, error: function(xhr,status,error){
				showError("div.container-schedule-alert",status+": "+error);
				$("#type").prop("disabled",true);
			}
		});
	}
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
	getEmployee();
	
	$('#dt1').DataTable({
		"lengthChange": false,
		"searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
	});
	
	$("#employee").on("change",function(){
		getType($("#employee option:selected").data("type"));
	});
} );