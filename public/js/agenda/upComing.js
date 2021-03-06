$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : digitasLink + "/admin/agenda/data?agenda=upComing",
		"lengthChange" : false,
        "processing" : true,
        "serverSide" : true,
		"pageLength" : 10
	}); // call datatable
	
	$('#datatable').on( 'draw.dt', function () { // event datatable on draw
		var empty = $("#datatable .dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#datatable tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("td:nth-child(1)");
				var code = $(td).html();
				
				if(code>0){
					var td = $(tr[i]).find("td:nth-child(3)"); // get data action column / id record
					var name = $(td).html();
					
					var td = $(tr[i]).find("td:last");
					var id = $(td).html();
					
					var act = action(name, id);
					$(td).html(act);
				}
			}
		}
		getSessionError("div.container-agenda-alert");
	} );
	
	function action(name, id){ // create form action
		var info = generateInfo(name, id);
		var edit = generateEdit(name, id);
		
		var form = document.createElement("form");
			$(form).attr("method","post");
			$(form).attr("action",""+id);
			$(form).attr("style","display:inline;");
			
		$(form).append(edit);
		$(form).append(info);
		
		return form;
	}
	
	function generateInfo(name,id){ // create button info
		route = $("#data").data("route");
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-info");
			$(a).attr("href",digitasLink + "/admin/" + route + "/" + id);
			$(a).attr("title","Detail " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-file");
				$(a).append(span);
			
		return a;
	}

	function generateEdit(name,id){ // create button edit
		route = $("#data").data("route");
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-warning");
			$(a).attr("href", digitasLink + "/admin/" + route + "/edit/" + id);
			$(a).attr("title","Edi " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
				$(a).append(span);
				
		return a;
	}

} );