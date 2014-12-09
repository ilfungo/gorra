/**
 * ACF Meta Location Rule - Field Group custom JS
 * ==============================================
 */

jQuery(function($) {
	var initialize = function() {
		initializeOnRuleChange();
	};
	
	var initializeOnRuleChange = function() {
		// future change - unfortunately ACF doesn't trigger any action after
		// injecting it's ajax-fetched value, so we do this little check on each
		// ajax success
		$(document).ajaxSuccess(function() {
			$('#acf_location .location-groups td.value select:visible').each(onRuleChange);
		});
		
		// on load
		$('#acf_location .location-groups td.value select:visible').each(onRuleChange);
		
		// on field value change
		$('#acf_location .location-groups').on('change', 'input[data-meta]', function() {
			$(this).parents('tr[data-id]').find('td.param select').each(onValueChange);
		});
	};
	
	/**
	 * When the rule meta_field is selected, transform the select into the dynamic
	 * input-fields.
	 */
	var onRuleChange = function() {
		var valOuter = $(this).parent();
		
		// is it a relevant field we're working on?
		if ($(this).parents('tr[data-id]').find('td.param select').val() !== 'meta_field') return;
		
		var valSelect = valOuter.children('select');
		var selValue = valSelect.val() || '';
		
		valSelect.hide();
		
		// remove any previous tables
		valOuter.children('table').remove();
		
		// add our new table
		var domElString = '<table class="acf_input" style="margin-top: -7px"><tbody><tr><td width="40%"><input name="meta_location_rule_key[]" type="text" class="name" data-meta="key" placeholder="Name" title="Custom field name / meta key" /></td><td width="60%"><input type="text" class="name" data-meta="value" placeholder="Value" name="meta_location_rule_value[]" title="Custom field value / meta value" /></td></tr></tbody></table>';
		valOuter.append(domElString);
		
		// the two input fields
		var fieldKey = valOuter.find('[data-meta=key]');
		var fieldValue = valOuter.find('[data-meta=value]');
		
		// get the current select value, if there's existing content
		var sepPos = selValue.search(' : ');
		if (sepPos) {
			var key = selValue.substr(0,sepPos);
			var val = selValue.substr(sepPos+3);
			
			fieldKey.val(key);
			fieldValue.val(val);
		}
	};

	/**
	 * When the value of the input-fields changes, update the underlying select.
	 */
	var onValueChange = function() {
		var valOuter = $(this).parents('tr[data-id]').find('td.value');
		var valSelect = valOuter.children('select');
		var fieldKey = valOuter.find('[data-meta=key]');
		var fieldValue = valOuter.find('[data-meta=value]');


		// when the input is changed, update the underlying select
		var changeFn = function() {
			valSelect.empty().append( $('<option>').val( fieldKey.val()+' : '+fieldValue.val()) );
		};
		
		fieldKey.change(changeFn);
		fieldValue.change(changeFn);
	};
	
	initialize();
});