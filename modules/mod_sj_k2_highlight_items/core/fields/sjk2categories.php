<?php
/**
 * @package SJ Responsive Listing for Zoo
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');

if (!class_exists('JFormFieldSjK2Categories')) {
	class JFormFieldSjK2Categories extends JFormFieldList
	{

		

		protected function getOptions()
		{			
			require_once JPATH_ADMINISTRATOR.'/components/com_k2/models/categories.php';
			$categoriesModel = K2Model::getInstance('Categories', 'K2Model');
			$categories = $categoriesModel->categoriesTree(NULL, true, false);
			$options  = array();
			$options[] = JHtml::_('select.option', 0, 'All');
			foreach($categories as $ca){
				$options[] = JHtml::_('select.option', $ca->value, $ca->text);
			}
			
			return $options;
		}

	}
}