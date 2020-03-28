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
		img = "";
		
		for(ii=0; ii<e.length; ii++){
			w = e[ii];
			if(v.pegawai_id==w.pegawai_id){
				nik = w.pegawai_NIK;
				name = w.pegawai_name;
				
				img = w.image;
				if(img==null || img.length<1){
					img = "";
				}else{
					img = digitasAssetApi + img[0].path;
				}
				
				break;
			}
		}
		
		$(cloned).css("display","table-row");
		$(cloned).addClass("deletable");
		
		$(cloned).find("td:nth-child(1)").html(i+1);
		$(cloned).find("td:nth-child(2)").html(nik);
		$(cloned).find("td:nth-child(3)").html(name);
		
		td4 = $(cloned).find("td:nth-child(4)");
		$(td4).find("img").attr("src",img);
		$(td4).find("a").attr("href",img);
		
		td5 = $(cloned).find("td:nth-child(5)");
		if(v.checkinDetail.length!=0 && v.checkinDetail!=null){
			if(v.checkinDetail.attendance_methode==2){
				id = v.checkinDetail.attendance_id;
				$(td5).find(".btn-primary").attr("onclick","fcManual(this,"+id+","+JSON.stringify(v)+",'in')");
				$(td5).find(".btn-primary").prop("disabled",false);
			}else{				
				$(td5).find(".btn-primary").prop("disabled",true);
			}
		}else{
			$(td5).find(".btn-primary").prop("disabled",true);
		}
		
		td6 = $(cloned).find("td:nth-child(6)");
		if(v.checkoutDetail.length!=0 && v.checkoutDetail!=null){
			if(v.checkoutDetail.attendance_methode==2){
				id = v.checkoutDetail.attendance_id;
				$(td6).find(".btn-danger").attr("onclick","fcManual(this,"+id+","+JSON.stringify(v)+",'in')");
				$(td6).find(".btn-danger").prop("disabled",false);
			}else{				
				$(td6).find(".btn-danger").prop("disabled",true);
			}
		}else{
			$(td6).find(".btn-danger").prop("disabled",true);
		}
		
		$("#fcm-employee").append(cloned);
	}
	
	$("#fcManualModal").modal("show");
}

function fcManual(t,id,v,m){
	console.log(v);
	return;
	s = 2;
	txt = "";
	
	if(m=="out"){
		s = 2;
		txt = "Check-out";
	}else if(m=="in"){
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
				$(t).prop("disabled",true);
			}else{
				showError(".container-agenda-fcm-alert", txt + " failed");
			}
		}
	});
}