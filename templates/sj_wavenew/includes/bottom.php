<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$app 	= JFactory::getApplication();
$layout = $app->input->get('layout');
/****************************
*  Google Font & Body Font
****************************/

/**
 * Add Google font
 * @param     string              $font       name font
 * @param     string              $selectors  name selectors
 * @return    string              url google fonts   
 */
function ytfont($font, $selectors){
	$doc = JFactory::getDocument();
	$font = trim($font);
	$font_boolean = strrpos($font, "'");
	
	if($font !='0'){
		if ($font_boolean ) {
			$doc->addStyleDeclaration($selectors.'{font-family:'.$font.'}');
		}else{
			$doc->addStyleSheet('http://fonts.googleapis.com/css?family='.$font.'&amp;subset=latin,latin-ext');
			$font = str_replace("+"," ",(explode(':',$font)));
			if(trim($selectors)!=""){
				$doc->addStyleDeclaration($selectors.'{font-family:'.$font[0].'}');
			}
		}
	}
}
ytfont($bodyFont,$bodySelectors);
ytfont($menuFont,$menuSelectors);
ytfont($headingFont,$headingSelectors);
ytfont($otherFont,$otherSelectors);
?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		
		typelayout = '<?php echo $yt->getParam('typelayout') ?>';
		switch(typelayout) {
			case "wide":
				bodybgimage = '<?php echo $yt->getParam('bgbox') ?>';
			case "boxed":
				bodybgimage = '<?php echo $yt->getParam('bgbox') ?>';
				break;
			case "framed":
				 bodybgimage = '<?php echo $yt->getParam('bgframed') ?>';
				break;
			case "rounded":
				bodybgimage = '<?php echo $yt->getParam('bgrounded') ?>';
				break;
			
		}
		
		
	});
</script>


<?php
// Setting Cpanel
if($showCpanel) {
	include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'cpanel.php');
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		miniColorsCPanel('.link-color .color-picker','background-color',
		'.navi li.level1.active, .navi li.level1.hover ' );
		
		patternClick('.body-bg .pattern', 'bgimage', Array('#bd'));
		
		var array 				= Array('bgimage');
		var array_blue          = Array('pattern8');
		var array_red 	        = Array('pattern8');
		var array_green 	    = Array('pattern8');
		var array_oranges 	    = Array('pattern8');
		var array_pink	    = Array('pattern8');
		
		
		//1.Color Blue
		$('.theme-color.blue').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'themecolor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_blue);
			onCPApply();
		});
		
		//2.Color Red
		$('.theme-color.red').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'themecolor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_red);
			onCPApply();
		});
		
		//3.Color Green
		$('.theme-color.green').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'themecolor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_green);
			onCPApply();
		});
		
		//4.Color Oranges
		$('.theme-color.oranges').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'themecolor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_oranges);
			onCPApply();
		});
		
		//5.Color Pink
		$('.theme-color.pink').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'themecolor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_pink);
			onCPApply();
		});
		
		
		/* miniColorsCPanel */
		function miniColorsCPanel(elC, selector,elT){
			$(elC).miniColors({
				change: function(hex, rgb) {
					if(typeof(elT)!='string'){
						for(i=0;i<elT.length;i++){
							$(elT[i]).css(selector, hex);
						}
					}else{
						$(elT).css(selector, hex); 
					}
					createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
				}
			});
		}
		
		/* Begin: Set click pattern */
		function patternClick(elC, paramCookie, elT){
			$(elC).click(function(){
				oldvalue = $(this).parent().find('.active').html();
				$(elC).removeClass('active');
				$(this).addClass('active');
				value = $(this).html();
				if(elT.length > 0){
					for($i=0; $i < elT.length; $i++){
						$(elT[$i]).removeClass(oldvalue);
						$(elT[$i]).addClass(value);
					}
				}
				if(paramCookie){
					$('input[name$="ytcpanel_'+paramCookie+'"]').attr('value', value);
					createCookie(TMPL_NAME+'_'+paramCookie, value, 365);
				}
			});
		}
		function setCpanelValues(array){
			// Remove the # from the hash, as different browsers may or may not include it
			// append /remove anchor name from current url without refresh
			if(array['0']){
				$('.body-backgroud-image .pattern').removeClass('active');
				$('.body-backgroud-image .pattern.'+array['0']).addClass('active');
				$('input[name$="ytcpanel_bgimage"]').attr('value', array['0']);
			}
			
			
		}
	});
	</script>
<?php } ?>
	
<?php

if( $layout== 'edit')  {
//Mootools-more.js conflicting with Bootstrap Carousel
$doc->addCustomTag('
<script type="text/javascript">
	window.addEvent("domready", function(){if (typeof jQuery != "undefined" && typeof MooTools != "undefined" ) {Element.implement({hide: function(how, mode){return this;}});}});
</script>
');
}

// Show Back To Top
if( $yt->getParam('showBacktotop'))  { ?>
	<a id="yt-totop" class="backtotop" href="#"><i class="fa fa-angle-up"></i> Top </a>
    <script type="text/javascript">
		jQuery('.backtotop').click(function () {
			jQuery('body,html').animate({
					scrollTop:0
				}, 1200);
			return false;
		});
		
    </script>
<?php } ?>

<?php // Slide Menu Mobile?>
<script type="text/javascript">
 var slideout = new Slideout({
  'panel': document.getElementById('yt_wrapper'),
  'menu': document.getElementById('menu') ,
 });

 window.onload = function(event) {
	var bd = jQuery('<div class="modal-backdrop fade in"></div>'); 
	jQuery('body').on('touchstart click','.modal-backdrop', function(e){
		e.stopPropagation(); e.preventDefault();
		jQuery(this).closest('.modal-backdrop').remove();
		slideout.close();
	});
	
	jQuery('.js-slideout-toggle').on('click', function() {
		slideout.toggle();
		bd.appendTo(document.body);
	});
 };

</script>

<script type="text/javascript">
 jQuery(document).ready(function($){
  typelayout = '<?php echo $yt->getParam('typelayout') ?>';
  switch(typelayout) {
   case "wide":
    bodybgimage = '<?php echo $yt->getParam('bgbox') ?>';
   case "boxed":
    bodybgimage = '<?php echo $yt->getParam('bgbox') ?>';
    break;
   case "framed":
     bodybgimage = '<?php echo $yt->getParam('bgframed') ?>';
    break;
   case "rounded":
    bodybgimage = '<?php echo $yt->getParam('bgrounded') ?>';
    break;
   
  }
  
  if(bodybgimage) $('#bd').addClass(bodybgimage);
 });
</script>


