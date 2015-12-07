<?php
/**
 * @package Sj Responsive Listing for K2
 * @version 2.5.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
if(isset($list['items'])) {
ImageHelper::setDefault($params);

foreach($list['items']  as $item){ ?>
	<div class="respl-item first-load category-<?php echo $item->catid ?>" data-id=<?php echo $item->id; ?>" data-date="<?php echo strtotime($item->created); ?>" data-rdate="<?php echo strtotime($item->created); ?>" data-publishUp="<?php echo strtotime($item->publish_up); ?>" data-alpha="<?php echo trim(strtoupper($item->title)); ?>" data-ralpha="<?php echo trim(strtoupper($item->title)); ?>" data-order="<?php echo ($params->get('FeaturedItems') == '2')?$items->featured_ordering:$item->ordering; ?>" data-rorder="<?php echo ($params->get('FeaturedItems') == '2')?$items->featured_ordering:$item->ordering; ?>" data-hits="<?php echo $item->hits; ?>" data-best="<?php echo ($item->rating == null)?0:$item->rating->rating_count; ?>" data-comments="<?php echo ($item->numOfComments == null)?0:$item->numOfComments; ?>" data-modified="<?php echo strtotime($item->modified) ?>" data-rand="random" data-catid="<?php echo $item->catid ?>">
		<div class="item-inner">
			<?php
				$img = K2ResponsiveListing::getK2Image($item, $params); 
				if($img){
			?>
			<div class="item-image">
				
					<a href="<?php echo $item->link ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
					<?php echo K2ResponsiveListing::imageTag($img); ?>
					</a>
					<span class="shadow"></span>
					<div class="more-inner">
						<?php if($params->get('item_title_display',1) == 1){?>
						<div class="more-title2">
							<a href="<?php echo $item->link ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
								<?php echo K2ResponsiveListing::truncate($item->title, $params->get('item_title_max_characters',25)); ?>
							 </a>
						</div>
						<?php }?>
						<?php if($params->get('item_cat_display', 1) == 1){?>
						<div class="more-public" >
							<a href="<?php echo $item->categoryLink ?>" <?php echo K2ResponsiveListing::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->categoryname?>" >
								<?php echo $item->categoryname ?>
							</a>
						</div>
						<?php }?>
				
				 	</div>
					
			</div>
			<?php } ?>
		</div>
	</div>
<?php } 
}?>
