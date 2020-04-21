/*
* Menu Editor Plugin
* @author Agus Prawoto Hadi
* @website https://webdev.id
* @release 2019-02-09
* @copyright: Bebas digunakan dan dicustom untuk penggunaan sendiri. 
* Dilarang keras mendistribusikan, menjual, menggunakan script ini dalam aplikasi berbayar tanpa seijin penulis
*/
;(function($)
{
	$.extend($.fn.np.prototype, {
		customInit : function() 
		{
			this.addOptions();
			this.addButton();
			var list_container = this.el;
			var plugin = this;
			list_container.on('click', 'button', function(e) {
				var action = $(this).data('action'),
					$list = $(this).parent();
					
				if (action === 'remove') {
					result = plugin.options.beforeRemove($list, plugin);
					if (result) {
						plugin.deleteList($list);
					}
				}
				
				if (action === 'edit') {
					plugin.options.editBtnCallback($list);
				}
			});
		}, 
		
		deleteList: function(item) 
		{
			$parent = item.parent();
			item.remove();
			if ($parent.children().length == 0) {
			   this.unsetParent($parent.parent());
			}
		},
		
		addOptions: function() {
			var addOptions = {
				/* Changes: Add Close Button */
				removeBtnHTML 	: '<button data-action="remove" type="button" class="fas fa-times pull-right"></button>',
				editBtnHTML 	: '<button data-action="edit" type="button" class="far fa-pen pull-right"></button>',
				editBtnCallback	: function(){},
				beforeRemove		: function(){return true},
			}
			this.options = $.extend({}, addOptions, this.options);
		},
		
		addButton: function () {
			var options = this.options;
			$.each(this.el.find(this.options.itemNodeName), function(i, el) {
				$removeBtn = $(options.removeBtnHTML).addClass('dd-remove');
				$editBtn = $(options.editBtnHTML);
				$(el).prepend($editBtn);
				$(el).prepend($removeBtn);
			})
		},
		unsetParent: function(li) {
			li.children(this.options.listNodeName).remove();
			li.removeClass(this.options.collapsedClass);
			li.children('[data-action="expand"]').remove();
            li.children('[data-action="collapse"]').remove();
		}
	}); 

	$.fn.wdiMenuEditor = function(options) {
		var value,
			plugin;
			
		this.each(function(i, el) 
		{
			var plugin = $.data(el, 'wdiMenuEdiitor');
			
			if (plugin) {
				if  (typeof options === 'string' && typeof plugin[options] === 'function') {
					value =  plugin[options]();
				}
			} else {
				var plugin = new $.fn.np(el, options);
				plugin.customInit();
				$.data(el, 'wdiMenuEdiitor', plugin);
			}
		})
		
		return value || plugin;
	}
})($);