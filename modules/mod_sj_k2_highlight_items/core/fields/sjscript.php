<?php
/**
 * @package SJ Highlight Items for K2
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */

defined('_JEXEC') or die;


if (!class_exists('JFormFieldSjHeading')) {
	class JFormFieldSjScript extends JFormField
	{
		public function getInput()
		{
			return '';
		}

		public function getLabel()
		{
			return '<script>
						jQuery(document).ready(function($) {
							
							$("#jform_params_k2_highlight_items_count_slide").change(function(){
								var val = parseInt($(this).val());
								var count = parseInt($("#jform_params_k2_highlight_items_count_in_slide .active").prev().val());
								var total = val*count;
								$("#jform_params_itemCount").val(total);
							})
							$("#jform_params_k2_highlight_items_count_in_slide label").click(function(){
								var val = parseInt($("#jform_params_k2_highlight_items_count_slide").val());
								var count = parseInt($(this).prev().val());
								var total = val*count;
								$("#jform_params_itemCount").val(total);
							})
							var val = parseInt($("#jform_params_k2_highlight_items_count_slide").val());
							var count = parseInt($("#jform_params_k2_highlight_items_count_in_slide .active").prev().val());
							var total = val*count;
							$("#jform_params_itemCount").val(total);
						})
					</script>';
		}
	}

	;
}