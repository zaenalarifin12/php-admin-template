jQuery(document).ready(function () {
	
	var $spinner = $('<div class="spinner-border text-dark mt-2" style="width: 1.5rem; height: 1.5rem; color:#6b6a6a !important;" role="status"><span class="sr-only">Loading...</span></div>');
	
	$('#provinsi').change(function() 
	{
		loadWilayah(this, 'kabupaten', 'Kabupaten', '#kabupaten, #kecamatan, #kelurahan');
	});
	
	$('#kabupaten').change(function() {
		loadWilayah(this, 'kecamatan', 'Kecamatan', '#kecamatan, #kelurahan');
	});
	
	$('#kecamatan').change(function() {
		loadWilayah(this, 'kelurahan', 'Kelurahan', '#kelurahan');
	});
	
	function loadWilayah(obj, target_id, targte_title, other_disabled) 
	{
		var value = obj.value,
			$this = $(obj),
			$others = $(other_disabled);
		
		$others
			.val('')
			.addClass('d-none')
			.attr('disabled','disabled')
			.children(':nth-last-child(2)')
			.remove();
	
		if (value == '')
			return;
		// alert();
		$this.attr('disabled', 'disabled');	
		$curr_spinner = $spinner.clone().insertAfter($this);
		// console.log(base_url +'?module=shared&action=ajax-'+target_id+'.php&id=' + value);
		$.getJSON(base_url + '?module=shared&action=ajax-'+target_id+'.php&id=' + value, function(data) 
		{
			html = '<option value="">Pilih '+ targte_title +'</option>'
			for (k in data) {
				html += '<option value="' + k + '">' + data[k] + '</option>';
			}
			
			$('#' + target_id).removeClass('d-none').removeAttr('disabled').empty().append(html);
			$this.removeAttr('disabled');
			$curr_spinner.remove();
			// console.log(data);
		});
	}
	
	$('#fakultas').change(function() {
		loadWilayah(this, 'prodi', 'Program Studi', '#prodi, #prodi-jenjang');
	});
	
	$('#prodi').change(function() {
		loadWilayah(this, 'prodi-jenjang', 'Jenjang', '#prodi-jenjang');
	});
});