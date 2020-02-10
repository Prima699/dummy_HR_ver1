var dependencies = {variant:[],type:[]};

function openSubmitBtn(){
	var tr = $("#paste tr").length;
	
	$("#btn-submit").prop("disabled",true);
	$(".btn-adds").prop("hidden",true);
	
	if( (tr<1 && dependencies.type.type==1) || (dependencies.type.type==0) ){
		$(".btn-adds").prop("hidden",false);
	}
	
	if(tr>0){
		$("#btn-submit").prop("disabled",false);
	}
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
		$(c).find("select").attr("title",v.shift_name);
		
		if(v.type==1 || v.type=="1"){
			readonly = v.presensi_type_shift_id;
			$(c).find("input").attr("placeholder","Fixed");
			$(c).find(".fxd").html("Fixed");
			break;
		}
	}
	
	if(dependencies.type.type==1){
		$(c).find(".dp").prop("disabled",true);
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

function dp(){
	$('.dp').bootstrapMaterialDatePicker({
		weekStart : 0,
		time: false,
		format : "DD-MM-YYYY"
	}).on('change', function(e, date){
		var type = dependencies.type;
		var parent = $(this).parents("tr")[0];
		
		var d = new Date(date);
		var workStart = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
		
		d = new Date(d).addDays(type.work_day,1);
		var workEnd = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
		
		d = new Date(d).addDays(1,0);
		var offStart = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
		
		d = new Date(d).addDays(type.off_day,1);
		var offEnd = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
		
		$(parent).find(".startDate").val(workStart);
		$(parent).find(".endDate").html(offEnd);
		$(parent).find(".workDay").html(workStart + "<br/>-<br/>" + workEnd);
		$(parent).find(".offDay").html(offStart + "<br/>-<br/>" + offEnd);
		
		$(parent).find("input[name='workStart[]']").val(workStart);
		$(parent).find("input[name='workEnd[]']").val(workEnd);
		$(parent).find("input[name='offStart[]']").val(offStart);
		$(parent).find("input[name='offEnd[]']").val(offEnd);
	});
}

$(document).ready(function() {
	dependencies["variant"] = $("#dependencies").data("variant");
	dependencies["type"] = $("#dependencies").data("type");
	
	openSubmitBtn();
	
	Date.prototype.addDays = function(days,min) {
		var date = new Date(this.valueOf());
		date.setDate(date.getDate() + parseInt(days) - parseInt(min));
		return date;
	}
	
	Date.prototype.getMonths = function(){
		var date = new Date(this.valueOf());
		return date.getMonth() + 1;
	}
	
	$('#dt1').DataTable({
		"lengthChange": false,
		"searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
	});
} );