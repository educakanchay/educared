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
<div class="megaii-header cf">
	<a href="<?php echo $section['url']; ?>" title="<?php echo $section['title']; ?> " <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
		<?php echo SjMegaK2ItemsIIHelper::truncate($section['title'],(int)$params->get('cat_title_max_characs','25')); ?>
	</a>
	<span class="megaii-button megaii-open"></span>
</div>

<?php if((int)$params->get('sub_cat_display',1)) { ?>
<div class="megaii-tabs-wrap">
	<span  class="tabs-previous tabs-direction">&laquo;</span>
	<div class="megaii-tabs-inner" >
		<ul class="megaii-tabs cf"  >
			<?php $i = 0; foreach($section['child_category'] as $category) { $i++; ?>
				<li data-catid="<?php echo $module->id.'-'.$category['id']; ?>" class="megaii-tab <?php echo ($i == 1)?' tab-selected':' '; ?>">
					<span>
						 <?php echo SjMegaK2ItemsIIHelper::truncate($category['title'],(int)$params->get('sub_cat_title_max_characs','25')); ?>
					</span>
				</li>
			<?php } ?>
		</ul>
	</div>
	<span  class="tabs-next tabs-direction">&raquo;</span>
</div>
<?php }  ?>
<div class="megaii-content <?php echo $colums; ?>" > 
	<div class="megaii-content-inner">
		<?php $cs = 0; foreach($section['child_category'] as $category) { $cs++; ?>
		<div class="megaii-content-catwrap <?php echo ($cs == 1)?' content-selected':' '; ?> <?php echo 'category-'.$module->id.'-'.$category['id']; ?>" >
			<?php $res = 0; foreach($category['child'] as $item) { $res++;
			?>
			<div class="megaii-item">
				<div class="megaii-item-inner">
					<div class="megaii-item-content">
						<?php
						
						$img = SjMegaK2ItemsIIHelper::getK2Image($item, $params);					
						$img = ImageHelper::init($img)->src();		
						if((is_file($img) && file_exists($img)) || SjMegaK2ItemsIIHelper::isUrl($img)){?>
						<div class="item-image">
							<a href="<?php echo $item->link ?>" title="<?php echo $item->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
								<img alt="<?php echo $item->displaytitle;?>" src="<?php echo $img;?>"/>	
							</a>
						</div>
						<?php } ?>
					
						<?php if($item->displaytitle != '') { ?>
						<div class="item-title">
							
							<a href="<?php echo $item->link ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->displaytitle?>" >
								<?php echo $item->displaytitle;?>
							</a>
						</div>
						<?php }
					
						if($item->displayIntrotext != '') { ?>
						<div class="item-desc">
							<?php echo $item->displayIntrotext; ?>
						</div>
						<?php }
						
						// show tags
				
						if($item->tags !=''){?>
							<div class="item-tags">
								<?php foreach ($item->tags as $tag): ?>
								<span class="tag-<?php echo $tag->id; ?>">
									<a class="label label-info" href="<?php echo $tag->link; ?>" title="<?php echo $tag->name; ?>" target="_blank"><?php echo $tag->name; ?></a>
								</span>
								<?php endforeach; ?>
							 </div>					
						<?php }						
						
						if((int)$params->get('item_nb_view_disp',1) || (int)$params->get('item_comment_disp',1) || (int)$params->get('item_created_disp',1) || (int)$params->get('item_readmore_display',1) ) { ?>
						<div class="item-info">
							<?php $oe = array('megaii-odd', 'megaii-even'); $nb = 0; ?>
							<?php if((int)$params->get('item_readmore_display',1)) { ?>
							<div class="item-readmore <?php echo $oe[$nb++ % 2]; ?>">
								<a href="<?php echo $item->link; ?>" title="<?php echo $item->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
									<span><?php echo JText::_('READ_MORE_TEXT'); ?></span>
								</a>
							</div>
							<?php }
							if((int)$params->get('item_nb_view_disp',1)) { ?>
							<div class="item-view <?php echo $oe[$nb++ % 2]; ?>">
								<span><?php echo JText::_('Read'); ?> <?php echo $item->hits; ?></span>
							</div>
							<?php } 
							if((int)$params->get('item_comment_disp',1)) {
								$comment = isset($item->count_comments)?(int)$item->count_comments:0;
								if($comment > 1) {
								?>
								<div class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
									<span><?php echo JText::_('COMMENTS'); ?>(<?php echo $comment; ?>)</span>
								</div>
								<?php } else{?> 
								<div class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
									<span><?php echo JText::_('COMMENT'); ?>(<?php echo $comment; ?>)</span>
								</div>
							<?php }
							}
							if((int)$params->get('item_created_disp',1)) { ?>
							<div class="item-created <?php echo $oe[$nb++ % 2]; ?>">
								<span><?php echo JHTML::_('date', $item->created,JText::_('DATE_FORMAT') ); ?></span>
							</div>
							<?php } ?>	
						</div>
						<?php } ?>
					</div>
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
				<a href="<?php echo $category['url']; ?>" title="<?php echo $category['title']; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
					<span>
						 <?php echo SjMegaK2ItemsIIHelper::truncate($category['title'],(int)$params->get('sub_cat_title_max_characs','25')); ?>
					</span>
				</a>
			</div>
		</div>	
		<?php } ?>
	</div>	
</div>