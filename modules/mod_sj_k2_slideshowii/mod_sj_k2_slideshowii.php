<?php
/**
 * @package SJ K2 SlideShow II
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;

// include jQuery.
require_once dirname(__FILE__).'/core/helper.php';

modSjK2SlideShowiiHelper::include_js('slideshowii/jquery.cycle.all.js');
modSjK2SlideShowiiHelper::include_css('slideshowii/slideshowii.css');
	
$list = modSjK2SlideShowiiHelper::getList($params);
$layout_name = $params->get('layout', 'default');
//if( count($list) ) {
	require JModuleHelper::getLayoutPath($module->module,$layout_name);
//}
