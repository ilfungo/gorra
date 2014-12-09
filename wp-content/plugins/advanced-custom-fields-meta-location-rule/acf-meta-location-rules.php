<?php
/*
Plugin Name: Advanced Custom Fields: Meta Location Rule
Plugin URI: wordpress.org/plugins/advanced-custom-fields-meta-location-rule/
Description: Free plugin for using a meta / custom field as a location rule. *Depends on ACF 4+.*
Version: 1.0.5
Author: Stupid Studio
Author URI: http://stupid-studio.com/
License: GPL
Copyright: Stupid Studio
*/
define('ACF_META_LOCATION_RULES_VERSION', '1.0.5');


class AcfMetaLocationRules {
	private $location_rule_fields = array();
	
	function __construct()
	{
		add_filter('acf/location/rule_types',               array($this, 'filter_acf_location_rule_types'));
		add_filter('acf/location/rule_operators',           array($this, 'filter_acf_location_rule_operators'));
		add_action('acf/field_group/admin_enqueue_scripts', array($this, 'action_acf_field_group_admin_enqueue_scripts'));
		add_action('acf/input/admin_enqueue_scripts',       array($this, 'action_acf_input_admin_enqueue_scripts'));
		add_action('acf/input/admin_head',                  array($this, 'action_acf_input_admin_head'));
		add_filter('acf/location/rule_values/meta_field',   array($this, 'filter_acf_location_rule_values_meta_field'), 10, 2);
		add_filter('acf/location/rule_match/meta_field',    array($this, 'filter_acf_location_rule_match_meta_field'), 10, 3);
	}
	
	function filter_acf_location_rule_types($choices)
	{
		$choices[__("Post",'acf')]['meta_field'] = __('Meta Field', 'acf-mlr');
		return $choices;
	}
	
	function filter_acf_location_rule_operators()
	{
		$choices['=='] = __('value equals', 'acf-mlr');
		$choices['!='] = __('value not equals', 'acf-mlr');

		return $choices;
	}
	
	function action_acf_field_group_admin_enqueue_scripts()
	{
		wp_enqueue_script('acf-meta-location-rule-field-group-js', plugin_dir_url(__FILE__)."js/field_group_js.js", array('jquery'), ACF_META_LOCATION_RULES_VERSION);
	}
	
	function action_acf_input_admin_enqueue_scripts()
	{
		wp_enqueue_script('acf-meta-location-rule-input-js', plugin_dir_url(__FILE__)."js/input.js", array('jquery'), ACF_META_LOCATION_RULES_VERSION);
	}
	
	function action_acf_input_admin_head()
	{
		if (!$this->location_rule_fields) return;

		?><script>var ACF_META_LOCATION_RULE_FIELDS = <?= json_encode($this->location_rule_fields); ?>;</script><?php
	}
	
	/**
	 * The meta values are now dynamic - ACF doesn't support this, but requires a
	 * fixed list of values. Therefore, a couple of hacks to make it accept dynamic
	 * content:
	 * - The currently saved value is always a valid.
	 * - The meta key and meta value fields content, are always valid.
	 */
	function filter_acf_location_rule_values_meta_field($choices)
	{
		// blank choice is always default
		$choices[' : '] = '';

		// values from frontend form is also valid
		if (isset($_POST['meta_location_rule_key']) && $_POST['meta_location_rule_key']) {
			foreach($_POST['meta_location_rule_key'] as $i=>$key) {
				$value = $_POST['meta_location_rule_value'][$i];
				$choices[$key." : ".$value] = "";
			}
		}

		// whichever rules we previously had for this field group, are also valid of
		// course
		$rules = get_post_meta(get_the_ID(), 'rule');
		if (!$rules) $rules = array();
		
		foreach($rules as $rule) {
			if ($rule['param'] !== 'meta_field') continue;
			$choices[$rule['value']] = '';
		}

		return $choices;
	}
	
	/**
	 * When trying to find out whether this rule applies in the current scope.
	 */
	function filter_acf_location_rule_match_meta_field($match, $rules, $post)
	{
		$compareOperaor = $rules['operator'];
		$compareKeyValue = $rules['value'];

		list($compareKey,$compareValue) = explode(" : ", $compareKeyValue, 2);

		// also add the fields to look for, to the header
		$this->location_rule_fields[] = $compareKey;

		// fetch from db
		$postValue = get_post_meta($post['post_id'], $compareKey, true);

		// if from ajax, use the actual value from the form, instead of the
		// maybe-outdated db version
		if (isset($_POST['meta_location_rules']) && isset($_POST['meta_location_rules'][$compareKey])) {
			$postValue = $_POST['meta_location_rules'][$compareKey];
		}

		switch($compareOperaor) {
			case '==':
				if ($postValue === $compareValue) $match = true;
				break;

			case '!=':
				if ($postValue !== $compareValue) $match = true;
				break;
		}

		return $match;
	}
}

$obj = new AcfMetaLocationRules();