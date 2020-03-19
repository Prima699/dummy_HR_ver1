function dp(){
	$('.dp').bootstrapMaterialDatePicker({
		weekStart : 0,
		time: false,
		format : "DD-MM-YYYY"
	});
}

$(document).ready(function() {
	dp();
} );