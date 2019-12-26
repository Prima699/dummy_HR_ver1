$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : digitasLink + "/admin/category/data",
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
						
					$("div.container-category-alert").append(div);
					var interval = setInterval(function(){
						$("button.closeButtonPlease").click();
						clearInterval(interval);
					},10000);
				}
			}
		});
	} );
	
	function action(name, id){ // create form action
		var info = generateInfo(name, id);
		var edit = generateEdit(name, id);
		
		var form = document.createElement("form");
			$(form).attr("method","post");
			$(form).attr("action",""+id);
			$(form).attr("style","display:inline;");
			
		// $(form).append(info);
		$(form).append(edit);
		
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
			$(a).attr("href", digitasLink + "/admin/category/edit/" + id);
			$(a).attr("title","Edi " + name);
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			
			var span = document.createElement("span");
				$(span).attr("class","fas fa-edit");
				$(a).append(span);
				
		return a;
	}

} );