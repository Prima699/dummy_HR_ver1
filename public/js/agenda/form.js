var openSubmitBtni = 0;
var openSubmitBtnLimit = 4;
var cityF = false;
var marked = false;
var address = false;

function openSubmitBtn(i){
	openSubmitBtni += i;
	if(openSubmitBtnLimit<=openSubmitBtni){
		$("#btn-submit").prop("disabled",false);
	}
}

function getCategory(){
	$("#category").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/category",
		type: "GET",
		success: function(r){
			$("#category").empty();
			if(r==false){
				getSessionError("div.container-agenda-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].category_agenda_id);
						$(opt).html(r[i].category_agenda_name);
						if(r[i].category_agenda_id==$("#category").data("value")){
							$(opt).prop("selected",true);
						}
					$("#category").append(opt);
				}
				$("#category").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			$("#category").prop("disabled",true);
		}
	});
}

function getProvince(){
	$("#province").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/province",
		type: "GET",
		success: function(r){
			$("#province").empty();
			if(r==false){
				getSessionError("div.container-agenda-alert");
			}else{
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_province);
						$(opt).html(r[i].name_province);
						if(r[i].ID_t_md_province==$("#province").data("value")){
							$(opt).prop("selected",true);
						}
					$("#province").append(opt);
				}
				$("#province").prop("disabled",false);
				openSubmitBtn(1);
				getCity($("#province").val());
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			$("#province").prop("disabled",true);
		}
	});
}

function getCity(province){
	$("#city").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/city?province=" + province,
		type: "GET",
		success: function(r){
			$("#city").empty();
			if(r==false){
				getSessionError("div.container-agenda-alert");
			}else if(cityF==false){
				for(var i=0; i<r.length; i++){
					var opt = document.createElement("option");
						$(opt).attr("value",r[i].ID_t_md_city);
						$(opt).html(r[i].name_city);
						if(r[i].ID_t_md_city==$("#city").data("value")){
							$(opt).prop("selected",true);
						}
					$("#city").append(opt);
				}
				$("#city").prop("disabled",false);
				openSubmitBtn(1);
				citiF = true;
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			$("#city").prop("disabled",true);
		}
	});
}

function getEmployee(){
	$(".employee").prop("disabled",true);
	$("#adddt2").prop("disabled",true);
	$.ajax({
		url: digitasLink + "/admin/agenda/employee",
		type: "GET",
		success: function(r){
			$(".employee").empty();
			if(r==false){
				getSessionError("div.container-agenda-alert");
				getSessionError("div.container-agenda-employee-alert");
			}else{
				for(var i=0; i<r.length; i++){
					for(var ii=0; ii<$(".employee").length; ii++){
						var opt = document.createElement("option");
							$(opt).attr("value",r[i].pegawai_id);
							$(opt).html(r[i].pegawai_name);
							if(r[i].pegawai_id==$($(".employee")[ii]).data("value")){
								$(opt).prop("selected",true);
							}
						$($(".employee")[ii]).append(opt);
					}
				}
				$(".employee").prop("disabled",false);
				$("#adddt2").prop("disabled",false);
				openSubmitBtn(1);
			}
		}, error: function(xhr,status,error){
			showError("div.container-agenda-alert",status+": "+error);
			showError("div.container-agenda-employee-alert",status+": "+error);
			$(".employee").prop("disabled",true);
			$("#adddt2").prop("disabled",true);
		}
	});
}

function adds(dt){
	$("#"+dt+" tbody tr:first").clone().appendTo("#"+dt+" tbody");
	
	$("#"+dt+" tbody tr:last input").val(null);
	$("#"+dt+" tbody tr:last textarea").val(null);
	$("#"+dt+" tbody tr:last select").val(null);
	$("#"+dt+" tbody tr:last input[type='hidden']").val(-1);
	
	dp("create");
	addressOnFocus();
}

function deletes(dt,type,a){
	if($("#" + dt + " tbody tr").length<2){
		showError("div.container-agenda-"+type+"-error","You can not leave it empty. At least one "+type+" per agenda.");
	}else{		
		$(a).parents("tr").remove();
	}
}

function initGoogleMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -6.930522, lng: 107.622624},
      zoom: 13
    });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // window.alert("Autocomplete's returned place contains no geometry");
			showError("container-agenda-map-error", "No geometry returned");
            return;
        }
  
        setMarker(place, map, marker, infowindow);
    });
}

function setMarker(place, map, marker, infowindow){
	// If the place has a geometry, then present it on a map.
	if (place.geometry.viewport) {
		map.fitBounds(place.geometry.viewport);
	} else {
		map.setCenter(place.geometry.location);
		map.setZoom(17);
	}
	marker.setIcon(({
		url: place.icon,
		size: new google.maps.Size(71, 71),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(17, 34),
		scaledSize: new google.maps.Size(35, 35)
	}));
	marker.setPosition(place.geometry.location);
	marker.setVisible(true);

	var address = '';
	if (place.address_components) {
		address = [
		  (place.address_components[0] && place.address_components[0].short_name || ''),
		  (place.address_components[1] && place.address_components[1].short_name || ''),
		  (place.address_components[2] && place.address_components[2].short_name || '')
		].join(' ');
	}

	infowindow.setContent('<div class="autocomplete-gmap"><strong>' + place.name + '</strong><br>' + address);
	infowindow.open(map, marker);
	
	$("#searchInput").val("");
	
	if($("#gmap-data").data("target")!="no data"){
		var target = $("#gmap-data").data("target");
		var parent = $(target).parent();
		
		$(target).val(place.formatted_address);
		$(parent).find("input[name='lng[]']").val(place.geometry.location.lng());
		$(parent).find("input[name='lat[]']").val(place.geometry.location.lat());
	}else{
		showError("container-agenda-map-error", "Unknown Error");
	}
}

function dp(m){
	var dpParams = {
		weekStart : 0,
		time: false,
		format : "DD-MM-YYYY"
	};
	
	var tpParams = {
		date: false,
		shortTime: true,
		format: "HH:mm"
	};
	
	if(m!="create"){
		var date = new Date(m);
		dpParams["currentDate"] = date;
	}
	
	$('.dp').bootstrapMaterialDatePicker(dpParams);
	
	$('.tp').bootstrapMaterialDatePicker(tpParams);
}

function addressOnFocus(){
	$("input[name='address[]']").on("focus",function(t){
		$("#gmap").modal("show");
		$("#gmap-data").data("target", t.target);
	});
}

$(document).ready(function() {
	getCategory();
	getProvince();
	getEmployee();
	
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
	
	$("#province").on("change",function(){
		getCity($("#province").val());
	});
	
	$('#gmap').on('hidden.bs.modal', function () {			
		$("#resultLocation").html("");
		$("#gmap-data").data("target", "no data");
	});
	
	addressOnFocus();
	
	dp("create");
} );