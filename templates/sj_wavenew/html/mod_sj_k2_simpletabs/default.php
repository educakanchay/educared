<?php
/*
 * @package Sj K2 Simple Tabs
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

JHtml::stylesheet('modules/'.$module->module.'/assets/css/style.css');
if (!defined('SMART_JQUERY') && ( int ) $params->get ( 'include_jquery', '1' )) {
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}

JHtml::script('modules/'.$module->module.'/assets/js/simpletabs.js');

$tag_id = 'sj_k2_simpletabs_'.rand().time();
$css_posiotion = $params->get('position', 'top') . '-position';

 ?>
 
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		;(function(element){
			var $element = $(element);
			var $loading = $('.spt-loadding',$element);
				$loading.remove();
				$element.removeClass('pre-load');
				$element.simpletabs();
		})('#<?php echo $tag_id; ?>')
	});
//]]>	
</script>
<?php 
if ($params->get('pretext') !=''){?>
	<div class="pre-text"><?php echo $params->get('pretext'); ?></div>
<?php } ?>
<!--[if lt IE 9]><div class="sj-k2-simpletabs pre-load <?php echo $css_posiotion?> msie lt-ie9" id="<?php echo $tag_id; ?>" ><![endif]--> 
<!--[if IE 9]><div class="sj-k2-simpletabs pre-load <?php echo $css_posiotion?> msie" id="<?php echo $tag_id; ?>" ><![endif]-->
<!--[if gt IE 9]><!--><div class="sj-k2-simpletabs pre-load <?php echo $css_posiotion?>" id="<?php echo $tag_id; ?>" ><!--<![endif]-->
	<div class="spt-wrap <?php echo $css_posiotion ;?>" style="position:relative; overflow: hidden">
		<div class="spt-loadding"></div>
		  <?php include JModuleHelper::getLayoutPath($module->module, $layout.'_items'); ?>        
	</div>
</div>
<?php 
	if ($params->get('posttext') !=''){?>
	<div class="post-text"><?php echo $params->get('posttext'); ?></div>
<?php } ?>
