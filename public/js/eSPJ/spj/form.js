function submitBtn(az){
    sp2d = $("#sp2did").val();
    pengeluaran = $("#pengeluaran select[name='pengeluaranJenis[]']").length;

    $("#save").prop("disabled",true);

    if(sp2d==null || sp2d==""){
        if(az=="sp2d"){
            showError(".container-sp2d-alert","SP2D is required","warning");
        }
        return;
    }

    if(pengeluaran<1){
        if(az=="pengeluaran"){
            showError(".container-sp2d-alert","Pengeluaran is required","warning");
        }
        return;
    }

    $("#save").prop("disabled",false);
}

$(document).ready(function(){
	$("#save").prop("disabled",true);
	// const anElement = new AutoNumeric('#anggaran');

	// $('.dp').bootstrapMaterialDatePicker({
	// 	weekStart : 0,
	// 	shortTime: true,
	// 	format : "DD-MM-YYYY HH:mm"
	// });

	$("#sp2d").focus(function(){
		$("#sp2dModal").modal("show");
		$('#sp2d').blur();
	});

	$('#datatable').DataTable({
		"ajax" : digitasLink + "/api/espj/sp2d/data?a=active",
		"lengthChange" : false,
        "processing" : true,
        "serverSide" : true,
		"pageLength" : 5
	}); // call datatable

	$('#datatable').on( 'draw.dt', function () { // event datatable on draw
		var empty = $(".dataTables_empty").html();
		if(empty!="No data available in table"){
			var tr = $("#datatable tbody tr");
			for(var i=0; i<tr.length; i++){
				var td = $(tr[i]).find("td:nth-child(3)"); // get data action column / id record
				var name = $(td).html();

				var td = $(tr[i]).find("td:last");
				var id = $(td).html();

				var act = action(name, id);
				$(td).html(act);
			}
		}
		getSessionError("div.container-sp2d-alert");

		$(".sp2dBtn").on("click", function(){
			id = $(this).data("id");
			name = $(this).data("name");

			$("#data").attr("data-sp2did",id);
			$("#data").attr("data-sp2dname",name);

			$(".sp2dBtn").attr("class","btn btn-sm btn-info btn-icon btn-icon-mini sp2dBtn");
			$(this).attr("class","btn btn-sm btn-success btn-icon btn-icon-mini sp2dBtn");

			$("#sp2d").val(name);
            $("#sp2did").val(id);

            submitBtn("sp2d");
		});
    } );

    $("#addPengeluaran").on("click", function(){
        tr = document.createElement("tr");

        td = document.createElement("td");
        content = 0;
        $(td).html(content);
        $(tr).append(td);

        td = document.createElement("td");
        content = $("#data").find("select[name='pengeluaranJenis[]']").clone();
        $(td).html(content);
        $(tr).append(td);

        td = document.createElement("td");
        content = $("#data").find("input[name='pengeluaranFile[]']").clone();
        $(td).html(content);
        $(tr).append(td);

        td = document.createElement("td");
        content = $("#data").find("textarea[name='pengeluaranDesc[]']").clone();
        $(td).html(content);
        $(tr).append(td);

        td = document.createElement("td");
        content = $("#data").find("button").clone();
        $(td).html(content);
        $(tr).append(td);

        $("#pengeluaran tbody").append(tr);

        tr = $("#pengeluaran tbody tr");
        for(i=0; i<tr.length; i++){
            $(tr[i]).find("td:nth-child(1)").html(i+1);
        }

        submitBtn("pengeluaran");
    });

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
		btn = "btn-info";
		if($("#data").data("sp2did")==id){
			btn = "btn-success";
		}
		var a = document.createElement("button");
			$(a).attr("class","btn btn-sm " + btn + " btn-icon btn-icon-mini sp2dBtn");
			$(a).attr("style","margin-left: 5px; margin-right: 5px;");
			$(a).attr("type","button");
			$(a).data("id",id);
			$(a).data("name",name);

			var span = document.createElement("span");
				$(span).attr("class","fas fa-check");
				$(a).append(span);

		return a;
    }
});

function deletePengeluaran(a){
    $(a).parents('tr').remove();

    tr = $("#pengeluaran tbody tr");
    for(i=0; i<tr.length; i++){
        $(tr[i]).find("td:nth-child(1)").html(i+1);
    }

    submitBtn("pengeluaran");
}
