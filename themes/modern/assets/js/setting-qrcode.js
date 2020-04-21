jQuery(document).ready(function () 
{
	var $preview_container = $('#preview-container');
	var $parent = $preview_container.parent();
		
	$('#pilih-background').change(function(){
		// alert();
		console.log(module_url + '?action=preview');
		
	});
	
	$('#btn-preview').click(function(e){
		// alert();
		e.preventDefault();
		// position = {};
		$form = $('#form-qrcode');
		data = $form.serialize();
		$.ajax({
			method : 'GET',
			data: data,
			url : module_url + '?action=preview',
			success: function(data) {
				posisi_kartu = $('#posisi-kartu').val();
				
				json = $.parseJSON($('#background-file').html());
				url_bg = base_url + 'assets/images/kartu/' + json[posisi_kartu];
				// console.log(bg);
				
				
				if (url_bg) {
					$("<img/>")
						.on('load', function() 
						{
							json = $.parseJSON($('#dimensi-kartu').html());
							// console.log(this);
							$preview_container.show().html(data);
							// $(this).css('width', json.w).css('height', json.h).appendTo($preview_container);
							$preview_container.find('img').remove();
							$(this).css('width', '100%').appendTo($preview_container);
							setDisplace();

						}).on('error', function(xhr) {
							alert('Error: lihat console');
							console.log(xhr);
						})
						.attr("src", url_bg);
						
						
						
						
				}
				
			},
			error: function() {
				
			}
		});
	});
	
	if ($('#preview-container').is(':visible')) {
		/* $preview_container = $('#preview-container');
		var parent_padding_left = parseFloat($parent.css('padding-left'));
		var parent_padding_top = parseFloat($parent.css('padding-top'));
		
		$qrcode_container = $('.qrcode-container'); */
		setDisplace();
	}
	
	function setDisplace() 
	{		
		var parent_padding_left = parseFloat($parent.css('padding-left'));
		var parent_padding_top = parseFloat($parent.css('padding-top'));
		var posisi_top = parseFloat($('#posisi-top').val()) + parent_padding_top;
		var posisi_left = parseFloat($('#posisi-left').val()) + parent_padding_left;
		
		$qrcode_container = $('.qrcode-container');

		$qrcode_container.css('top', posisi_top);
		$qrcode_container.css('left', posisi_left);
		
		const options = {
			constrain: true,
			// relativeTo: document.body,
			onTouchStop: setLastPosition,
			onMouseUp: setLastPosition,
			onMouseMove: detectPosition,
			onTouchMove: detectPosition
		};

		function detectPosition(el){
			position = {top:el.offsetTop - parent_padding_top, left: el.offsetLeft - parent_padding_left}
		}
		
		function setLastPosition(el){
			$('#posisi-top').val(el.offsetTop - parent_padding_top);
			$('#posisi-left').val(el.offsetLeft - parent_padding_left);
		}
						
		displace = window.displacejs;
		el_parent = document.getElementById('preview-container');
		el = el_parent.querySelector('.qrcode-container');
		
		displace(el, options);
	}
});
