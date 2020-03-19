$(document).ready(function() {
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


function fcManualModal(t){
	var d = $(t).data("detail");
	var date = $(t).data("date");
	var e = $(t).data("employee");
	
	$("#fcm-employee .deletable").remove();
	$("#fcm-date").html("");
	$("#fcm-address").html("");
	
	$("#fcm-date").html(date);
	$("#fcm-address").html("address");
	
	for(i=0; i<d.attendance.length; i++){
		v = d.attendance[i];
		cloned = $("#copy").clone();
		nik = "";
		name = "";
		id = 0;
		
		for(ii=0; ii<e.length; ii++){
			w = e[ii];
			if(v.pegawai_id==w.pegawai_id){
				nik = w.pegawai_NIK;
				name = w.pegawai_name;
				id = w.id_attendance;
				break;
			}
		}
		
		$(cloned).css("display","table-row");
		$(cloned).addClass("deletable");
		
		$(cloned).find("td:nth-child(1)").html(i+1);
		$(cloned).find("td:nth-child(2)").html(nik);
		$(cloned).find("td:nth-child(3)").html(name);
		
		td4 = $(cloned).find("td:nth-child(4)");
		onclick = "fcManual(this,"+id+","+v.checkin+","+v.checkout+")";
		if(v.checkin==true){
			if(v.checkout==true){
				$(td4).find(".btn-success").css("display","inline-block");
			}else if(v.checkout==false){				
				$(td4).find(".btn-danger").css("display","inline-block");
				$(td4).find(".btn-danger").attr("onclick","fcManual(this,"+id+","+v.checkin+","+v.checkout+")");
			}
		}else if(v.checkin==false){
			$(td4).find(".btn-primary").css("display","inline-block");
			$(td4).find(".btn-primary").attr("onclick","fcManual(this,"+id+","+v.checkin+","+v.checkout+")");
		}
		
		$("#fcm-employee").append(cloned);
	}
	
	$("#fcManualModal").modal("show");
}

function fcManual(t,id,iz,out){
	s = 2;
	txt = "";
	
	if(iz==true){
		if(out==true){
			return;
		}else if(out==false){
			s = 2;
			txt = "Check-out";
		}
	}else if(iz==false){
		s = 1;
		txt = "Check-in";
	}
	
	$.ajax({
		url : $("#data").data("fcm-route"),
		type : "post",
		data : {
			id : id,
			status : s,
			_token : $("input[name='_token']").val()
		},
		success : function(r){
			if(r==true){
				showError(".container-agenda-fcm-alert", "Success " + txt, "success");
				$(t).css("display","none");
				parent = $(t).parent();
				if(s==1){					
					$(parent).find(".btn-danger").css("display","inline-block");
					$(parent).find(".btn-danger").attr("onclick","fcManual(this,"+id+",true,false)");
				}else if(s==2){
					$(parent).find(".btn-success").css("display","inline-block");
				}
			}else{
				showError(".container-agenda-fcm-alert", txt + " failed");
			}
		}
	});
}