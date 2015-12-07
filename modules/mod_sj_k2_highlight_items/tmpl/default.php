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
	JHtml::stylesheet('modules/'.$module->module.'/assets/css/owl.theme.css');
  if(!empty($list)){
    JHtml::stylesheet('modules/'.$module->module.'/assets/css/style.css');
    JHtml::stylesheet('modules/'.$module->module.'/assets/css/owl.carousel.css');
    JHtml::stylesheet('modules/'.$module->module.'/assets/css/font-awesome.min.css');
	
	if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
		JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
		JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
		define('SMART_JQUERY', 1);
	}
	
	JHtml::script('modules/'.$module->module.'/assets/js/owl.carousel.js');
	echo '<div id="sj-highlight-items-for-k2-id-'.$module->id.'" class="sj-highlight-items-for-k2">';
	echo '<div class="sj_pretext">'.$params->get('pretext').'</div>';
	if($params->get('k2_highlight_items_chose_type_slide') == 0) {
	echo '<div class="sj-highlight-items-show-tabs">';
		echo '<div class="sj-highlight-items-content-tabs"><div class="sj-highlight-items-content-tabs-title"></div><div class="sj-highlight-items-content-tabs-content"></div><div class="sj-highlight-items-content-tabs-border"><i class="fa fa-bolt"></i></div></div>';
		echo '<div class="sj-highlight-items-content-item-tabs">';
			if($params->get('tab_all_display') == 1){
				if($cid == 0){
					$cls = ' sj_focus';
				}else{
					$cls = '';
				}
				echo '<div class="sj-highlight-items-content-tab'.$cls.'" data-title="'.htmlspecialchars($params->get('title_tab_all')).'" data-content="'.htmlspecialchars($params->get('des_tab_all')).'" data-id="all">All</div>';
			}
			$key = 0;
			foreach($tabs as $index=>$item){
				if($params->get('tab_all_display') == 1 && $key == 0){
					$key++;
					continue;
				}
				if($cid == $index){
					$cls = ' sj_focus';
				}else{
					$cls = '';
				}
				
				echo '<div class="sj-highlight-items-content-tab'.$cls.'" data-title="'.htmlspecialchars($item['name']).'" data-content="'.htmlspecialchars($item['description']).'" data-id="'.htmlspecialchars($index).'">'.htmlspecialchars($item['name']).'</div>';
			}
		echo '</div>';
	echo '</div>';
	}
	echo '<div class="sj-highlight-items-show-content"></div>';
	echo '<div class="sj_posttext">'.$params->get('posttext').'</div>';
	echo '</div>';
	$url = JURI::getInstance();
	if ( strlen(strstr($url,'?')) > 0 ) {
		$ex = explode('?',$url);
		$url = $ex[0];
	}
	?>
<script>
//<![CDATA[    					
	jQuery(document).ready(function($){
		var Bwidth = parseInt(document.documentElement.clientWidth);
		var url_ajax = '<?php echo $url; ?>';
		
		var sj_highlight_items_for_k2_id_ajax = 1;
		<?php if($params->get('k2_highlight_items_chose_type_slide') == 1){?>
			var id = 'all';
		<?php }else{ ?>
			var id = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-item-tabs .sj_focus').attr('data-id');
		<?php }?>
		
		var width = parseInt($('#sj-highlight-items-for-k2-id-<?php echo $module->id;?>').css('width'));
		$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-carousel').css('opacity','0');
		$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-loading').css('display','block');
		$.ajax({
			type: 'POST',
			url: url_ajax,
			data: {
				cat: id,
				width:width,
				sj_highlight_items_for_k2_id_ajax:1,
				mid:'<?php echo $module->id;?>',
				widthW:Bwidth
			},
			success: function (data) {
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-loading').css('display','none');
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-show-content').html(data['items_markup']);
				$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-item .item').eq(0).find('.k2_item').css('opacity','0');
				var countI = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-item .item').eq(0).find('.k2_item').length;
				var index = 0;
				var q = setInterval(function(){  
					if(index == countI){clearInterval(q);}
					$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-item .item').eq(0).find('.k2_item').eq(index).animate({opacity: "1"},500);
					index++;
				}, 50);
				setTimeout(function(){ 
				var length = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_read').length;
				for(var i = 0; i < length; i++){
				var widthI = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_read').eq(i).width();
				
				}
							
				}, 500);
				
			},
				dataType: 'json'
			});	
		<?php if($params->get('k2_highlight_items_chose_type_slide') == 0) {?>
		$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-tab').click(function(){
			var id=$(this).attr('data-id');
			var title=$(this).attr('data-title');
			var content=$(this).attr('data-content');
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-tabs .sj-highlight-items-content-tabs-title').html(title);
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-tabs .sj-highlight-items-content-tabs-content').html(content);
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-tab').removeClass('sj_focus');
			$(this).addClass('sj_focus');
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-carousel').css('opacity','0');
			$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-loading').css('display','block');
			$.ajax({
				type: 'POST',
				url: url_ajax,
				data: {
					cat: id,
					width:width,
					sj_highlight_items_for_k2_id_ajax:1,
					mid:'<?php echo $module->id;?>',
					widthW:Bwidth
				},
				success: function (data) {
					$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-show-content').html(data['items_markup']);
					$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-loading').css('display','none');
					$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-item .item').eq(0).find('.k2_item').css('opacity','0');
					var countI = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-item .item').eq(0).find('.k2_item').length;
					var index = 0;
					var q = setInterval(function(){  
						if(index == countI){clearInterval(q);}
						$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .owl-item .item').eq(0).find('.k2_item').eq(index).animate({opacity: "1"},500);
						index++;
					}, 50);
					setTimeout(function(){ 
					var length = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_read').length;
					for(var i = 0; i < length; i++){
						var widthI = $('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .k2_highlight_items_info_read').eq(i).width();
						
					}		
					}, 500);
				},
					dataType: 'json'
			});	
		})
		
		

		var id=$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj_focus').attr('data-id');
		var title=$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj_focus').attr('data-title');
		var content=$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj_focus').attr('data-content');
		$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-tabs .sj-highlight-items-content-tabs-title').html(title);
		$('#sj-highlight-items-for-k2-id-<?php echo $module->id;?> .sj-highlight-items-content-tabs .sj-highlight-items-content-tabs-content').html(content);
		<?php } ?>
	});
//]]>	
</script>
	
<?php }else{ echo JText::_('Has no item to show!');}?>



