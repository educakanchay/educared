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

<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($) {
		;(function(element){
			var $element = $(element);
			var $megaii_wrap = $('.megaii-wrap',$element);
			//$element.tabsmart();
			$megaii_wrap.each(function(){
				$('.megaii-button', $(this)).click(function(){
				   var $container = $(this).parent().parent();
					if($container.hasClass('megaii-close')){
						jaccordion_close($container);
					} else {
						jaccordion_expand($container);
					}	
				});
				
				function jaccordion_expand($el){
					var $content_inner = $('.megaii-content', $el);
					$content_inner.filter(':animated').stop();
					$height_to_fit = 0;
					$content_inner.children().each(function(){	
						if ($(this).height()>0){
							$height_to_fit += $(this).height();				
						}
					});
					$el.addClass('megaii-close').removeClass('megaii-open');
					$content_inner.animate({
						height: $height_to_fit			
					}, {
						duration: 400,
						complete: function(){
							$content_inner.css('height','auto');
						}
					});
				}
				
				function jaccordion_close($el){
					var $content_inner = $('.megaii-content', $el);
					$content_inner.filter(':animated').stop();
					$el.addClass('megaii-open').removeClass('megaii-close');
					$content_inner.css('height','auto').animate({
						height: 0
					}, {
						duration: 400
					});			
				}
				
				var $tabs = $('.megaii-tab ',$(this)), $content_wrap = $('.megaii-content-catwrap',$(this));
				$tabs.each(function(){
					var $this = $(this);
					$(this).parent().parent().parent().parent().tabsmart();
					$this.click(function(){
						if($(this).hasClass('tab-selected')){
							return;
						}else{
							if($tabs.parent().parent().parent().parent().hasClass('megaii-open')){
								jaccordion_expand($tabs.parent().parent().parent().parent());
							}
							if($tabs.parent().parent().parent().parent().parent().hasClass('megaii-open')){
								jaccordion_expand($tabs.parent().parent().parent().parent().parent());
							}
							$tabs.removeClass('tab-selected ');
							$(this).addClass('tab-selected');
							//$(this).parent().parent().parent().parent().tabsmart();
							//slidingPage($(this).parent(), _resize= false);
							var $catid = $(this).filter('.tab-selected').attr('data-catid');
							$content_wrap.removeClass(' content-selected');
							$('.category-'+$catid).addClass(' content-selected');
						}
						return;
					});
				});
			});
			
				
			
			function slidingPage(el,_resize){
				// if(el.hasClass('cf-control') === false){
					// return ;
				// }
				var	$page = $('li.megaii-tab',el);
				var $page_active 	= $page.filter('.tab-selected');
				var $page_holder 	= $page.parent();
				var index 			= $page_active.index(); 
				var toleft 			= - $page_active.position().left;
				var $page_container = $page_holder.parent();
				var $page_width     = $page.width() * $page.length;
				var viewport 		= {};
					viewport.left 	= 0;
					viewport.right 	= $page_container.width();
				
				var visible 		= {};
					visible.left	= viewport.left - parseInt($page_holder.position().left);
					visible.right	= viewport.right - parseInt($page_holder.position().left);
				var posUpdate 		= function(){
					visible.left	= viewport.left - 	parseInt($page_holder.position().left);
					visible.right	= viewport.right -  parseInt($page_holder.position().left);
				};
				
				var slidingWhenReisize = function(toleft, d){
					if(!d){
						d = 500;
					}
					if (toleft <= $page_container.width() - $page_width) {
						toleft = $page_container.width() - $page_width  ;
					}
					if(toleft > 0){
						toleft = 0;
					}
					$page_holder.stop(true,true).animate({
							left: toleft
						},{
						duration: d,
						complete: posUpdate,
						queue: false
					});
				}
				
				if(_resize == true){
					slidingWhenReisize(toleft);
				}
				
				var slidingto = function(index, d){
					if(!d){
						d = 500;
					}
					if(index >=0 ){
						if(index == 0){
							index = 1;
						}
						var prevLeft = $page.eq(index-1).position().left;
						if(prevLeft <= visible.left){
							$page_holder.stop(true,true).animate({
									left: '+='+(visible.left - prevLeft)+'px'
								},{
								duration: d,
								complete: posUpdate,
								queue: false
							});
						}
					}
					if(index <  $page.length){
						if(index == $page.length - 1){
							index = $page.length - 2;
						}
						var nextRight = $page.eq(index + 1).position().left + $page.eq(index + 1).width();
						if(nextRight >= visible.right){
							$page_holder.stop(true,true).animate({
									left: '-='+(nextRight - visible.right)+'px'
								},{
								duration: d,
								complete: posUpdate,
								queue: false
							});
						}
					}
					
				}
				slidingto(index );	
			}
			
				
		})('#<?php echo $tag_id; ?>');
	});
//]]>
</script>

