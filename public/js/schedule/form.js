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
	
	$(c).prop("hidden",false);
	$(c).removeAttr("id");
	$(c).find("select").prop("disabled",false);
	$(c).find("input").prop("disabled",false);
	
	for(var i=0; i<dependencies.variant.length; i++){
		var v = dependencies.variant[i];
		var option = document.createElement("option");
			$(option).html(v.presensi_type_shift_id);
			$(option).attr("value",v.presensi_type_shift_id);
			$(option).data("item",v);
		$(c).find("select").append(option);
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