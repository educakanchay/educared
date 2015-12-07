<?php
/**
 * @package Sj K2 Slideshow
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */

// no direct access
defined('_JEXEC') or die;

require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');
require_once dirname(__FILE__).'/helper_base.php';

class modSjK2SlideShowiiHelper extends K2BaseHelper
{
	public static function getList(&$params)
	{
		$mainframe = JFactory::getApplication();
		if ($params->get('catfilter')){
			$cid = $params->get('category_id', NULL);
		} else{
			$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
			$cid = $itemListModel->getCategoryTree($category=0);
		}
		$items = self::getItems($cid, $params);
		return $items;
	}
	
	public static function include_js($file, $framework=false, $relative=true){
		$basename = basename($file);
		if ($basename != $file){
			if (JHtml::script($basename, $framework, $relative, $pathonly = true)){
				JHtml::script($basename, $framework, $relative);
				return;
			}
		}
		// use Joomla! method
		JHtml::script($file, $framework, $relative);
	}
		
	public static function include_jquery($extension='', $framework=false, $relative=true){
		if ( version_compare(JVERSION, '3.0.0', '>=') ){
			JHtmlJquery::framework();
		} else {
			$doc = JFactory::getDocument();
			if (!isset($doc->jquery_loaded)){
				if (JHtml::script('jquery.min.js', $framework, $relative, $pathonly = true)){
					JHtml::script('jquery.min.js', $framework, $relative);
					JHtml::script('jquery.noconflict.js', $framework, $relative);
					$doc->jquery_loaded = true;
					return;
				} else if (!empty($extension)){
					$jquery   = $extension.'/jquery.min.js';
					$jqueryNC = $extension.'/jquery.noconflict.js'; // should be locate as jquery.min.js
					if (JHtml::script($jquery, $framework, $relative, $pathonly = true)){
						JHtml::script($jquery, $framework, $relative);
						JHtml::script($jqueryNC, $framework, $relative);
						$doc->jquery_loaded = true;
					}
				}
			}
		}
	}
	
	public static function include_css($file, $attribs=array(), $relative=true){
		$basename = basename($file);
		if ($basename != $file){
			if (JHtml::stylesheet($basename, $attribs, $relative, $pathonly = true)){
				JHtml::stylesheet($basename, $attribs, $relative);
				return true;
			}
		}
		// use Joomla! method
		JHtml::stylesheet($file, $attribs, $relative);
	}	
}
