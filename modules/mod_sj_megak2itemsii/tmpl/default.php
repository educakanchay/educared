<?php
/**
 * @package Sj Mega K2 Items II
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
	$tag_id	= 'sj_megak2items_ii_'.rand().time();
	$theme = $params->get('theme','theme1');
	JHtml::stylesheet('modules/'.$module->module.'/assets/css/styles.css');
	if (!defined('SMART_JQUERY') && (int)$params->get('include_jquery', '1')){
		JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
		JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
		define('SMART_JQUERY', 1);
	}
	JHtml::stylesheet('modules/'.$module->module.'/assets/css/styles-responsive.css');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery.tabsmart.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery.mousewheel.js');
	// JHtml::script('modules/'.$module->module.'/assets/js/jquery.touchwipe.1.1.1.js');
	ImageHelper::setDefault($params);
	$colums = ' megaii-rps01-'.$params->get('nb-column1').' megaii-rps02-'.$params->get('nb-column2').' megaii-rps03-'.$params->get('nb-column3').' megaii-rps04-'.$params->get('nb-column4');
?>
<?php if ($params->get('pretext') != '' ): ?>
<div class="megaii-pretext" >
	<?php echo JText::_($params->get('pretext')); ?>
</div>
<?php endif;



	if (!empty($list)):	?>
		<!--[if lt IE 9]><div id="<?php echo $tag_id; ?>" class="sj-megak2items-ii msie lt-ie9  <?php echo $theme; ?>"><![endif]-->
		<!--[if IE 9]><div id="<?php echo $tag_id; ?>" class="sj-megak2items-ii msie  <?php echo $theme; ?>"><![endif]-->
		<!--[if gt IE 9]><!--><div id="<?php echo $tag_id; ?>" class="sj-megak2items-ii <?php echo $theme; ?>"><!--<![endif]-->
			<?php foreach($list as $section){ ?>
			<div class="megaii-wrap megaii-close <?php echo $theme; ?>">
				<?php include JModuleHelper::getLayoutPath($module->module, $layout.'_'.$theme); ?>
			</div>
			<?php } ?>
		</div>
	<?php else: ?>
	<p><?php echo JText::_('NO_CONTENT'); ?></p>
	<?php endif; ?>	
<?php if ($params->get('posttext') != '' ): ?>
<div class="megaii-posttext">
	<?php echo JText::_($params->get('posttext')); ?></div>
<?php endif; ?>