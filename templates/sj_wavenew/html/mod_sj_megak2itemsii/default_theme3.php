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
$colums1 = ' megaii-rps01-2 megaii-rps02-2  megaii-rps03-2 megaii-rps04-1';
?>
<div class="megaii-header cf">
	<?php if((int)$params->get('sub_cat_display',1)) { ?>
	<div class="megaii-tabs-wrap">
		<div class="megaii-tabs-inner">
			<ul class="megaii-tabs cf">
				<?php $i = 0; foreach($section['child_category']  as $category) { $i++; ?>
					<li data-catid="<?php echo $module->id.'-'.$category['id']; ?>" class="megaii-tab <?php echo ($i == 1)?' tab-selected':' '; ?>">
						<?php
							$cate= SjMegaK2ItemsIIHelper::truncate($category['title'],(int)$params->get('sub_cat_title_max_characs','25'));
							$string_color1=strstr($cate,"|");
							$string_cate=str_replace($string_color1, "", $cate);
						?>
						<span>
							<?php echo $string_cate; ?>
						</span>
					</li>
					<li class="megaii-tab backslash">&#92;</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php } ?>
</div>
<div class="megaii-content <?php echo $colums1; ?>" > 
	<div class="megaii-content-inner">
		<?php $cs = 0; foreach($section['child_category'] as $category) { $cs++; ?>
		<div class="megaii-content-catwrap <?php echo ($cs == 1)?' content-selected':' '; ?> <?php echo 'category-'.$module->id.'-'.$category['id']; ?>" >
			<?php  //$res = 0;
			$item0 = array_shift($category['child']);
			$items = $category['child'];
			//foreach($category->child as $item) { $res++;
			?>
			<div class="megaii-item-wrap">
				<div class="megaii-item megaii-first">
					<div class="megaii-item-inner cf">
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
							<h3 class="item-title">
								
								<a href="<?php echo $item0->link ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item0->displaytitle?>" >
									<?php echo $item0->displaytitle;?>
								</a>
							</h3>
							<?php }?>
							
							<?php if((int)$params->get('item_nb_view_disp',1) || (int)$params->get('item_comment_disp',1) || (int)$params->get('item_created_disp',1) || (int)$params->get('item_readmore_display',1) ) { ?>
							<?php $oe = array('megaii-odd', 'megaii-even'); $nb = 0; ?>
							<aside class="article-aside">
								<dl class="article-info  muted">
									<dt></dt>
									<!-- Date created -->
									<dd class="create"><i class="fa fa-clock-o"></i><?php echo JHTML::_('date', $item0->created , 'j M Y'); ?></dd>		
									
								      <!-- Item Hits -->
									<?php if((int)$params->get('item_nb_view_disp',1)) { ?>
									<dd class="catItemHitsBlock">
										<span class="catItemHits">
											<i class="fa fa-eye"></i><b><?php echo $item0->hits; ?></b> <?php echo JText::_('JGLOBAL_HITS'); ?> 
											
										</span>
									</dd>
									<?php }?>
									<?php if((int)$params->get('item_comment_disp',1)) { 
									$comment = isset($item0->count_comments)?(int)$item0->count_comments:0;
									if($comment > 1) {
									?>
									<dd class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
										<span><i class="fa fa-comments"></i><?php echo $comment; ?> <?php echo JText::_('COMMENTS'); ?></span>
									</dd>
									<?php } else { ?> 
									<dd class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
										<span><i class="fa fa-comments"></i><?php echo $comment; ?> <?php echo JText::_('COMMENT'); ?></span>
									</dd>	
									<?php } 
									}?>
									
								</dl>
							</aside>
							<?php }?>
							<?php if($item0->displayIntrotext != '') { ?>
							<div class="item-desc">
								<?php echo $item0->displayIntrotext; ?>
							</div>
							<?php }?>
							<div class="item-read">
								<a href="<?php echo $item0->link ?>" title="<?php echo $item0->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
									<?php echo JText::_('ME_K2_READ_MORE'); ?>
								</a>
							</div>
							<?php if($item0->tags !=''){?>
								<div class="item-tags">
									<?php foreach ($item0->tags as $tag): ?>
									<span class="tag-<?php echo $tag->id; ?>">
										<a class="label label-info" href="<?php echo $tag->link; ?>" title="<?php echo $tag->name; ?>" target="_blank"><?php echo $tag->name; ?></a>
									</span>
									<?php endforeach; ?>
								 </div>					
							<?php }	?>
							
							
						</div>
					</div>
				</div>
				<div class="megaii-item megaii-other">
					<div class="megaii-item-inner">
						<?php if(!empty($items)) { ?>
						<ul class="megaii-other-item">
							<?php foreach($items as $item) {
								$img_other= SjMegaK2ItemsIIHelper::getK2Image($item, $params);
								?>
							<li class="item-other">
								<div class="item-image">
									<a href="<?php echo $item->link ?>" title="<?php echo $item->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
										<?php echo SjMegaK2ItemsIIHelper::imageTag($img_other);?>	
									</a>
								</div>
								<div class="item-info-other">
									<h3 class="title">
										<a href="<?php echo $item->link ?>" title="<?php echo $item->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
											<?php echo $item->displaytitle;?>
										</a>
									</h3>
									<aside class="article-aside">
										<dl class="article-info  muted">
											<dt></dt>
											<!-- Date created -->
											<dd class="create"><i class="fa fa-clock-o"></i><?php echo JHTML::_('date', $item->created , 'j M Y'); ?></dd>		
											
										      <!-- Item Hits -->
											<?php if((int)$params->get('item_nb_view_disp',1)) { ?>
											<dd class="catItemHitsBlock">
												<span class="catItemHits">
													<i class="fa fa-eye"></i><b><?php echo $item->hits; ?></b> <?php echo JText::_('JGLOBAL_HITS'); ?> 
													
												</span>
											</dd>
											<?php }?>
											<?php $comment = isset($item->count_comments)?(int)$item->count_comments:0;
											if($comment > 1) {
											?>
											<dd class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
												<span><i class="fa fa-comments"></i><?php echo $comment; ?> <?php echo JText::_('COMMENTS'); ?></span>
											</dd>
											<?php } else { ?> 
											<dd class="item-comment <?php echo $oe[$nb++ % 2]; ?>">
												<span><i class="fa fa-comments"></i><?php echo $comment; ?> <?php echo JText::_('COMMENT'); ?></span>
											</dd>	
											<?php }?>
											
										</dl>
									</aside>
									<div class="item-desc">
										<?php echo $item->displayIntrotext; ?>
									</div>
									<div class="item-read">
										<a href="<?php echo $item->link ?>" title="<?php echo $item->displaytitle; ?>" <?php echo SjMegaK2ItemsIIHelper::parseTarget($params->get('link_target')); ?> >
											<?php echo JText::_('ME_K2_READ_MORE'); ?>
										</a>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div>
				</div>
			</div>	
		</div>	
		<?php } ?>
	</div>	
</div>