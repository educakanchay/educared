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
	$ts = $width/$params->get('imgcfg_width');
	$big_w = $width/2;
	$small_w = $width/4;
	$big_h = ($params->get('imgcfg_height')*$ts/2);
	$small_h = ($params->get('imgcfg_height_sm')*$ts/4);
	if($widthW < 768){
		$big_w = $width;
		$small_w = $width;
		$big_h = ($params->get('imgcfg_height')*$ts);
		$small_w = ($params->get('imgcfg_height')*$ts);
	}
	
	$small_image_config = array(
    'type' => $params->get('imgcfg_type_sm'),
    'width' => $small_w,
    'height' => $small_h,
    'quality' => 90,
    'function' => ($params->get('imgcfg_function_sm') == 'none') ? null : 'resize',
    'function_mode' => ($params->get('imgcfg_function_sm') == 'none') ? null : substr($params->get('imgcfg_function_sm'), 7),
    'transparency' => $params->get('imgcfg_transparency_sm', 1) ? true : false,
    'background' => $params->get('imgcfg_background_sm'));
	$big_image_config = array(
    'type' => $params->get('imgcfg_type'),
    'width' => $big_w,
    'height' => $big_h,
    'quality' => 90,
    'function' => ($params->get('imgcfg_function') == 'none') ? null : 'resize',
    'function_mode' => ($params->get('imgcfg_function') == 'none') ? null : substr($params->get('imgcfg_function'), 7),
    'transparency' => $params->get('imgcfg_transparency', 1) ? true : false,
    'background' => $params->get('imgcfg_background'));
	
    $options=$params->toObject();
	
?>
<div class="sj-highlight-items-loading" style="width:<?php echo $width;?>px;height:<?php echo $big_h*2;?>px"></div>
<div id="" class="owl-demo owl-carousel owl-theme">

	<?php
		$index = 1;
		
		$typeP = $params->get('k2_highlight_items_type_chose_slide');
		$arrayT = explode("-",$typeP);
		$count = 0;	
		$checkS = 1;
				foreach($list as $item){
					if($widthW < 768){
						echo '<div class="item">';
							$img = K2HighlightItemsHelper::getK2Image($item, $params);
							if ($img) {
								echo K2HighlightItemsHelper::imageTag($img,$big_image_config);
							}
							if($options->k2_highlight_items_chose_type_slide == 0){
								K2HighlightItemsHelper::viewSlide($item,$options);
							}else{
								K2HighlightItemsHelper::viewSlide($item,$options,1);
							}
						echo '</div>';
						$index++;
						if($index == $params->get('k2_highlight_items_count_slide_one') + 1)break;
						continue;
					}
					
					if($index%$params->get('k2_highlight_items_count_in_slide') == 1){
						echo '<div class="item">';
						$countI = 0;
						$count = 0;
						$i = 0;
					}
					if($params->get('k2_highlight_items_count_in_slide') == 4){
						echo '<div class="k2_highlight_items_50 float k2_item">';
							$img = K2HighlightItemsHelper::getK2Image($item, $params);
							if ($img) {
								echo K2HighlightItemsHelper::imageTag($img,$big_image_config);
							}
						if($options->k2_highlight_items_chose_type_slide == 0){
							K2HighlightItemsHelper::viewSlide($item,$options);
						}else{
							K2HighlightItemsHelper::viewSlide($item,$options,1);
						}
						echo '</div>';
						if($index%$params->get('k2_highlight_items_count_in_slide') == 0){
							echo '</div>';
						}
						$index++;
						continue;
					}
					if($params->get('k2_highlight_items_count_in_slide') == 8){
						echo '<div class="k2_highlight_items_25 float k2_item">';
						$img = K2HighlightItemsHelper::getK2Image($item, $params);
							if ($img) {
								echo K2HighlightItemsHelper::imageTag($img,$small_image_config);
							}
						if($options->k2_highlight_items_chose_type_slide == 0){
							K2HighlightItemsHelper::viewSlide($item,$options);
						}else{
							K2HighlightItemsHelper::viewSlide($item,$options,1);
						}
						echo '</div>';
						if($index%$params->get('k2_highlight_items_count_in_slide') == 0){
							echo '</div>';
						}
						$index++;
						continue;
					}
					if($params->get('k2_highlight_items_type_slide') == 0){
							if(isset($arrayT[$i]) && $arrayT[$i] == 1){
								echo '<div class="k2_highlight_items_50 float k2_item">';
									$img = K2HighlightItemsHelper::getK2Image($item, $params);
								if ($img) {
									echo K2HighlightItemsHelper::imageTag($img,$big_image_config);
								}
								if($options->k2_highlight_items_chose_type_slide == 0){
									K2HighlightItemsHelper::viewSlide($item,$options);
								}else{
									K2HighlightItemsHelper::viewSlide($item,$options,1);
								}
								echo '</div>';
							}else{
								echo '<div class="k2_highlight_items_25 float k2_item">';
									$img = K2HighlightItemsHelper::getK2Image($item, $params);
								if ($img) {
									echo K2HighlightItemsHelper::imageTag($img,$small_image_config);
								}
								if($params->get('k2_highlight_items_chose_type_slide') == 0){
									K2HighlightItemsHelper::viewSlide($item,$options);
								}else{
									K2HighlightItemsHelper::viewSlide($item,$options,1);
								}
								echo '</div>';
							}
						$i++;
					}
					if($index%$params->get('k2_highlight_items_count_in_slide') == 0){
						echo '</div>';
					}
					$index++;
					if($index == (count($list) + 1)){
						echo '</div>';
						break;
					}
					if($options->k2_highlight_items_chose_type_slide == 1){
						if($index == ($params->get('k2_highlight_items_count_in_slide') + 1)){
							echo '</div>';
							break;
						}
					}
				}
			
		
	?>
 </div>
	<script type="text/javascript">

