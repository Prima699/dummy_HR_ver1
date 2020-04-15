$(document).ready(function(){
	$("#save").prop("disabled",true);
	const anElement = new AutoNumeric('#anggaran');
	
	$('.dp').bootstrapMaterialDatePicker({
		weekStart : 0,
		shortTime: true,
		format : "DD-MM-YYYY HH:mm"
	});
	
	$("#st").focus(function(){
		$("#stModal").modal("show");
		$('#st').blur();
	});
	
	$('#datatable').DataTable({
		"ajax" : digitasLink + "/api/espj/st/data",
		"lengthChange" : false,
        "processing" : true,
        "serverSide" : true,
		"pageLength" : 5
	}); // call datatable
	
	$('#datatable').on( 'draw.dt', function () { // event datatable on draw
		var empty = $(".dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#datatable tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("td:nth-child(2)"); // get data action column / id record
				var name = $(td).html();
				
				var td = $(tr[i]).find("td:last");
				var id = $(td).html();
				
				var act = action(name, id);
				$(td).html(act);
			}
		}
		getSessionError("div.container-sp2d-alert");
	
		$(".stBtn").on("click", function(){
			id = $(this).data("id");
			name = $(this).data("name");
			
			$("#data").attr("data-stid",id);
			$("#data").attr("data-stname",name);
			
			$(".stBtn").attr("class","btn btn-sm btn-info btn-icon btn-icon-mini stBtn");
			$(this).attr("class","btn btn-sm btn-success btn-icon btn-icon-mini stBtn");
			
			$("#st").val(name);
			$("#stid").val(id);
			
			$.ajax({
				url: digitasLink + "/api/espj/st/" + id,
				data: {
					uid: $("#data").data("uid"),
					at: $("#data").data("at")
				},complete: function(xhr,status){
					r = xhr.responseJSON;
					agenda_id = r.agenda_id;
					if(agenda_id!=undefined && agenda_id!=null && agenda_id!=""){
						$("#save").prop("disabled",false);
						
						$("#kegiatan").val(r.agenda_desc);
						$("#kategori").val(r.category_agenda_name);
						$("#berangkat").val(r.agenda_date);
						$("#kembali").val(r.agenda_date_end);
						
						$("#pegawai tbody").html("");
						for(i=0; i<r.anggota_dewan.length; i++){
							dewan = r.anggota_dewan[i];
							rec = "<tr>";
							rec += "<td>" + (i+1) + "</td>";
							rec += "<td>" + dewan.pegawai_name + "</td>";
							rec += "<td>" + dewan.pegawai_NIK + "</td>";
							rec += "<td>" + dewan.pegawai_telp + "</td>";
							rec += "<td><img src='" + digitasAssetApi + dewan.image[0].path + "' style='max-width:120px; max-height:200px;' /></td>";
							rec += "</tr>";
							$("#pegawai tbody").append(rec);
						}
						
						$("#tujuan tbody").html("");
						for(i=0; i<r.detail_agenda.length; i++){
							detail = r.detail_agenda[i];
							rec = "<tr>";
							rec += "<td>" + (i+1) + "</td>";
							rec += "<td>" + detail.agenda_detail_address + "</td>";
							rec += "<td>" + detail.agenda_detail_date + "<br/>" + detail.agenda_detail_time_start + "</td>";
							rec += "<td>" + detail.agenda_detail_date + "<br/>" + detail.agenda_detail_time_end + "</td>";
							rec += "</tr>";
							$("#tujuan tbody").append(rec);
						}
					}else{
						$("#save").prop("disabled",true);
						showError("div.container-modal-sp2d-alert","Unknown Error","danger");
					}
				}
			});
		});
	} );
	
	function action(name, id){ // create form action
		var info = generateInfo(name, id);
		
		var form = document.createElement("form");
			$(form).attr("method","post");
			$(form).attr("action",""+id);
			$(form).attr("style","display:inline;");
			
		$(form).append(info);
		
		return form;
	}
	
	function generateInfo(name,id){ // create button info
		btn = "btn-info";
		if($("#data").data("stid")==id){
			btn = "btn-success";
		}
		var a = document.createElement("button");
			$(a).attr("class","btn btn-sm " + btn + " btn-icon btn-icon-mini stBtn");
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			$(a).attr("type","button");
			$(a).data("id",id);
			$(a).data("name",name);
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-check");
				$(a).append(span);
			
		return a;
	}
});