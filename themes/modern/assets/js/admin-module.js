$(document).ready(function() {
	$('.switch').change(function()
	{
		var id_module = $(this).data('module-id');
		var switch_type = $(this).data('switch');
		var id_result = $(this).is(':checked') ? 1 : 3;
		$.ajax({
			type: "POST",
			url: module_url,
			data: 'id_module=' + id_module + '&id_result=' + id_result + '&switch_type=' + switch_type + '&change_module_attr=1&ajax=true',
			dataType: 'text',
			success: function(data) {
				if (data == 'ok') {
					if (switch_type == 'aktif') {
						var text = id_result == 1 ? 'Aktif' : 'Non Aktif';
						$('[data-status-text="'+id_module+'"]').html(text);
					}
				}
			},
			error: function(xhr) {
				console.log(xhr);
			}
		});
	})
});