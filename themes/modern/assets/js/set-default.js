jQuery(document).ready(function () {
	$('input[type=radio]').click(function(){
		
		$this = $(this);
		
		// console.log($this.attr('data-id'));
		if ($this.attr('data-checked') == 1)
			return;
		
		$radio = $('table').find('input[type=radio]');
		$radio.attr('disabled', 'disabled');
		
		$.ajax({
			method: "POST",
			url: module_url + '?action=set-default',
			data: { id: $this.attr('data-id'), submit: 'submit' },
			success: function(data) {
				json = $.parseJSON(data);
				console.log(json);
				type = json.msg.status == 'ok' ? 'success' : 'error';
				title = json.msg.status == 'ok' ? 'SUKSES!!!' : 'ERROR!!!';
				if (type == 'success') {
					$('input[type=radio]').attr('data-checked', 0);
					$this.attr('data-checked', 1);
				}
				Swal.fire({
					title: title,
					html: "<ul><li>"+ json.msg.content +"</li></ul>",
					type: type,
					showCloseButton: 1,
					confirmButtonText: "OK"
				});
				$radio.removeAttr('disabled');
			}, error: function(xhr) {
				alert();
				Swal.fire({
					title: 'AJAX ERROR!!!',
					html: "<ul><li>Request Error, Lihat Web Console</li></ul>",
					type: type,
					showCloseButton: 1,
					confirmButtonText: "OK"
				});
				console.log(xhr);
			}
		});
	});
});