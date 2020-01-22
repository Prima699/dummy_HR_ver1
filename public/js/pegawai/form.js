var openSubmitBtni = 0;
var openSubmitBtnLimit = 9;

function openSubmitBtn(i){
	openSubmitBtni += i;
	if(openSubmitBtnLimit<=openSubmitBtni){
		$("#btn-submit").prop("disabled",false);
	}
}

function getCountry(){
	var s = "#country";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/country",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_country);
						$(opt).html(r[i].name);
						if(r[i].ID_t_md_country==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
				getProvince($(s).val());
				$(s).on("change",function(){
					getProvince($(s).val());
				});
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getProvince(country){
	var s = "#province";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/province?country=" + country,
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_province);
						$(opt).html(r[i].name_province);
						if(r[i].ID_t_md_province==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
				getCity($(s).val());
				$(s).on("change",function(){
					getCity($(s).val());
				});
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getCity(province){
	var s = "#city";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/city?province=" + province,
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_city);
						$(opt).html(r[i].name_province);
						if(r[i].ID_t_md_city==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getDepartment(){
	var s = "#departement";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/departement",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].departemen_id);
						$(opt).html(r[i].departemen_name);
						if(r[i].departemen_id==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getJabatan(){
	var s = "#jabatan";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/jabatan",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				var space = function(a){
					var r = "";
					for(var i=0; i<a; i++){
						r = r + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					return r;
				}
				var loop = function(data,spc){
					for(var i=0; i<data.length; i++){
						var main = data[i].main;
						var child = data[i].child;
						var opt = document.createElement("option");
							$(opt).attr("value",main.jabatan_id);
							$(opt).html(space(spc) + main.jabatan_name);
							if(main.jabatan_id==$(s).data("value")){
								$(opt).prop("selected",true);
							}
						$(s).append(opt);
						if(child.length>0){
							loop(child,spc+1);
						}
					}
				}
				loop(r,0);
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getGolongan(){
	var s = "#golongan";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/golongan",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].golongan_id);
						$(opt).html(r[i].golongan_name);
						if(r[i].golongan_id==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getPresence(){
	var s = "#presence";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/presence",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].presensi_type_id);
						$(opt).html(r[i].presensi_type_name);
						if(r[i].presensi_type_id==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getOffice(){
	var s = "#office";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/office",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var t = "Cabang";
					if(r[i].pc_status==1){ t = "Utama"; }
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].perusahaan_cabang_id);
						$(opt).html(r[i].city_name + " (" + t + ")");
						if(r[i].perusahaan_cabang_id==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function getType(){
	var s = "#type";
	$(s).prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/employee/type",
		type: "GET",
		success: function(r){
			$(s).empty();
			if(r==false){
				getSessionError("div.container-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].id);
						$(opt).html(r[i].name);
						if(r[i].id==$(s).data("value")){
							$(opt).prop("selected",true);
						}
					$(s).append(opt);
				}
				$(s).prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-employee-alert",status+": "+error);
			$(s).prop("disabled",true);
		}
	});
}

function addPhoto(){
	var row = $(".div-photo-container .row:first").clone();
	$(".div-photo-container").append(row);
	
	$(".div-photo-container .row:last").prop("hidden",false);
	$(".div-photo-container .row:last input").prop("disabled",false);
}

function deletePhoto(t){
	$(t).parents(".row:first").remove();
}

$(document).ready(function() {
	getCountry();
	getDepartment();
	getGolongan();
	getPresence();
	getJabatan();
	getOffice();
	getType();
} );