$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : digitasLink + "/admin/presence/variant/data?type=" + $("#data").data("id"),
		"lengthChange" : false,
        "processing" : true,
        "serverSide" : true,
		"pageLength" : 10
	}); // call datatable
	
	$('#datatable').on( 'draw.dt', function () { // event datatable on draw
		var empty = $(".dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#datatable tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("td:nth-child(1)"); // get data action column
				var name = $(td).html();
				
				var td = $(tr[i]).find("td:last");
				var id = $(td).html();
				
				var act = action(name, id);
				$(td).html(act);
			}
		}
		getSessionError("div.container-variant-alert");
	} ).on( 'error.dt', function ( e, settings, techNote, message ) {
		console.log("e",e);
		console.log("settings",settings);
		console.log("techNote",techNote);
		console.log("message",message);
		showError("div.container-variant-alert","Server unreachable.");
	} );
	
	function action(name, id){ // create form action
		var info = generateInfo(name, id);
		var edit = generateEdit(name, id);
		
		var form = document.createElement("form");
			$(form).attr("style","display:inline;");
			
		$(form).append(info);
		$(form).append(edit);
		
		return form;
	}
	
	function generateInfo(name,id){ // create button info
		var a = document.createElement("button");
			$(a).attr("class","btn btn-sm btn-info");
			$(a).attr("onclick","infoVariant(this)");
			$(a).attr("data-info",id);
			$(a).attr("type","button");
			$(a).attr("title","Detail " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-file");
				$(a).append(span);
			
		return a;
	}

	function generateEdit(name,id){ // create button edit
		var a = document.createElement("button");
			$(a).attr("class","btn btn-sm btn-warning");
			$(a).attr("onclick","editVariant(this)");
			$(a).attr("data-info",id);
			$(a).attr("type","button");
			$(a).attr("title","Edi " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
				$(a).append(span);
				
		return a;
	}

} );

function createVariant(){
	clearVariant();
	$("#variant-modal form").append($("input[name='_token']").clone());
	
	$("#variant-modal .modal-title").html("Create Variant");
	$("#variant-modal form").attr("action",$("#data").data("create"));
	
	tp();
	$("#variant-modal").modal("show");
}

function infoVariant(t){
	clearVariant();
	
	var data = $(t).data("info");
	
	$("#variant-modal #name").val(data.shift_name);
	$("#variant-modal #startDay").val(data.start_day);
	$("#variant-modal #endDay").val(data.end_day);
	$("#variant-modal #startWork").val(data.start_work);
	$("#variant-modal #endWork").val(data.end_work);
	$("#variant-modal #startBreak").val(data.start_break);
	$("#variant-modal #endBreak").val(data.end_break);
	
	$("#variant-modal input").prop("disabled",true);
	$("#variant-modal select").prop("disabled",true);
	$("#variant-modal button[type='submit']").css("display","none");
	$("#variant-modal .modal-title").html("Detail Variant");
	
	tp();
	$("#variant-modal").modal("show");
}

function editVariant(t){
	clearVariant();
	$("#variant-modal form").append($("input[name='_token']").clone());
	$("#variant-modal form").append($("input[name='_method']").clone());
	
	var data = $(t).data("info");
	
	$("#variant-modal #shiftID").val(data.presensi_type_shift_id);
	$("#variant-modal #name").val(data.shift_name);
	$("#variant-modal #startDay").val(data.start_day);
	$("#variant-modal #endDay").val(data.end_day);
	$("#variant-modal #startWork").val(data.start_work);
	$("#variant-modal #endWork").val(data.end_work);
	$("#variant-modal #startBreak").val(data.start_break);
	$("#variant-modal #endBreak").val(data.end_break);
	
	$("#variant-modal .modal-title").html("Edit Variant");
	$("#variant-modal form").attr("action",$("#data").data("edit"));
	
	tp();
	$("#variant-modal").modal("show");
}

function clearVariant(){
	$("#variant-modal input").val("");
	$("#variant-modal select").val("Sun");
	
	$("#variant-modal input").prop("disabled",false);
	$("#variant-modal select").prop("disabled",false);
	$("#variant-modal select#type").prop("disabled",true);
	$("#variant-modal select#type").val($("#data").data("id"));
	
	$("#variant-modal button[type='submit']").css("display","block");
	
	$("#variant-modal input[name='_token']").remove();
	$("#variant-modal input[name='_method']").remove();
	
	$(".tp").removeAttr("data-dtp");
}

function tp(){
	$('.tp').bootstrapMaterialDatePicker({
		date : false,
		format : "HH:mm",
		shortTime : true
	});
}