jQuery(document).ready(function ($) {

		
    <!--<?php if(($width < 900 && $widthW>600) or ($width < 600)){?>   
		var tt = 0;
		$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_item').click(function(){
			if(tt == 0){
				$(this).find('.k2_highlight_items_info_no_slide').animate({top: "0px"});
				tt=1;
			}else{
				$(this).find('.k2_highlight_items_info_no_slide').animate({top: $(this).find('.k2_highlight_items_info_no_slide').attr('data-top')});
				tt=0;
			}
				
		});
			
	<?php }?>-->
     
	<?php if($options->k2_highlight_items_chose_type_slide == 0 or ($widthW < 768)){?>
      var time = <?php echo $params->get('interval');?>;
      var $progressBar,
          $bar, 
          $elem, 
          isPause, 
          tick,
          percentTime;

        $("#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-demo").owlCarousel({
          slideSpeed : 500,
          paginationSpeed : 500,
          singleItem : true,
          afterInit : progressBar,
          afterMove : moved,
          startDragging : pauseOnDragging
        });


        function progressBar(elem){
          $elem = elem;
          buildProgressBar();
          start();
        }


        function buildProgressBar(){
          $progressBar = $("<div>",{
            class:"progressBar"
          });
          $bar = $("<div>",{
            class:"bar"
          });
          $progressBar.append($bar).prependTo($elem);
        }

        function start() {
          percentTime = 0;
          isPause = false;
          tick = setInterval(interval, 10);
        };

        function interval() {
          if(isPause === false){
            percentTime += 1 / time;
            $bar.css({
               width: percentTime+"%"
             });
            if(percentTime >= 100){ 
              $elem.trigger('owl.next')
            }
          }
        }
		

        function pauseOnDragging(){
          isPause = true;
        }
		
        function moved(){
          clearTimeout(tick);
          start();
        };
		<?php if($params->get('pause_hover') == 1){?>
		$elem.on('mouseover',function(){
           isPause = true;
         });
         $elem.on('mouseout',function(){
           isPause = false;
         });
		
		<?php }?>
		
		<?php }?>
		$("#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_25").css('height',parseInt(<?php echo ($params->get('imgcfg_height')*$ts/2);?>)+'px');
		$("#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_50").css('height',parseInt(<?php echo ($params->get('imgcfg_height')*$ts/2);?>)+'px');
		<?php if($options->k2_highlight_items_chose_type_slide == 1){?>
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-carousel').css('display','block');
			var length = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_no_slide').length;
			setTimeout(function(){ 
			for(var i = 0; i < length; i++){
				widthI = parseInt($('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_hits').eq(i).css('width'))+1;
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_hits').eq(i).css('margin','auto');
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_hits').eq(i).css('width',widthI+'px');
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_hits').eq(i).css('float','none');
				
				var height = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_no_slide').eq(i).css('height');
				var heightI = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_height').eq(i).css('height');
				var marginH = parseInt((parseInt(height) - parseInt(heightI)));
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_no_slide').eq(i).css('top',marginH+'px');
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_no_slide').eq(i).attr('data-top',marginH+'px');
				
			}
			},500);
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_item').mouseenter(function(){
				$(this).find('.k2_highlight_items_info_no_slide').animate({top: "0px"});
			});
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_item').mouseleave(function(){
				$(this).find('.k2_highlight_items_info_no_slide').animate({top: $(this).find('.k2_highlight_items_info_no_slide').attr('data-top')});
			});
		<?php }?> 
		
    });
    </script>