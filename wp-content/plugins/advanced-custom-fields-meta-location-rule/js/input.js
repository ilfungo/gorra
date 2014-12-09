/**
 * ACF Meta Location Rule - Input page JS
 * ======================================
 */

jQuery(function($) {
	var initialize = function() {
		acf.screen.meta_location_rules = {};
		
		
		if (typeof ACF_META_LOCATION_RULE_FIELDS == "undefined" || !ACF_META_LOCATION_RULE_FIELDS.length) return;
		
		$(ACF_META_LOCATION_RULE_FIELDS).each(function() {
			// on each update, update
			$('form#post').on('change', 'div[data-field_name="'+this+'"] select, div[data-field_name="'+this+'"] input, div[data-field_name="'+this+'"] textarea', updateFieldGroups);
			
			// initial save
			$('div[data-field_name="'+this+'"]').each(function() {
				
				var field = $(this).find('input,select,textarea');
				if (field.filter('[type="checkbox"],[type="radio"]').length) {
					field = field.filter(':checked');
				}
				
				acf.screen['meta_location_rules'][$(this).data('field_name')] = field;
			});
		});
		
		// the default value may not have been noticed, but should force a reload
		// as well, so let's start out with an update
		window.setTimeout(function() {
			$(document).trigger('acf/update_field_groups');
		}, 500);
	};
	
	var updateFieldGroups = function() {
		acf.screen['meta_location_rules'][$(this).parents('[data-field_name]').data('field_name')] = $(this).val()
		
		$(document).trigger('acf/update_field_groups');
	};
	
	initialize();
});