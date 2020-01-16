$(document).ready(function() {	
	$('#dt1').on( 'draw.dt', function () { // event datatable on draw
		var empty = $("#dt1 .dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#dt1 tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("th:nth-child(1)");
				var code = $(td).html();
				
				if(code>0){
					var td = $(tr[i]).find("th:nth-child(3)"); // get data action column / id record
					var name = $(td).html();
					
					var td = $(tr[i]).find("th:last");
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
		
		var form = document.createElement("form");
			$(form).attr("method","post");
			$(form).attr("action",""+id);
			$(form).attr("style","display:inline;");
			
		$(form).append(info);
		
		return form;
	}
	
	function generateInfo(name,id){ // create button info
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-info");
			$(a).attr("href",digitasLink + "/employee/agenda/" + id);
			$(a).attr("title","Detail " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-file");
				$(a).append(span);
			
		return a;
	}
	
	
	$('#dt1').DataTable({
		"lengthChange": false,
		"searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false
	});

} );