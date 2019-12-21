$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : API('data'),
		"lengthChange" : false,
		// "columns" : [
			// {
			// }
		// ]
	});
	
	$('#datatable').on( 'draw.dt', function () {
		var empty = $(".dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#datatable tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("td:nth-child(2)");
				var name = $(td).html();
				
				var td = $(tr[i]).find("td:last");
				var id = $(td).html();
				
				var act = action(name, id);
				$(td).html(act);
			}
		}
	} );
	
	function action(name, id){
		var info = generateInfo(name, id);
		var edit = generateEdit(name, id);
		var faceTrain = generateFaceTrain(name, id);
		
		var form = document.createElement("form");
			$(form).attr("method","post");
			$(form).attr("action",""+id);
			$(form).attr("style","display:inline;");
		$(form).append(info);
		$(form).append(edit);
		$(form).append(faceTrain);
		
		return form;
	}
	
	function generateInfo(name,id){
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-info");
			$(a).attr("href","" + id);
			$(a).attr("title","Detail " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			var span = document.createElement("span");
				$(span).attr("class","fas fa-file");
			$(a).append(span);
		return a;
	}

	function generateEdit(name,id){
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-warning");
			$(a).attr("href","" + id);
			$(a).attr("title","Edi " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
			$(a).append(span);
		return a;
	}
	
	function generateFaceTrain(name,id){
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-success text-white");
			$(a).attr("onclick","faceTrain('" + name + "'," + id + ")");
			$(a).attr("title","Face Train " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			var span = document.createElement("span");
				$(span).attr("class","fas fa-user");
			$(a).append(span);
		return a;
	}
	
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
				$(td).attr("class","text-center");
				$(td).html(generateImage($(td).html()));
				
				// face detect
				var td = $(tr[i]).find("td:nth-child(3)");
				$(td).html(generateProcess($(td).html(),'fd',id));
				
				// tag save
				var td = $(tr[i]).find("td:nth-child(4)");
				$(td).html(generateProcess($(td).html(),'ts',id));
				
				// face train
				var td = $(tr[i]).find("td:nth-child(5)");
				$(td).html(generateProcess($(td).html(),'ft',id));
			}
		}
	} );
	
	function generateImage(url){
		var img = document.createElement("img");
			$(img).attr("src",url);
			$(img).attr("height","100px");
			$(img).attr("title","Invalid image. Please delete it and re-upload.");
		return img;
	}
	
	function generateProcess(v,m,id){
		if(v=="" || v==null || v==undefined){
			var onclick = "";
			if(m=="fd"){
				onclick = "faceDetect(" + id + ")";
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
		"ajax" : API('image',id),
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

function faceDetect(id){
	$.ajax({
		url: API("detect"),
		type: "PUT",
		data: {
			id : id
		},
		success: function(result){
			faceTrainDT(g["idPegawai"]);
		}
	});
}