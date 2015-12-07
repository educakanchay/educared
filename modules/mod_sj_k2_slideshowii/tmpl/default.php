<?php
/**
 * @package Sj K2 Slideshow II
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;
if(!empty($list)) {
	
	$options = $params->toObject();
	ImageHelper::setDefault($params);
	$small_image_config=array(
			'width' 		=> $params->get('imgnavcfg_width'),
			'height' 		=> $params->get('imgnavcfg_height')
	);	
	
	if($params->get('start')<=0){
		$params->set('start',0);
	}else{
		$params->set('start',$params->get('start')-1);
	}
	if($params->get('start') >= count($list)){
		$params->set('start',count($list)-1);
	}

	$addclass ='';
	if($options->themes == 'theme1'){
		$addclass='top-left';
	}
	if($options->themes == 'theme2'){
		$addclass='top-right';
	}
	if($options->themes == 'theme3'){
		$addclass='bottom-left';
	}
	if($options->themes == 'theme4'){
		$addclass='bottom-right';
	}
	$uniquied = rand().time();?>

	<div id="sj_slideshowii_<?php echo $uniquied ;?>" class="sj-slideshowii" style="width:<?php echo ($options->themes != 'theme5' )?($options->imgcfg_width + $options->nav_width):$options->imgcfg_width; ?>px;">
		<?php if(!empty($options->pretext)) { ?>
		<div class="pre-text"><?php echo $options->pretext; ?></div>
		<?php } ?>
		<div class="sl2-wrap <?php echo $options->themes; ?>" style="height:<?php echo $options->imgcfg_height; ?>px;">
			<div class="sl2-items" style="width:<?php echo $options->imgcfg_width; ?>px; height:<?php echo $options->imgcfg_height; ?>px;">
				<?php $i=0; foreach($list as $item) { $i++;  ?>
				<div class="sl2-item <?php echo ($i==($options->start+1))?'curr':'';?>">
					<div class="sl2-image" style="width:<?php echo $options->imgcfg_width;  ?>px; height:<?php echo $options->imgcfg_height; ?>px;" >
						<a href="<?php echo $item->link;?>" title="<?php echo $item->title;?>" <?php echo modSjK2SlideShowiiHelper::parseTarget($options->item_link_target)?>>
							<?php $img = modSjK2SlideShowiiHelper::getK2Image($item, $params, $prefix='imgcfg' );
    							echo modSjK2SlideShowiiHelper::imageTag($img);?>
						</a>
					</div>
					<div class="sl2-more">
						<div class="sl2-opacity"></div>
						<?php if($options->item_title_display == 1){?>
						<div class="sl2-title">
							<a href="<?php echo $item->link;?>" title="<?php echo $item->title;?>" <?php echo modSjK2SlideShowiiHelper::parseTarget($options->item_link_target);?>>
								<?php echo modSjK2SlideShowiiHelper::truncate($item->title, $options->item_limit_title,'...' );?>
							</a>
						</div>
						<?php }?>
						<?php if($options->itemIntroText == 1){?>
						<div class="sl2-desc">
							<?php echo modSjK2SlideShowiiHelper::truncate($item->displayIntrotext, $params->get('itemIntroTextWordLimit',200), '...');?>	 
						</div>
						<?php }?>
						<?php if($options->item_readmore_display == 1) {?>
						<div class="sl2-readmore">
							<a href="<?php echo $item->link;?>" title="<?php echo $item->title;?>" <?php echo modSjK2SlideShowiiHelper::parseTarget($options->item_link_target);?>>
								<?php echo $options->item_readmore_text; ?>
							</a>
						</div>
						<?php }?>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="sl2-slide" style="width:<?php echo ($options->themes != 'theme5')?$options->nav_width:$options->imgcfg_width ?>px; height:<?php echo ($options->themes != 'theme5')?$options->imgcfg_height:$options->imgnavcfg_height + 20?>px;">
				<?php if($options->themes == 'theme5') {?>
					<?php if($options->nav_buttons_display == 1 || $options->nav_image_display == 1) {?>
					<div class="slide-opacity"></div>
					<?php }?>
					<?php if( $options->nav_buttons_display == 1) {?>
					<div class="slide-previous"></div>
					<?php }?>
				<?php }?>
				<div class="sl2-slide-inner" style="width:<?php echo ($options->themes != 'theme5')?$options->nav_width:'auto' ?>px; height:<?php echo ($options->themes != 'theme5')?$options->imgcfg_height:$options->imgnavcfg_height + 20?>px;right:<?php echo ($options->themes == 'theme5' && $options->nav_buttons_display == 0)?10:''?>px ;left:<?php echo ($options->themes == 'theme5' && $options->nav_buttons_display == 0)?10:''?>px;">
					<div class="slide-items">
						<?php $j =0 ; foreach($list as $key => $item) { $j++; ?>
						<div class="slide-item slide-item<?php echo $j; ?> <?php echo ($j==($options->start+1))?'active':'';?>">
							<div class="slide-item-inner" style="height:<?php echo ($options->themes != 'theme5')?(floor($options->imgcfg_height / $options->num_item_per_page) -30):''; ?>px;">
								<?php if($options->nav_image_display == 1){?>
								<div class="slide-image" style="width:<?php echo $options->imgnavcfg_width; ?>px; height:<?php echo $options->imgnavcfg_height  ?>px; max-height:<?php  echo ($options->themes != 'theme5')?(floor($options->imgcfg_height / $options->num_item_per_page) -34):''; ?>px; max-width:<?php echo ($options->themes != 'theme5')?($options->nav_width - 34):''?>px;" >
									<?php $img_nav = modSjK2SlideShowiiHelper::getK2Image($item, $params, $prefix='imgnavcfg' );
	    							echo modSjK2SlideShowiiHelper::imageTag($img_nav, $small_image_config);?>
								</div>
								<?php }?>
								<?php if($options->themes != 'theme5') {?>
								<div class="slide-more">
									<?php if($options->nav_title_display == 1) {?>
									<div class="slide-title">
										<?php echo modSjK2SlideShowiiHelper::truncate($item->title, $options->nav_limit_title, '...' );?>
									</div>
									<?php } ?>
									<?php if($options->nav_desc_display == 1){?>
									<div class="slide-desc">
										<?php echo modSjK2SlideShowiiHelper::truncate($item->displayIntrotext, $params->get('nav_limit_desc',50), '...');?>
									</div>
									<?php }?>
								</div>
								<?php }?>

							</div>
						</div>
						<?php } ?>
					</div>
				</div>	
				<?php if($options->themes == 'theme5' && $options->nav_buttons_display == 1) {?>
				<div class="slide-next"></div>
				<?php }?>
			</div>
			<?php if ($options->themes != 'theme5' && $options->nav_buttons_display == 1) {?>
				<div class="sl2-control <?php echo $addclass; ?>">
					<div class="sl2-ctr previous"></div>
					<div class="sl2-ctr play-pause <?php echo ($options->play==1) ? 'pause' : 'play'; ?>"></div>
					<div class="sl2-ctr next"></div>
				</div>
			<?php }?>
			
		</div>
			<?php if(!empty($options->posttext)) {  ?>
			<div class="post-text"><?php echo $options->posttext; ?></div>
			<?php }?>
	</div><!--End sj-content-slideshow-->
	
	<script type="text/javascript">
	//<![CDATA[		
	jQuery(document).ready(function($){
		/* slide navigation for theme 1, 2, 3, 4  
		*/
		function setSlidingTo(index, options){
			var tabs = $(options.pager);
			var tabs_holder = tabs.eq(0).parent();
			var tabs_container = tabs_holder.parent();
			if (tabs_container && tabs_holder){
				tabs_container.css({height: function(){
					return tabs_container.height();
				}});
				tabs_container.css({position: 'absolute'});
				tabs_holder.css({position: 'absolute'});
			}
			
			var viewport   = {};
			viewport.top  = 0;
			viewport.bottom = tabs_container.height();
			
			var visible   = {};
			visible.top  = viewport.top  - parseInt( tabs_holder.position().top );
			visible.bottom = viewport.bottom - parseInt( tabs_holder.position().top );
		
			var posUpdate = function(){
				visible.top  = viewport.top  - parseInt( tabs_holder.position().top );
				visible.bottom = viewport.bottom - parseInt( tabs_holder.position().top );
			};
			
			var slidingTo = function(index, d){
				if (!d){
					d = 500
				}
				if (index >= 0){
					if (index == 0){
						index = 1;
					}
					var prevTop = tabs.eq(index-1).position().top;
					//console.log(visible.bottom);
					if (prevTop < visible.top){
						tabs_holder.animate({
							top: '+='+(visible.top-prevTop)+'px'
						}, {
							duration: d,
							complete: posUpdate,
							queue:false 
						});
					}
				}
				if (index < tabs.length){
					if (index == tabs.length-1){
						index = tabs.length-2;
					}
					var nextBottom = tabs.eq(index+1).position().top + tabs.eq(index+1).height();
					if (nextBottom > visible.bottom && index !=1 ){
						tabs_holder.animate({
							top: '-='+(nextBottom-visible.bottom)+'px'
						}, {
							duration: d,
							complete: posUpdate,
							queue:false 
						});
					}
				}
			};								
			slidingTo(index);	
		}
		
		/* slide navigation for theme 5  
		*/
		function setSlidingToX(index, options){
			var tabs = $(options.pager);
			var tabs_holder = tabs.eq(0).parent();
			var tabs_container = tabs_holder.parent();
				 //console.log(tabs); 
				//console.log(tabs_holder);
				 //console.log(tabs_container); 
			if (tabs_container && tabs_holder){
				tabs_container.css({height: function(){
					return tabs_container.height();
				}});
				tabs_container.css({position: 'absolute'});
				tabs_holder.css({position: 'absolute'});
			}
			var viewport   = {};
			viewport.left  = 0;
			viewport.right = tabs_container.width();
			
			var visible   = {};
			visible.left  = viewport.left  - parseInt( tabs_holder.position().left );
			visible.right = viewport.right - parseInt( tabs_holder.position().left );
			
			var posUpdate = function(){
				visible.left  = viewport.left  - parseInt( tabs_holder.position().left );
				visible.right = viewport.right - parseInt( tabs_holder.position().left );
			};
			
			var slidingTo = function(index, d){
				if (!d){
					d = 500
				}
				if (index >= 0){
					if (index == 0){
						index = 1;
					}
					var prevLeft = tabs.eq(index-1).position().left;
					if (prevLeft < visible.left){
						tabs_holder.animate({
							left: '+='+(visible.left-prevLeft)+'px'
						}, {
							duration: d,
							complete: posUpdate,
							queue:false 
						});
					}
				}
				if (index < tabs.length){
					if (index == tabs.length-1){
						index = tabs.length-2;
					}
					var nextRight = tabs.eq(index+1).position().left + tabs.eq(index+1).width();
					if (nextRight > visible.right){
						tabs_holder.animate({
							left: '-='+(nextRight-visible.right)+'px'
						}, {
							duration: d,
							complete: posUpdate,
							queue:false 
						});
					}
				}
			};								
			slidingTo(index);	
		}
		<?php if(count($list) > 1){?>
			$('#sj_slideshowii_<?php echo $uniquied ;?>  .sl2-items').cycle({	
				slideExpr: '.sl2-item',
				before: function(curr, next, options){
					$('#sj_slideshowii_<?php echo $uniquied ;?>  .sl2-item').eq(options.startingSlide).addClass('curr');
					if (typeof options.inited == 'undefined'){
						var slidingTo = options.startingSlide;
						options.inited = true;					
						if(typeof options.fxs != 'undefined'){						
							var tmp=[];
							var j=0;					
							for(var i=0;i<options.fxs.length;i++){
								if(options.fxs[i]=='none'){												
									continue;
								}
								
								tmp[j++]=options.fxs[i];							
							}
							if(tmp.length!=options.fxs.length){
								options.fxs=tmp;
							}						
						}										
					} else {
						var slidingTo = options.nextSlide;
						$('#sj_slideshowii_<?php echo $uniquied ;?>  .sl2-item').removeClass('curr');
						$('#sj_slideshowii_<?php echo $uniquied ;?>  .sl2-item').eq(options.nextSlide).addClass('curr');
					}
					<?php if($options->themes != 'theme5'){?>
						setSlidingTo(slidingTo, options);
					<?php } else { ?>
						setSlidingToX(slidingTo, options);
					<?php }?>
				}, 
				fx: '<?php echo $params->get('effect', 'all'); ?>',
				speed: <?php echo $params->get('slideshow_speed', '500'); ?>,
				timeout: <?php echo $params->get('timer_speed', 0); ?>,
				pause:<?php echo (int)$options->pause_hover; ?>,
				pauseOnPagerHover:<?php echo (int)$options->pause_hover; ?>,
				startingSlide: <?php echo $params->get('start', 0); ?>,
				pager: '#sj_slideshowii_<?php echo $uniquied ;?> .slide-items .slide-item',
				pagerAnchorBuilder: function(i, el){
					return $('#sj_slideshowii_<?php echo $uniquied ;?>  .slide-items .slide-item:eq(' + i + ')');
				},
				updateActivePagerLink: function(pager, i, clsName){
					$(pager).removeClass('active').eq(i).addClass('active');
				},
				<?php if($options->themes != 'theme5') {?>
				next: '#sj_slideshowii_<?php echo $uniquied ;?> .sl2-control .next',
				prev: '#sj_slideshowii_<?php echo $uniquied ;?> .sl2-control .previous',
				<?php } else {?>
				next: '#sj_slideshowii_<?php echo $uniquied ;?> .slide-next',
				prev: '#sj_slideshowii_<?php echo $uniquied ;?> .slide-previous',
				<?php }?>
				skipInitializationCallbacks: false,
				pagerEvent: 'click' 	
				
			});
			
			$('#sj_slideshowii_<?php echo $uniquied ;?> .play-pause').bind('click',function(){
					if ( $(this).hasClass('pause') ){
						$(this).addClass('play');
						$(this).removeClass('pause');					
						$('#sj_slideshowii_<?php echo $uniquied ;?> .sl2-wrap .sl2-items').cycle('pause');
					}else{
						$(this).removeClass('play');
						$(this).addClass('pause');
						$('#sj_slideshowii_<?php echo $uniquied ;?> .sl2-wrap .sl2-items').cycle('resume');
					}
			});
			
			<?php if($options->play==0): ?>
				$('#sj_slideshowii_<?php echo $uniquied ;?> .sl2-wrap  .sl2-items').cycle('pause');
			<?php endif; ?>
		<?php }?>
	});
	//]]>
</script>
<?php } else { echo JText::_('Has no content to show!');}?>

