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

require_once(JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php');
require_once(JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'utilities.php');


include_once dirname(__FILE__) . '/helper_base.php';


abstract class K2HighlightItemsHelper extends K2HighlightItemsBaseHelper
{
	public static function getList(&$params,$cid=0)
	{
		jimport('joomla.filesystem.file');
		$mainframe = JFactory::getApplication();
		$limit = $params->get('itemCount', 5);
		if($cid == 0){
			$cid = $params->get('category_id', NULL);
		}
		
		$ordering = $params->get('itemsOrdering', '');
		$componentParams = JComponentHelper::getParams('com_k2');
		$limitstart = JRequest::getInt('limitstart');

		$user = JFactory::getUser();
		$aid = $user->get('aid');
		$db = JFactory::getDBO();

		$jnow = JFactory::getDate();
		$now = K2_JVERSION == '15' ? $jnow->toMySQL() : $jnow->toSql();
		$nullDate = $db->getNullDate();

		if ($params->get('source') == 'specific') {

			$value = $params->get('items');
			$current = array();
			if (is_string($value) && !empty($value))
				$current[] = $value;
			if (is_array($value))
				$current = $value;

			$items = array();

			foreach ($current as $id) {

				$query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams
				FROM #__k2_items as i 
				LEFT JOIN #__k2_categories c ON c.id = i.catid 
				WHERE i.published = 1 ";
				if (K2_JVERSION != '15') {
					$query .= " AND i.access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ") ";
				} else {
					$query .= " AND i.access<={$aid} ";
				}
				$query .= " AND i.trash = 0 AND c.published = 1 ";
				if (K2_JVERSION != '15') {
					$query .= " AND c.access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ") ";
				} else {
					$query .= " AND c.access<={$aid} ";
				}
				$query .= " AND c.trash = 0
				AND ( i.publish_up = " . $db->Quote($nullDate) . " OR i.publish_up <= " . $db->Quote($now) . " )
				AND ( i.publish_down = " . $db->Quote($nullDate) . " OR i.publish_down >= " . $db->Quote($now) . " )
				AND i.id={$id}";
				if (K2_JVERSION != '15') {
					if ($mainframe->getLanguageFilter()) {
						$languageTag = JFactory::getLanguage()->getTag();
						$query .= " AND c.language IN (" . $db->Quote($languageTag) . ", " . $db->Quote('*') . ") AND i.language IN (" . $db->Quote($languageTag) . ", " . $db->Quote('*') . ")";
					}
				}
				$db->setQuery($query);
				$item = $db->loadObject();
				if ($item)
					$items[] = $item;

			}
		} else {
			$query = "SELECT i.*, CASE WHEN i.modified = 0 THEN i.created ELSE i.modified END as lastChanged, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";

			if ($ordering == 'best')
				$query .= ", (r.rating_sum/r.rating_count) AS rating";

			if ($ordering == 'comments')
				$query .= ", COUNT(comments.id) AS numOfComments";

			$query .= " FROM #__k2_items as i RIGHT JOIN #__k2_categories c ON c.id = i.catid";

			if ($ordering == 'best')
				$query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";

			if ($ordering == 'comments')
				$query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";

			if (K2_JVERSION != '15') {
				$query .= " WHERE i.published = 1 AND i.access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ") AND i.trash = 0 AND c.published = 1 AND c.access IN(" . implode(',', $user->getAuthorisedViewLevels()) . ")  AND c.trash = 0";
			} else {
				$query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";
			}

			$query .= " AND ( i.publish_up = " . $db->Quote($nullDate) . " OR i.publish_up <= " . $db->Quote($now) . " )";
			$query .= " AND ( i.publish_down = " . $db->Quote($nullDate) . " OR i.publish_down >= " . $db->Quote($now) . " )";

		
				if (!is_null($cid)) {
					if (is_array($cid)) {
						if ($params->get('getChildren') == 1) {
							$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
							$categories = $itemListModel->getCategoryTree($cid);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";

						} else {
							JArrayHelper::toInteger($cid);
							$query .= " AND i.catid IN(" . implode(',', $cid) . ")";
						}

					} else {
						if ($params->get('getChildren') == 1) {
							$itemListModel = K2Model::getInstance('Itemlist', 'K2Model');
							$categories = $itemListModel->getCategoryTree($cid);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";
						} else {
							$query .= " AND i.catid=" . (int)$cid;
						}

					}
				}
			

			if ($params->get('FeaturedItems') == '0')
				$query .= " AND i.featured != 1";

			if ($params->get('FeaturedItems') == '2')
				$query .= " AND i.featured = 1";

			if ($params->get('videosOnly'))
				$query .= " AND (i.video IS NOT NULL AND i.video!='')";

			if ($ordering == 'comments')
				$query .= " AND comments.published = 1";

			if (K2_JVERSION != '15') {
				if ($mainframe->getLanguageFilter()) {
					$languageTag = JFactory::getLanguage()->getTag();
					$query .= " AND c.language IN (" . $db->Quote($languageTag) . ", " . $db->Quote('*') . ") AND i.language IN (" . $db->Quote($languageTag) . ", " . $db->Quote('*') . ")";
				}
			}

			switch ($ordering) {

				case 'date' :
					$orderby = 'i.created ASC';
					break;

				case 'rdate' :
					$orderby = 'i.created DESC';
					break;

				case 'alpha' :
					$orderby = 'i.title';
					break;

				case 'ralpha' :
					$orderby = 'i.title DESC';
					break;

				case 'order' :
					if ($params->get('FeaturedItems') == '2')
						$orderby = 'i.featured_ordering';
					else
						$orderby = 'i.ordering';
					break;

				case 'rorder' :
					if ($params->get('FeaturedItems') == '2')
						$orderby = 'i.featured_ordering DESC';
					else
						$orderby = 'i.ordering DESC';
					break;

				case 'hits' :
					if ($params->get('popularityRange')) {
						$datenow = JFactory::getDate();
						$date = K2_JVERSION == '15' ? $datenow->toMySQL() : $datenow->toSql();
						$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL " . $params->get('popularityRange') . " DAY) ";
					}
					$orderby = 'i.hits DESC';
					break;

				case 'rand' :
					$orderby = 'RAND()';
					break;

				case 'best' :
					$orderby = 'rating DESC';
					break;

				case 'comments' :
					if ($params->get('popularityRange')) {
						$datenow = JFactory::getDate();
						$date = K2_JVERSION == '15' ? $datenow->toMySQL() : $datenow->toSql();
						$query .= " AND i.created > DATE_SUB('{$date}',INTERVAL " . $params->get('popularityRange') . " DAY) ";
					}
					$query .= " GROUP BY i.id ";
					$orderby = 'numOfComments DESC';
					break;

				case 'modified' :
					$orderby = 'lastChanged DESC';
					break;

				case 'publishUp' :
					$orderby = 'i.publish_up DESC';
					break;

				default :
					$orderby = 'i.id DESC';
					break;
			}

			$query .= " ORDER BY " . $orderby;
			// $sql = str_replace('#__','jos_',$query);
			// echo $sql;die;
			$db->setQuery($query, 0, $limit);
			$items = $db->loadObjectList();
		}

		$model = K2Model::getInstance('Item', 'K2Model');
		$show_introtext = $params->get('item_desc_display', 0);
		$introtext_limit = $params->get('item_desc_max_characs', 100);
		if (count($items)) {

			foreach ($items as $item) {

				//Clean title
				$item->title = JFilterOutput::ampReplace($item->title);

				//Read more link
				$item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id . ':' . urlencode($item->alias), $item->catid . ':' . urlencode($item->categoryalias))));

				//Tags
				$item->tags = '';
				if ($params->get('item_tags_display')) {
					$tags = $model->getItemTags($item->id);
					for ($i = 0; $i < sizeof($tags); $i++) {
						$tags[$i]->link = JRoute::_(K2HelperRoute::getTagRoute($tags[$i]->name));
					}
					$item->tags = $tags;
				} else {
					$item->tags = '';
				}

				// Restore the intotext variable after plugins execution
				self::getK2Images($item, $params);
				//Clean the plugin tags
				$item->introtext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $item->introtext);
				if ($item->fulltext != '') {
					$item->fulltext = preg_replace("#{(.*?)}(.*?){/(.*?)}#s", '', $item->fulltext);
					$item->introtext = self::_cleanText($item->introtext . $item->fulltext);
				} else {
					$item->introtext = self::_cleanText($item->introtext);
				}
				$item->displayIntrotext = $show_introtext ? self::truncate($item->introtext, $introtext_limit) : '';
				
				$item->numOfvotes = $model->getVotesNum($item->id);
				$item->votingPercentage = $model->getVotesPercentage($item->id);
				$item->creat_by_name = self::getUser($item->created_by);
				$rows[] = $item;
			}
			return $rows;
		}

	}
	public static function getUser($id){
		$db = JFactory::getDBO();
		$query = "SELECT username FROM #__users Where id = ".$id;
		$db->setQuery($query);
		$item = $db->loadObject();
		return $item->username;
	}
	public static function getCategoriesInfor($params){
		$cid = $params->get('category_id', NULL);
		$db = JFactory::getDBO();
		$send = array();
		$fields = array("date" => "Oldest First","rdate" => "Date Created","rand" => "Random","publishUp" => "Date Published","alpha" => "Title","ralpha" => "Title Reverse","order" => "Ordering","rorder" => "Ordering Reverse","hits" => "Most Popular","best" => "Highest Rated","comments" => "Most Commented","modified" => "Latest Modified");
		if($params->get('filter_type') != 'filter_orders'){
			if($params->get('tab_all_display') == 1){
				$send['*'] = array();
				$send['*']['name'] = 'All';
				$send['*']['count'] = self::getList($params,$cgid = -1,$count = 1,$orderSelect=false,$tab_all_display = 1);
				if($params->get('catid_preload') == 0){
					$send['*']['sel'] = "sel";
				}
				$send['*']['field_order'] = $params->get('source_order');
			}
			if($cid == NULL){
				if($params->get('showParent') == 1){
					$query = "SELECT id,name,params,description,image FROM #__k2_categories WHERE parent =0";
				}else{
					$query = "SELECT id,name,params,description,image FROM #__k2_categories";
				}
			}else{
				$cid = join(',',$cid);
				$query = "SELECT id,name,params,description,image FROM #__k2_categories WHERE id IN ($cid)";
			}
			if($params->get('cat_order_by') == 'title'){
				$query = $query . ' ORDER BY name';
			}
			if($params->get('cat_order_by') == 'id'){
				$query = $query . ' ORDER BY id';
			}
			if($params->get('cat_order_by') == 'random'){
				$query = $query . ' ORDER BY RAND()';
			}
			$query = $query . ' ' .$params->get("cat_ordering_direction");
			$db->setQuery($query);
			$items = $db->loadAssocList();
			foreach($items as $i){
				$send[$i['id']] = array();
				$send[$i['id']]['id'] = $i['id'];
				$send[$i['id']]['name'] = $i['name'];
				$send[$i['id']]['param'] = $i['params'];
				$send[$i['id']]['description'] = $i['description'];
				$send[$i['id']]['image'] = $i['image'];
				$send[$i['id']]['count'] = self::getList($params,$i['id'],$count = 1,$orderSelect=false);
				if($i['id'] == $params->get('catid_preload')){
					$send[$i['id']]['sel'] = "sel";
				}
				$send[$i['id']]['field_order'] = $params->get('source_order');
			}
			
		}else{
			$countItems = self::getList($params,$cgid = -1,$count = 1,$orderSelect=false);
			foreach($params->get('filter_order_by') as $i){
				$send[$i] = array();
				$send[$i]['id'] = $i;
				$send[$i]['name'] = $fields[$i];
				$send[$i]['count'] = $countItems;
				if($i == $params->get('field_preload')){
					$send[$i]['sel'] = 'sel';
				}
			}			
		}
		return $send;
	}
	public static function viewSlide($item,$options,$type = 0){
		if($type == 0){
			echo '<div class="k2_highlight_items_info">';
				echo '<div class="k2_highlight_items_info_title">';?>
				<?php if( $options->item_title_display == 1 ){?>
					<div class="item-title">
					<a href="<?php echo $item->link;?>" title="<?php echo $item->title ?>" <?php echo K2HighlightItemsBaseHelper::parseTarget($options->item_link_target); ?>>
						<?php echo K2HighlightItemsBaseHelper::truncate($item->title, $options->item_title_max_characs);?>
					</a>    			     
					</div>
				<?php }?>
				<?php
				echo '</div>';
				echo '<div class="k2_highlight_items_info_border"></div>';
				echo '<div class="k2_highlight_items_info_des">';?>
				<?php if( ($options->item_desc_display == 1 && !empty($item->displayIntrotext)) || $options->item_readmore_display == 1 ){?>
				<?php if( $options->item_desc_display == 1 ){?>
				<div class="item-description">
					<?php echo $item->displayIntrotext;?>
				</div>
				<?php }?>
				<?php }?>
				<?php
				echo '</div>';
				?>
				<?php if( $options->item_readmore_display == 1 ){?>
					<div class="k2_highlight_items_info_read">
						<a href="<?php echo $item->link;?>" title="<?php echo $item->title ?>" <?php echo K2HighlightItemsBaseHelper::parseTarget($options->item_link_target); ?>>
							<?php echo $options->item_readmore_text;?>
						</a>                                
						</div> 
				<?php }?> 
				<?php
				echo '</div>';
		}else{
			echo '<div class="k2_highlight_items_info_no_slide not_hover">';
				echo '<div class="k2_highlight_items_height not_hover">';
				echo '<div class="k2_highlight_items_info_title not_hover">';?>
				<?php if( $options->item_title_display == 1 ){?>
					<div class="item-title not_hover">
					<a href="<?php echo $item->link;?>" class="not_hover" title="<?php echo $item->title ?>" <?php echo K2HighlightItemsBaseHelper::parseTarget($options->item_link_target); ?>>
						<?php echo K2HighlightItemsBaseHelper::truncate($item->title, $options->item_title_max_characs);?>
					</a>    			     
					</div>
				<?php }?>
				<?php
				echo '</div>';

				if($options->item_hits_display == 1){
				echo '<div class="k2_highlight_items_info_hits not_hover">';		
					if($options->item_author_display == 1){
						echo '<div class="k2_highlight_item_info_hits k2_highlight_items_writen_by not_hover">';
							echo '<div class="k2_highlight_items_writen_by_icon sj_left"><i class="fa fa-user"></i></div>';
							echo '<div class="k2_highlight_items_writen_by_content k2_highlight_item_hits_border not_hover sj_left">'.$item->creat_by_name.'</div>';
						echo '</div>';
					}
					if($options->item_created_display == 1){
						$time = strtotime($item->created);
						echo '<div class="k2_highlight_item_info_hits k2_highlight_items_time not_hover ">';
							echo '<div class="k2_highlight_items_time_icon not_hover sj_left"><i class="fa fa-clock-o"></i></div>';
							echo '<div class="k2_highlight_items_time_content k2_highlight_item_hits_border not_hover sj_left">'.date('j M Y',$time).'</div>';
						echo '</div>';
					}
					if($options->item_hit_display == 1){
						echo '<div class="k2_highlight_item_info_hits k2_highlight_items_hits not_hover">';
							echo '<div class="k2_highlight_items_hits_icon not_hover sj_left"><i class="fa fa-eye"></i></div>';
							echo '<div class="k2_highlight_items_hits_content not_hover sj_left">'.$item->hits.'</div>';
						echo '</div>';
					}
				echo '</div>';
				}
				echo '</div>';
				echo '<div class="k2_highlight_items_info_des not_hover">';?>
				<?php if( ($options->item_desc_display == 1 && !empty($item->displayIntrotext)) || $options->item_readmore_display == 1 ){?>
				<?php if( $options->item_desc_display == 1 ){?>
				<div class="item-description">
					<?php echo $item->displayIntrotext;?>
				</div>
				<?php }?>
				<?php }?>
				<?php
				echo '</div>';
				?>
				<?php if( $options->item_readmore_display == 1 ){?>
				<div class="k2_highlight_items_info_read not_hover">
					<div class="item-readmore">
						<a href="<?php echo $item->link;?>" class="not_hover" title="<?php echo $item->title ?>" <?php echo K2HighlightItemsBaseHelper::parseTarget($options->item_link_target); ?>>
							<?php echo $options->item_readmore_text;?>
						</a>                                
						</div> 
				</div>
				<?php }?> 
				<?php
				echo '</div>';
		}	
	}
}
