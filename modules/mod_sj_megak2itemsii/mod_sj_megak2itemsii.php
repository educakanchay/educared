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

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

//check the exist of k2 component on the site?

if(file_exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php') && file_exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php')){


	ini_set('xdebug.var_display_max_depth', '5'); 
	require_once dirname(__FILE__).'/core/helper.php';

	$layout = $params->get('layout', 'default');
	$cacheid = md5(serialize(array ($layout, $module->id)));
	$cacheparams = new stdClass;
	$cacheparams->cachemode = 'id';
	$cacheparams->class = 'SjMegaK2ItemsIIHelper';
	$cacheparams->method = 'getList';
	$cacheparams->methodparams = $params;
	$cacheparams->modeparams = $cacheid;
	$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);
	require JModuleHelper::getLayoutPath($module->module, $layout);
	require JModuleHelper::getLayoutPath($module->module, $layout.'_js');

}else{
	echo JText::_('PLEASE_INSTALL_K2_COMPONENT_FIRST');
}
