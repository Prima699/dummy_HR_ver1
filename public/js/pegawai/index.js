$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : digitasLink + "/admin/employee/data",
		"lengthChange" : false,
        "processing" : true,
        "serverSide" : true,
		"pageLength" : 10
	}); // call datatable
	
	$('#datatable').on( 'draw.dt', function () {
		var empty = $(".dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#datatable tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("td:nth-child(2)");
				$(td).attr("title","National Identity Number");
				
				var td = $(tr[i]).find("td:nth-child(3)");
				$(td).css("text-align","left");
				
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
			$(a).attr("href",digitasLink + "/admin/employee/" + id);
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
			$(a).attr("href",digitasLink + "/admin/employee/edit/" + id);
			$(a).attr("title","Edit " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
			$(a).append(span);
		return a;
	}
	
	function generateFaceTrain(name,id){
		var a = document.createElement("a");
			$(a).attr("class","btn btn-sm btn-success text-white");
			$(a).attr("onclick","openModalFaceTrain('" + name + "'," + id + ")");
			$(a).attr("title","Face Train " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			var span = document.createElement("span");
				$(span).attr("class","fas fa-user");
			$(a).append(span);
		return a;
	}

} );