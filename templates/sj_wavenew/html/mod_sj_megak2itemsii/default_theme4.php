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
?>
<div class="megaii-header">
	<a href="<?php echo $section['url']; ?>" title="<?php echo $section['title']; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
		<?php echo SjMegaK2ItemsIIHelper::truncate($section['title'],(int)$params->get('cat_title_max_characs','25')); ?>
	</a>
	<span class="megaii-button megaii-open"></span>
</div>
<?php if((int)$params->get('sub_cat_display',1)) { ?>
<div class="megaii-tabs-wrap">
	<?php
			$prenav_text = JText::_('PRE_NAV_TEXT');
			if (isset($prenav_text) && !empty($prenav_text)):
		?>
		<span class="megaii-label"><?php echo JText::_('PRE_NAV_TEXT'); ?></span>
		<?php endif; ?>
	<div class="megaii-tabs-inner">
		<span  class="tabs-previous tabs-direction">&laquo;</span>
		<ul class="megaii-tabs cf">
			<?php $i = 0; foreach($section['child_category']  as $category) { $i++; ?>
				<li data-catid="<?php echo $module->id.'-'.$category['id']; ?>" class="megaii-tab <?php echo ($i == 1)?' tab-selected':' '; ?>">
					<span>
						<?php echo SjMegaK2ItemsIIHelper::truncate($category['title'],(int)$params->get('sub_cat_title_max_characs','25')); ?>
					</span>
				</li>
			<?php } ?>
		</ul>
		<span  class="tabs-next tabs-direction">&raquo;</span>
	</div>
</div>
<?php } ?>
<div class="megaii-content <?php echo $colums; ?>" > 
	<div class="megaii-content-inner">
		<?php $cs = 0; foreach($section['child_category'] as $category) { $cs++; ?>
		<div class="megaii-content-catwrap <?php echo ($cs == 1)?' content-selected':' '; ?> <?php echo 'category-'.$module->id.'-'.$category['id']; ?>" >
			<?php
			$columns_max = $params->get('nb-column1') > 1 ? $params->get('nb-column1') : 1;
			$j = 0;
			$category_childs = array();
			foreach ($category['child'] as $key => $item){
				if (!isset($category_childs[$j])){
					$category_childs[$j]=array();
				}
				$category_childs[$j][] =& $category['child'][$key];
				$j = ++$j % $columns_max;
			}
			
			$res = 0; foreach($category_childs as $items) { $res++;
			$item0 = array_shift($items);
			$items = $items;
			?>
			<div class="megaii-item">
				<div class="megaii-item-inner">
					<div class="megaii-item-first">
						<?php 
						$img = SjMegaK2ItemsIIHelper::getK2Image($item0, $params);					
						$img = ImageHelper::init($img)->src();		
						if((is_file($img) && file_exists($img)) || SjMegaK2ItemsIIHelper::isUrl($img)){?>
						<div class="item-image">
							<a href="<?php echo $item0->link ?>" title="<?php echo $item0->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
								<img alt="<?php echo $item0->displaytitle;?>" src="<?php echo $img;?>"/>	
							</a>
						</div>
						<?php } 
						if($item0->displaytitle != '') { ?>
						<div class="item-title">
						
							<a href="<?php echo $item0->link ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item0->displaytitle?>" >
								<?php echo $item0->displaytitle;?>
							</a>
						</div>
						<?php }
						if($item0->displayIntrotext != '') { ?>
						<div class="item-desc">
							<?php echo $item0->displayIntrotext; ?>
						</div>
						<?php }
					
						
						// show tags
					
						if($item0->tags !=''){?>
							<div class="item-tags">
								<?php foreach ($item0->tags as $tag): ?>
								<span class="tag-<?php echo $tag->id; ?>">
									<a class="label label-info" href="<?php echo $tag->link; ?>" title="<?php echo $tag->name; ?>" target="_blank"><?php echo $tag->name; ?></a>
								</span>
								<?php endforeach; ?>
							 </div>					
						<?php }	
						
						if((int)$params->get('item_nb_view_disp',1) || (int)$params->get('item_comment_disp',1) || (int)$params->get('item_created_disp',1) || (int)$params->get('item_readmore_display',1) ) { ?>
						<div class="item-info">
							<?php $oe = array('megaii-odd', 'megaii-even'); $nb = 0; 
							if((int)$params->get('item_nb_view_disp',1)) { ?>	
							<div class="item-view <?php echo $oe[$nb++ % 2]; ?>">
								<span><?php echo JText::_('Read'); ?> <?php echo $item0->hits; ?></span>
							</div>
							<?php } 
							if((int)$params->get('item_comment_disp',1)) {
								$comment = isset($item0->count_comments)?(int)$item0->count_comments:0;
								if($comment > 1){
								?>
								<div class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
									<span><?php echo $comment; ?>&nbsp;<?php echo JText::_('COMMENTS'); ?></span>
								</div>
								<?php } else {?> 
								<div class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
									<span><?php echo $comment; ?>&nbsp;<?php echo JText::_('COMMENT'); ?></span>
								</div>
							<?php }
							}
							if((int)$params->get('item_created_disp',1)) { ?>
							<div class="item-created <?php echo $oe[$nb++ % 2]; ?>">
								<span><?php echo JHTML::_('date', $item0->created,JText::_('DATE_FORMAT') ); ?></span>
							</div>
							<?php }
							if((int)$params->get('item_readmore_display',1)) { ?>
							<div class="item-readmore <?php echo $oe[$nb++ % 2]; ?>">
								<a href="<?php echo $item0->link; ?>" title="<?php echo $item0->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
									<span><?php echo JText::_('READ_MORE_TEXT'); ?></span>
								</a>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<?php if(!empty($items)) { ?>
					<ul class="megaii-other-item">
						<?php foreach($items as $item) { ?>
						<li class="item-other">
							<a href="<?php echo $item->link ?>" title="<?php echo $item->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >								
								<?php echo $item->displaytitle;?>
							</a>
							<?php if((int)$params->get('item_created_disp',1)) { ?>
							<span class="item-created">
								<?php echo JHTML::_('date', $item->created,JText::_('DATE_FORMAT') ); ?>
							</span>
							<?php } ?>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>
			<?php 
				$clear = 'clr1';
				if ($res % 2 == 0) $clear .= ' clr2';
				if ($res % 3 == 0) $clear .= ' clr3';
				if ($res % 4 == 0) $clear .= ' clr4';
				if ($res % 5 == 0) $clear .= ' clr5';
				if ($res % 6 == 0) $clear .= ' clr6';
				?>
			<div class="<?php echo $clear; ?>"></div> 
			<?php } ?>
			<div class="megaii-all">
				<a class="megaii-supercat" href="<?php echo $section['url']; ?>"  title="<?php echo $section['title']; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
					<span><?php echo JText::_('MORE_FROM_SECTION'); ?>
						<?php echo SjMegaK2ItemsIIHelper::truncate($section['title'],(int)$params->get('cat_title_max_characs','25')); ?>
					</span>
				</a>
				<a href="<?php echo $category['url']; ?>" title="<?php echo $category['title']; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
					<span><?php echo JText::_('MORE_FROM_CATEGOTY'); ?> 
						<?php echo SjMegaK2ItemsIIHelper::truncate($category['title'],(int)$params->get('sub_cat_title_max_characs','25')); ?>
					</span>
				</a>
			</div>
		</div>	
		<?php } ?>
	</div>	
</div>