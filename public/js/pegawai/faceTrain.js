$(document).ready(function() {
	$('#faceTrainDT').on( 'draw.dt', function () {
		var empty = $(".dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#faceTrainDT tbody tr");
			for(var i=0; i<tr.length; i++){
				// action
				var td = $(tr[i]).find("td:nth-child(6)");
				var id = $(td).html();
				$(td).html(generateActionFT(id));
				
				// image
				var td = $(tr[i]).find("td:nth-child(2)");
				var img = $(td).html();
				$(td).attr("class","text-center");
				$(td).html(generateImage(img));
				
				// face detect
				img = "http://attendance.teaq.co.id/assets/images/dewan/farhan.jpeg";
				var td = $(tr[i]).find("td:nth-child(3)");
				$(td).html(generateProcess(img,$(td).html(),'fd',id,i+1));
				
				// tag save
				var td = $(tr[i]).find("td:nth-child(4)");
				$(td).html(generateProcess(img,$(td).html(),'ts',id,i+1));
				
				// face train
				var td = $(tr[i]).find("td:nth-child(5)");
				$(td).html(generateProcess(img,$(td).html(),'ft',id,i+1));
			}
		}
		
		$.ajax({
			url: digitasLink + "/getSessionError",
			type: "GET",
			success: function(r){
				if(r!=false){
					var div = document.createElement("div");
						$(div).attr("class","alert alert-danger alert-dismissible fade show");
						$(div).attr("role","alert");
						
						var txt = document.createTextNode(r);
						$(div).append(txt);
						
						var btn = document.createElement("button");
							$(btn).attr("type","button");
							$(btn).attr("class","close closeButtonPlease");
							$(btn).attr("data-dismiss","alert");
							$(btn).attr("aria-label","Close");
							
							var span = document.createElement("span");
								$(span).attr("aria-hidden","true");
								$(span).html("&times;");
								$(btn).append(span);
								
						$(div).append(btn);
						
					$("div.container-category-image-alert").append(div);
					var interval = setInterval(function(){
						$("button.closeButtonPlease").click();
						clearInterval(interval);
					},10000);
				}
			}
		});
	} );
	
	function generateImage(url){
		var a = document.createElement("a");
			$(a).attr("target","_blank");
			$(a).attr("href",url);
		
			var img = document.createElement("img");
				$(img).attr("src",digitasLink + "/public/" + url);
				$(img).attr("height","100px");
				$(img).attr("title","Invalid image. Please delete it and re-upload.");
				$(a).html(img);
		
		return a;
	}
	
	function generateProcess(tr,v,m,id,i){
		if(v=="" || v==null || v==undefined){
			var onclick = "";
			if(m=="fd"){
				onclick = "faceDetect('" + tr + "'," + id + "," + i + ")";
			}
			
			var a = document.createElement("a");
				$(a).attr("class","btn btn-sm btn-warning text-white");
				$(a).attr("onclick",onclick);
				$(a).attr("style","margin-left: 5px; margin-right: 5px;");
				var txt = document.createTextNode("Process");
				$(a).html(txt);
			return a;
		}else{
			var span = document.createElement("span");
				$(span).attr("class","fa fa-user-check");
				$(span).attr("title","succeed");
			return span;
		}
	}
	
	function generateActionFT(id){
		var btn = document.createElement("button");
			$(btn).attr("class","btn btn-danger btn-sm");
			$(btn).attr("title","Delete");
			$(btn).attr("onclick",id);
			
			var span = document.createElement("span");
				$(span).attr("class","fa fa-trash");
				$(btn).html(span);
			
		return btn;
	}

} );

var g = {};
	g["idPegawai"] = 0;

function faceTrain(name,id){
	g["idPegawai"] = id;
	faceTrainDT(id);
	
	$("#faceTrain .modal-title").html(name);
	$("#faceTrain").modal("show");
}

function faceTrainDT(id){
	$('#faceTrainDT').DataTable().destroy();
	$('#faceTrainDT').DataTable({
		"ajax" : digitasLink + "/admin/pegawai/image/" + id,
		"lengthChange" : false,
		"searching" : false,
        "processing" : true,
        "serverSide" : true,
		"pageLength" : 5,
		"columnDefs": [
			{ "width": "5%", "targets": 0 },
			{ "width": "5%", "targets": 2 },
			{ "width": "5%", "targets": 3 },
			{ "width": "5%", "targets": 4 },
			{ "width": "5%", "targets": 5 }
		]
	}); // call datatable
}

function callback(data, img, id, field) {
	if(field == 'face_detect'){
		field = "face_detect";
	}else if (field == 'tag'){
		field = "tag";
	}else if (field == 'train'){
		field = "save";
	}
	
	$.ajax({
		url: digitasLink + "/admin/pegawai/face",
		type: "PUT",
		data: {
			train : id,
			process : field,
			value : JSON.stringify(data),
			_token : $("[name='_token']").val()
		},
		success: function(result){
			faceTrainDT(g["idPegawai"]);
		}
	});
}

function faceDetect(image,id,i){
	var client = new FCClientJS('d0p5debv2gij5e0nlt7b5tq98c', '75lm13qfkds2ti0gfjj9kaelsb');
	var options = new Object();
	options.detect_all_feature_points = true;

	var facedetect = client.facesDetect(image, null, options, callback, i, id, 'face_detect');
}