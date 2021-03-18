/*
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Autocomplete using PHP/MySQL and jQuery
*/

// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var keyword = $('#entreprise_cl_id').val();
	$.ajax({
		url: 'ajax_refresh.php',
		type: 'POST',
		data: {keyword:keyword},
		success:function(data){
			$('#entreprise_cl_list_id').show();
			$('#entreprise_cl_list_id').html(data);
		}
	});
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#entreprise_cl_id').val(item);
	// hide proposition list
	$('#entreprise_cl_list_id').hide();
}