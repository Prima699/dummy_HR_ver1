var dependencies = {variant:[]};

function openSubmitBtn(){
	var alert = $(".container-schedule-alert .alert").length;
	
	var tr = $("#paste tr").length;
	
	$("#btn-submit").prop("disabled",true);
	if(alert<=0 && tr>1){
		$("#btn-submit").prop("disabled",false);
	}
}

function dp(){
	$("input.dp").datepicker({
		format: "dd-mm-yyyy",
		// calendarWeeks: true,
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		todayHighlight: true
	});
}

function adds(){
	var c = $("#copy").clone();
	var readonly = false;
	
	$(c).prop("hidden",false);
	$(c).removeAttr("id");
	$(c).find("select").prop("disabled",false);
	$(c).find("input:not(.variant)").prop("disabled",false);
	
	for(var i=0; i<dependencies.variant.length; i++){
		var v = dependencies.variant[i];
		
		var option = document.createElement("option");
			$(option).html(v.shift_name);
			$(option).attr("value",v.presensi_type_shift_id);
			$(option).data("item",v);
		$(c).find("select").append(option);
		
		if(v.type==1 || v.type=="1"){
			$(".btn-adds").prop("hidden",true);
			readonly = v.presensi_type_shift_id;
			break;
		}
	}
	
	if(readonly!=false){
		$(c).find("select").prop("disabled",true);
		$(c).find(".variant").prop("disabled",false);
		$(c).find(".variant").val(readonly);
	}
	
	$("#paste").append(c);
	
	dp();
	openSubmitBtn();
}

function deletes(a){
	$(a).parents("tr").remove();
	
	openSubmitBtn();
}

$(document).ready(function() {
	dependencies["variant"] = $("#dependencies").data("variant");
	
	adds();
	
	$('#dt1').DataTable({
		"lengthChange": false,
		"searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
	});
} );