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

function create(){
	clear();
	dp("create");
	
	$("#modal form").append($("input[name='_token']").clone());
	$("#modal form").attr("action",digitasLink + "/admin/schedule/store");
	$("#modal form").attr("method","post");
	$("#modal .modal-title").html("Create Schedule");
	$("#modal").modal("show");
}

function edit(t){
	var d = $(t).data("d");
	
	clear();
	dp(d.work_day_start);
	
	$("#modal form").append($("input[name='_token']").clone());
	$("#modal form").append($("input[name='_method']").clone());
	$("#modal form").attr("action",digitasLink + "/admin/schedule/update/" + d.presensi_config_id);
	$("#modal form").attr("method","post");
	$("#modal .modal-title").html("Edit Schedule");
	$("#modal").modal("show");
}

function clear(){
	$("#modal #modalButtonSave").prop("disabled",true);
	$("#modal input:not(.fxd)").val("");
	$("#modal select:not(.fxd)").val("");
	$("#modal input[name='_token']").remove();
	$("#modal input[name='_method']").remove();
	$("#modal #endDate").html("");
	$("#modal #workDay").html("");
	$("#modal #offDay").html("");
}

function dp(m){
	if(m!="create"){
		var date = new Date(m);
		
		$('.dp').bootstrapMaterialDatePicker({
			weekStart : 0,
			time: false,
			format : "DD-MM-YYYY",
			currentDate : date
		});
		
		formed(date);
	}else{
		$('.dp').bootstrapMaterialDatePicker({
			weekStart : 0,
			time: false,
			format : "DD-MM-YYYY"
		});
	}
	$('.dp').on('change', function(e, date){
		formed(date);
		
		$("#modalButtonSave").prop("disabled",false);
	});
}

function formed(date){
	var type = dependencies.type;
		
	var d = new Date(date);
	var workStart = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
	
	d = new Date(d).addDays(type.work_day,1);
	var workEnd = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
	
	d = new Date(d).addDays(1,0);
	var offStart = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
	
	d = new Date(d).addDays(type.off_day,1);
	var offEnd = d.getDate() + "-" + d.getMonths() + "-" + d.getFullYear();
	
	$("#startDate").val(workStart);
	$("#endDate").html(offEnd);
	$("#workDay").html(workStart + " until " + workEnd);
	$("#offDay").html(offStart + " until " + offEnd);
	
	$("input[name='workStart']").val(workStart);
	$("input[name='workEnd']").val(workEnd);
	$("input[name='offStart']").val(offStart);
	$("input[name='offEnd']").val(offEnd);
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