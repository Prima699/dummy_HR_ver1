$(document).ready(function() {
    $('#datatable').DataTable({
		"ajax" : dataTableAPI(),
		"lengthChange" : false,
		// "columns" : [
			// {
			// }
		// ]
	});
} );