$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : digitasLink + "/api/espj/spj/data?a=" + $("#data").data("true"),
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
				var td = $(tr[i]).find("td:nth-child(1)");
				var code = $(td).html();
				
				if(code>0){
					var td = $(tr[i]).find("td:nth-child(2)"); // get data action column / id record
					var name = $(td).html();
					
					var td = $(tr[i]).find("td:last");
					var id = $(td).html();
					
					var act = action(name, id);
					$(td).html(act);
				}
			}
		}
		getSessionError("div.container-spj-alert");
	} );
	
	function action(name, id){ // create form action
		var info = generateInfo(name, id);
		var edit = generateEdit(name, id);
		var sign = generateSignature(name, id);
		var deletez = generateDelete(name, id);
		
		var form = document.createElement("div");
			$(form).attr("class","btn-group");
			$(form).attr("role","group");
		
		if($("#data").data("true")=="active"){			
			$(form).append(info);
		}else{
			$(form).append(info);			
			// $(form).append(edit);
			$(form).append(sign);
			$(form).append(deletez);
		}
		
		return form;
	}
	
	function generateInfo(name,id){ // create button info
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-info btn-icon btn-icon-mini btn-neutral");
			$(a).attr("href",digitasLink + "/admin/spj/" + id);
			$(a).attr("title","Detail " + name);
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-file");
				$(a).append(span);
			
		return a;
	}

	function generateEdit(name,id){ // create button edit
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-warning btn-icon btn-icon-mini btn-neutral");
			$(a).attr("href", digitasLink + "/admin/spj/edit/" + id);
			$(a).attr("title","Edit " + name);
			
			$(a).attr("href", "#");
			$(a).attr("onclick", "alert('under construction')");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
				$(a).append(span);
				
		return a;
	}

	function generateDelete(name,id){ // create button edit
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-danger btn-icon btn-icon-mini btn-neutral");
			$(a).attr("href", digitasLink + "/admin/spj/delete/" + id);
			$(a).attr("title","Delete " + name);
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-trash");
				$(a).append(span);
				
		return a;
	}

	function generateSignature(name,id){ // create button edit
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-primary btn-icon btn-icon-mini btn-neutral");
			$(a).attr("href", digitasLink + "/admin/spj/sign/" + id);
			$(a).attr("title","Sign " + name);
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-signature");
				$(a).append(span);
				
		return a;
	}

} );