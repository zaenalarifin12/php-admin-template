jQuery(document).ready(function () {
	var $body =$('body');
	$('.range-slider').on('input', function(){
		
		 // Cache this for efficiency
		el = $(this);
		
		console.log(el.position().top);
		
		// console.log();
		// $body = el.parents('body');
		// $body.css('font-size', el.val());
		// document.getElementsByTagName("BODY")[0].style.fontSize = '18px';
		// $(document.getElementsByTagName("BODY")).css('font-size', '18px');
		$("body").css('font-size', el.val() + 'px');
// console.log(el.val());
	/* 	// Measure width of range input
		width = el.width();

		// Figure out placement percentage between left and right of input
		newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));

		// Janky value to get pointer to line up better
		offset = -1;

		// Prevent bubble from going beyond left or right (unsupported browsers)
		if (newPoint < 0) { newPlace = 0; }
		else if (newPoint > 1) { newPlace = width; }
		else { newPlace = width * newPoint + offset; offset -= newPoint; }

		// Move bubble
		/* el
		.next("output")
		.css({
			left: newPlace,
			marginLeft: offset + "%"
		})
		.text(el.val()); */
		$output = el.next("output");
		box = $output.width() / 2;
		
		var init = 25;
		var curr = ( (el.val() - 10 ) * 33 ) - box;
		var top_pos = 22 + el.position().top;
		
		el
		.next("output")
		.css({ 
			left: curr + init,
			top: top_pos
			
		})
		.text(el.val());
	})
	
	
	 var el, newPoint, newPlace, offset;
 
	 // Select all range inputs, watch for change
	 $("input[type='range']").change(function() {
	 
	  
	 })
	 
	$('#color-scheme').delegate('a', 'click', function() {
		// alert();
		$this = $(this);
		if ($this.children('i').length > 0) {
			return false;
		}
		classes = $this.attr('class');
		split = classes.replace('-theme','');
		
		// color = split[0];
		
		url = theme_url  + '/assets/css/color-schemes/' + split  + '.css?r=' + Math.floor(Date.now() /10000);
		$('#style-switch').attr('href', url);
		
		$elm = $('#color-scheme, #color-scheme-side');
		$elm.each(function(i, elm) {
			$elm.find('i').remove();
			$elm.find('a.' + classes).append('<i class="fa fa-check theme-check"></i>');
		});
		
				
		$('#input-color-scheme').val(split);
	});
	
	$('#sidebar-color').change(function() {
		url = theme_url + '/assets/css/color-schemes/' + this.value  + '-sidebar.css?r=' + Math.floor(Date.now() /10000);
		// console.log(url);
		$('#style-switch-sidebar').attr('href', url);
		
		$('#sidebar-color').val(this.value);
	});
	
	$('#logo-background-color').change(function() {
		url = theme_url + '/assets/css/color-schemes/' + this.value  + '-logo-background.css?r=' + Math.floor(Date.now() /10000);
		// console.log(url);
		$('#logo-background-color-switch').attr('href', url);
	});
	
	
	$('#font').change(function() {
		url = theme_url + '/assets/css/fonts/' + $(this).val() + '.css';
		$('#font-switch').attr('href', url);
		$('#font').val(this.value);
	});
	
	$('#font-size').on('change', function() {
		$('body').css('font-size', this.value);
	});
	
	$('#form-setting').submit(function(e) {
		e.preventDefault();
		$btn = $(this).find('button[type="submit"]').addClass('disabled').css('float', 'left');
		
		$btn.attr('disabled', 'disabled');
		$loader = $('<div class="spinner-submit fa-3x"><i class="fas fa-circle-notch fa-spin"></i></div>').insertAfter($btn);
		$.ajax({
			'url' : module_url
			, 'method': 'POST'
			, 'data': $(this).serialize() + '&submit=submit&ajax=ajax'
			, 'success' : function(data) {
				// console.log(data);
				msg = $.parseJSON(data);
				title = msg.status == 'ok' ? 'SUKSES !!!' : 'ERROR !!!';
				type = msg.status == 'ok' ? 'success' : 'error';
				Swal.fire({
					text: msg.message,
					title: title,
					type: type,
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
				$btn.removeAttr('disabled').removeClass('disabled');
				$loader.remove();
			}, 'error' : function(xhr) {
				Swal.fire({
					text: 'Request error, lihat log console',
					title: 'Error !!!',
					type: 'error',
					showCloseButton: true,
					confirmButtonText: 'OK'
				})
				console.log(xhr);
			}
		})
		
	});
});