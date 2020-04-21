jQuery(document).ready(function () {
	$('body').delegate('#check-all', 'click', function() {
		var prop = $(this).prop('checked');
		$('#check-all-wrapper').find('input[type="checkbox"]').prop('checked', prop);
	});
	
	$('body').delegate('a[data-action="remove-role"]', 'click', function() {
		console.log(current_url + '?action=delete-role');
		$this = $(this);
		// Module - User id
		pair_id = $this.attr('data-pair-id');
		id_role = $this.attr('data-role-id');
		$.ajax({
			type: 'POST',
			url: current_url + '?action=delete-role',
			data: 'pair_id='+ pair_id +'&id_role=' + id_role,
			dataType: 'text',
			success: function (data) {
				data = $.parseJSON(data);
				// console.log(data);
				if (data.status == 'ok') 
				{
					$this.parent().remove();
				} else {
					Swal.fire({
						title: 'Error !!!',
						html: data.message,
						type: 'error',
						showCloseButton: true,
						confirmButtonText: 'OK'
					})
				}
			},
			error: function (xhr) {
				console.log(xhr.responseText);
			}
		})
	});
	
	$('.toggle-role').click(function(e) {
		
	
		$this = $(this);
		if ($this.is(':checked')) {
			
			$this.parent().next().show();
		} else {
			$this.parent().next().hide();
		}
	});
});