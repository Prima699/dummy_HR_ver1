$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : digitasLink + "/admin/announcement/data",
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
				
				var td = $(tr[i]).find("td:nth-child(3)");
				var content = $(td).html();
				if(content.length>80){					
					$(td).html(content.substring(0,70) + " ");
					$(td).append(readMore($(tr[i]).find("td:nth-child(2)").html(),content));
				}
				
				var td = $(tr[i]).find("td:nth-child(5)");
				var content = $(td).html();
				$(td).html(content.replace("-","<br>"));
				
				if(code>0){
					var td = $(tr[i]).find("td:nth-child(2)"); // get data action column / id record
					var name = $(td).html();
					
					var td = $(tr[i]).find("td:last");
					var id = $(td).html();
					
					// var act = action(name, id);
					// $(td).html(act);
				}
			}
		}
		getSessionError("div.container-announcement-alert");
		$('[data-toggle="popover"]').popover();
	} );
	
	function readMore(category,content){
		a = document.createElement("a");
			$(a).attr("href","#");
			$(a).attr("class","text-primary");
			$(a).attr("data-toggle","popover");
			$(a).attr("data-placement","auto");
			$(a).attr("data-trigger","focus");
			$(a).attr("data-title",category);
			$(a).attr("data-content",content);
			$(a).html("Read more");
		return a;
	}
	
	function action(name, id){ // create form action
		var info = generateInfo(name, id);
		var edit = generateEdit(name, id);
		
		var form = document.createElement("form");
			$(form).attr("method","post");
			$(form).attr("action",""+id);
			$(form).attr("style","display:inline;");
			
		$(form).append(info);
		// $(form).append(edit);
		
		return form;
	}
	
	function generateInfo(name,id){ // create button info
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

	function generateEdit(name,id){ // create button edit
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-warning");
			$(a).attr("href", digitasLink + "/admin/announcement/edit/" + id);
			$(a).attr("title","Edi " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
				$(a).append(span);
				
		return a;
	}

} );