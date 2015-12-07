<?php
/*
 * @package Sj K2 Simple Tabs
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

ImageHelper::setDefault($params);
?>
<?php 
	include JModuleHelper::getLayoutPath($module->module, $layout.'_tabs');
	if (in_array($params->get('position', 'top'), array('top', 'left'))){
		echo $tabs_markup;
	}?>
<div class="spt-tabs-content" >
	<?php $j=1;
	foreach($list as $key=>$items){
		$item0=array_shift($items[1]);
		$list_child = $items[1];
		
		$img = K2SimpleTabsHelper::getK2Image($item0, $params);					
		$img = ImageHelper::init($img)->src();	
		
		$condition_col1 = $img;
		$condition_col2 = ( $item0->displaytitle !='' || $item0->displayIntrotext !='' || ((int)$params->get('item_readmore_display', 1) && ($params->get('item_readmore_text') !='')) || $item0->tags != ''  );
		$condition_col3 = (!empty($list_child) &&  ( (int)$params->get('other_title_display',1) || (int)$params->get('item_viewall_display', 1))) ;
		$class_col = '';
		if($condition_col1 && $condition_col2 && $condition_col3 ){
			$class_col = '';
		}else if(($condition_col1 && $condition_col2) || ($condition_col1 && $condition_col3) || ($condition_col2 && $condition_col3) ){
			$class_col = ' spl-col50';
		}else if($condition_col1 || $condition_col2 || $condition_col3){
			$class_col = ' spl-col100';
		}
		
		?>
		<div  class="spt-tab-content category-id-<?php echo $key; ?>  <?php if($j==1) echo "selected";?>">
		<?php if((is_file($img) && file_exists($img)) || K2SimpleTabsBaseHelper::isUrl($img)){?>
				<div class="spt-col-one spt-col <?php echo $class_col; ?> ">
					<div class="spt-col-inner">
						<a title="<?php echo  $item0->title; ?>" href="<?php echo $item0->link;?>"  <?php echo K2SimpleTabsHelper::parseTarget($params->get('item_link_target','_blank')); ?>>
							<img alt="<?php echo $item0->title;?>" src="<?php echo $img;?>"/>	
						</a>
					</div>
				</div>
			<?php  } 
			if($condition_col2){ ?>	
			<div class="spt-col-two spt-col <?php echo $class_col; ?>" >
			   <div class="spt-col-inner">
					<?php if($item0->displaytitle !=''){?>
					<div class="spt-title">
						<a title="<?php echo  $item0->title; ?>" href="<?php echo $item0->link;?>" <?php echo K2SimpleTabsHelper::parseTarget($params->get('item_link_target','_blank')); ?>>
							<?php echo $item0->displaytitle;?>
						</a>  					
					</div><!--end spt-title-->
					<?php }?>
						
					<?php if($item0->displayIntrotext != '') { ?>
						<div class="spt-desc" >
						  <?php echo $item0->displayIntrotext;?>
						</div><!--end art_desc-->
					<?php }?>
					
					<?php if($item0->tags !=''){?>
					
					<div class="spt-tags">				
						<?php foreach ($item0->tags as $tag):?>
							<span class="tag-<?php echo $tag->id; ?>">
								<a class="label label-info" href="<?php echo $tag->link; ?>" title="<?php echo $tag->name; ?>" target="_blank"><?php echo $tag->name; ?></a>
							</span>
						<?php endforeach; ?>					
					</div>			
					<?php }	?>
					
					<?php if( (int)$params->get('item_readmore_display', 1) && ($params->get('item_readmore_text') !='')){ ?>
						<div class="spt-more"> 
							<a title="<?php echo  $item0->title; ?>" href="<?php echo $item0->link;?>" <?php echo K2SimpleTabsHelper::parseTarget($params->get('item_link_target','_blank')); ?>>
								<?php echo $params->get('item_readmore_text'); ?>
							</a>
						</div>
					<?php }?>
				</div>
			</div>
			<?php }
			if(!empty($list_child)) {?>			
				<div class="spt-col-three spt-col <?php echo $class_col; ?>">
				   <div class="spt-col-inner"> 
						<ul class="spt-other-items"> 
						  <?php $i=0; foreach ($list_child as $key=>$item){ if($i>=0){?>
							<li class="spt-other-item">	
								<?php if((int)$params->get('other_title_display',1)){?>						
								<div class="spt-other-title">
									<a title="<?php echo $item->title; ?>" href="<?php echo $item->link?>" <?php echo K2SimpleTabsHelper::parseTarget($params->get('item_link_target','_blank')); ?> >
										<?php echo $item->othertitle;?>
									</a>  					
								</div>
								<?php }?>
							</li>
						  <?php } $i++;}?>                        
						</ul>
					<?php if ((int)$params->get('item_viewall_display', 1)) { ?>
						<div class="spt-viewall-link">                               
							<a href="<?php echo $items[0]['link'];?>" title="<?php echo $items[0]['name']; ?>" <?php echo K2SimpleTabsHelper::parseTarget($params->get('item_link_target','_blank')); ?> >
								<?php echo $params->get('item_viewall_text');?> 
							</a>  	                                              
						</div>
					<?php }?> 
				   </div>
				</div>
			<?php } ?>	
		</div>  
		<?php
		$j++; 
	}?>
</div> <!-- END spt-tabs-content -->
  <?php
	if (in_array($params->get('position', 'top'), array('right', 'bottom'))){
		echo $tabs_markup;
	}
?>
