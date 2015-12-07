<?php
/**
 * @package SJ Highlight Items For K2
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2015 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */

defined('_JEXEC') or die;

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require_once dirname(__FILE__) . '/core/helper.php';
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
if($is_ajax){
	if(JRequest::getVar('sj_highlight_items_for_k2_id_ajax', null) == 1 && JRequest::getVar('mid', null) == $module->id){
		$layout = $params->get('layout', 'default');
		$cacheid = md5(serialize(array($layout, $module)));
		$cacheparams = new stdClass;
		$cacheparams->cachemode = 'id';
		$cacheparams->class = 'K2HighlightItemsHelper';
		$cacheparams->method = 'getList';
		$cacheparams->methodparams = $params;
		$cacheparams->modeparams = $cacheid;
		$cat = JRequest::getVar('cat', 0);
		if($cat == 'all'){
			$list = K2HighlightItemsHelper::getList($params);
		}else{
			$list = K2HighlightItemsHelper::getList($params,$cat);
		}
		$layout = 'default';
		$result = new stdClass();
		$width = JRequest::getVar('width', null);
		$widthW = JRequest::getVar('widthW', null);
		$cid = JRequest::getVar('cat', null);
        ob_start();
        require JModuleHelper::getLayoutPath($module->module, $layout . '_items');
        $buffer = ob_get_contents();
        $result->items_markup = preg_replace(
            array(
                '/ {2,}/',
                '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
            ),
            array(
                ' ',
                ''
            ),
            $buffer
        );
        ob_end_clean();
        die (json_encode($result));
	}
}
if($params->get('catfilter') == 1 && count($params->get('category_id')) == 0){
	echo 'Has no item to show';
}else{
	$layout = $params->get('layout', 'default');
	$cacheid = md5(serialize(array($layout, $module)));
	$cacheparams = new stdClass;
	$cacheparams->cachemode = 'id';
	$cacheparams->class = 'K2HighlightItemsHelper';
	$cacheparams->method = 'getList';
	$cacheparams->methodparams = $params;
	$cacheparams->modeparams = $cacheid;
	$tabs = K2HighlightItemsHelper::getCategoriesInfor($params);
	foreach($tabs as $tab){
		if(!isset($tab['id']))continue;
		$index = $tab['id'];
		break;
	}
	if($params->get('category_id') != null){
		if($params->get('catid_preload') == 0){
		if($params->get('tab_all_display') == 1){
			$cid = 0;
			$list = K2HighlightItemsHelper::getList($params);
		}else{
			$cid = $index;
			$list = K2HighlightItemsHelper::getList($params,$cid);
		}
		}else{
			if($params->get('tab_all_display') == 1){
				if(in_array($params->get('catid_preload'),$params->get('category_id'))){
					$cid = $params->get('catid_preload');
					$list = K2HighlightItemsHelper::getList($params,$cid);
				}else{
					$cid = 0;
					$list = K2HighlightItemsHelper::getList($params);
				}
			}else{
				if(in_array($params->get('catid_preload'),$params->get('category_id'))){
					$cid = $params->get('catid_preload');
					$list = K2HighlightItemsHelper::getList($params,$cid);
				}else{
					$cid = $index;
					$list = K2HighlightItemsHelper::getList($params,$cid);
				}
			}			
		}
	}else{
		if($params->get('catid_preload') == 0){
			if($params->get('tab_all_display') == 1){
				$cid = 0;
				$list = K2HighlightItemsHelper::getList($params);
			}else{
				$cid = $params->get('catid_preload');
				$list = K2HighlightItemsHelper::getList($params,$cid);
			}
		}else{
			$cid = $params->get('catid_preload');
			$list = K2HighlightItemsHelper::getList($params,$cid);
		}
	}

	require JModuleHelper::getLayoutPath($module->module, $layout);
}



