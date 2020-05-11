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

function detailCheck(t){
    var id = $(t).data("id");
    var name = $(t).data("name");
    var attendance = $(".attendance");

    $("#dc-pegawai").html(name);
    $("#detailCheck .modal-body .nav-tabs").html("");
    $("#detailCheck .modal-body .tab-content").html("");

    for(i=0; i<attendance.length; i++){
        detail = $(attendance[i]).data("detail");
        console.log(detail);
        att = detail.attendance;
        date = new Date(detail.agenda_detail_date);
            date = date.getDate() + "-" + (1+date.getMonth()) + "-" + date.getFullYear();

        li = $("#copy-nav-item").clone();
            $(li).removeAttr("id");
            $(li).css("display","list-item");
            $(li).find("a").attr("href","#check-" + detail.agenda_detail_id);
            $(li).find("a").html(date);
            if(i!=0){
                $(li).find("a").attr("class","nav-link");
            }
        $("#detailCheck .modal-body .nav-tabs").append(li);

        pane = $("#copy-tab-pane").clone();
            $(pane).attr("id","check-" + detail.agenda_detail_id);
            $(pane).css("display","block");
        for(ii=0; ii<att.length; ii++){
            if(att[ii].pegawai_id!=id){
                continue;
            }
            console.log(att[ii]);
            tr = $("#copy-pane-tr").clone();
                $(tr).removeAttr("id");
                $(tr).css("display","table-row");
            if(att[ii].checkin==true){
                d = att[ii].checkinDetail;
                for(iii=0; iii<d.length; iii++){
                    img = digitasAssetApi + "assets/images/attendance_attemp/" + d[iii].attendance_image;
                    txt = d[iii].attendance_ts;
                    card = $("#copy-pane-image").clone();
                        $(card).removeAttr("id");
                        $(card).css("display","flex");
                        $(card).find("img").attr("src",img);
                        $(card).find("p").html(txt);
                        $(tr).find("td:nth-child(1)").append(card);
                }
            }else{
                $(tr).find("td:nth-child(1)").append("<p>Belum check in</p>");
            }
            if(att[ii].checkout==true){
                d = att[ii].checkoutDetail;
                for(iii=0; iii<d.length; iii++){
                    img = digitasAssetApi + "assets/images/attendance_attemp/" + d[iii].attendance_image;
                    txt = d[iii].attendance_ts;
                    card = $("#copy-pane-image").clone();
                        $(card).removeAttr("id");
                        $(card).css("display","flex");
                        $(card).find("img").attr("src",img);
                        $(card).find("p").html(txt);
                        $(tr).find("td:nth-child(2)").append(card);
                }
            }else{
                $(tr).find("td:nth-child(2)").append("<p>Belum check out</p>");
            }
            $(pane).find("tbody").append(tr);
        }
        $("#detailCheck .modal-body .tab-content").append(pane);
    }

	$("#detailCheck").modal("show");
}

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
	// console.log(v);
	// return;
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
