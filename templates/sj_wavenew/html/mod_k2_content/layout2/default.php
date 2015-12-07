<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
// includes placehold
$yt_temp = JFactory::getApplication()->getTemplate();
include (JPATH_BASE . '/templates/'.$yt_temp.'/includes/placehold.php');

?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
  <ul class="items">
    <?php foreach ($items as $key=>$item):	?>
    <li class="item <?php if(count($items)==$key+1) echo ' lastItem'; ?>" data-sr="enter top and scale up 100% over 1s">

      <!-- Plugins: BeforeDisplay -->
      <?php echo $item->event->BeforeDisplay; ?>

      <!-- K2 Plugins: K2BeforeDisplay -->
      <?php echo $item->event->K2BeforeDisplay; ?>

      <?php if($params->get('itemAuthorAvatar')): ?>
	<a class="k2Avatar moduleItemAuthorAvatar" rel="author" href="<?php echo $item->authorLink; ?>">
		<img src="<?php echo $item->authorAvatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" style="width:<?php echo $avatarWidth; ?>px;height:auto;" />
	</a>
      <?php endif; ?>

	
	
     

      <!-- Plugins: AfterDisplayTitle -->
      <?php echo $item->event->AfterDisplayTitle; ?>

      <!-- K2 Plugins: K2AfterDisplayTitle -->
      <?php echo $item->event->K2AfterDisplayTitle; ?>

      <!-- Plugins: BeforeDisplayContent -->
      <?php echo $item->event->BeforeDisplayContent; ?>

      <!-- K2 Plugins: K2BeforeDisplayContent -->
      <?php echo $item->event->K2BeforeDisplayContent; ?>

      <?php if($params->get('itemImage') || $params->get('itemIntroText')): ?>
      <div class="moduleItemIntrotext">
	      <?php if($params->get('itemImage')): ?>
	      <div class="moduleItemImage">
			<a  href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
				  <?php 	
				     //Create placeholder items images
				     if(isset($item->image)){
				     $src =$item->image;  }
				     if (!empty( $src)) {								
					     $thumb_img = '<img src="'.$src.'" alt="'.$item->title.'" />'; 
				     } else if ($is_placehold) {					
					     $thumb_img = yt_placehold($placehold_size['k2_style_one'],$item->title,$item->title); 
					    //var_dump( $thumb_img);
				     }	
				     echo $thumb_img;
				  ?>
			</a>
			<a data-rel="prettyPhoto" href="<?php echo $src; ?>" title="<?php echo $item->title; ?>" class="icon-zoom">
				<i class="fa fa-plus"></i>
			</a>
	      </div>
	      <?php endif; ?>
	      <?php
			$string_color1=strstr($item->categoryname, "|" );
			$string_color2=str_replace("|", "#", $string_color1);
			$string_cate=str_replace($string_color1, "", $item->categoryname);
		?>
	      <?php if($params->get('itemCategory')): ?>
		<div class="catItemCategory"
			<?php if ($string_color2 !=""):?>
			style="background: <?php echo $string_color2; ?>"
			<?php endif ?>
			>
			<!-- Item category name -->
			<a href="<?php echo $item->categoryLink; ?>"><?php echo $string_cate; ?></a>
			<div class="arow-before"
			     <?php if ($string_color2 !=""):?>
			     style="border-color: transparent transparent transparent <?php echo $string_color2; ?>"
			     <?php endif ?>
			     ></div>
			<div class="arow-after"
			     <?php if ($string_color2 !=""):?>
			     style="border-color: transparent transparent transparent <?php echo $string_color2; ?>"
			     <?php endif ?>
			     ></div>
		</div>
		<?php endif; ?>
	      <div class="main">
		
		<?php if($params->get('itemTitle')): ?>
		<h3 class="moduleItemTitle"><a  href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
		<?php endif; ?>
		<aside class="article-aside">
			<dl class="article-info  muted">
				<dt></dt>
				<!-- Item Author -->
				<?php if($params->get('itemAuthor')): ?>
				<dd class="catItemAuthor">
				<?php echo K2HelperUtilities::writtenBy($item->authorGender); ?>
					<?php if(isset($item->authorLink)): ?>
					<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><i class="fa fa-user"></i><?php echo $item->author; ?></a>
					<?php else: ?>
					<i class="fa fa-user"></i><?php echo $item->author; ?>
					<?php endif; ?>
					
					<?php if($params->get('userDescription')): ?>
					<?php echo $item->authorDescription; ?>
					<?php endif; ?>
					
				</dd>
				<?php endif; ?>
				<!-- Date created -->
				<?php if($params->get('itemDateCreated')): ?>
				<dd class="create"><i class="fa fa-clock-o"></i><?php echo JHTML::_('date', $item->created , 'j M Y'); ?></dd>
				<?php endif; ?>
				<?php if($params->get('itemTags') && count($item->tags)>0): ?>
				<dd class="moduleItemTags">
				  <?php foreach ($item->tags as $tag): ?>
				  <a href="<?php echo $tag->link; ?>"><i class="fa fa-tags"></i><?php echo $tag->name; ?></a>
				  <?php endforeach; ?>
				</dd>
				<?php endif; ?>
				<?php if($params->get('itemHits')): ?>
				<!-- Item Hits -->
				<dd class="catItemHitsBlock">
					<span class="catItemHits">
					<i class="fa fa-eye"></i><?php echo $item->hits; ?> 
					</span>
				</dd>
				<?php endif; ?>
				<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>
				<dd class="CommentsLink">
					<!-- Anchor link to comments below -->
					<span class="catItemCommentsLink">
					<?php if(!empty($item->event->K2CommentsCounter)): ?>
						<!-- K2 Plugins: K2CommentsCounter -->
						<?php echo $item->event->K2CommentsCounter; ?>
					<?php else: ?>
						<?php if($item->numOfComments>0): ?>
						<a class="ItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
							<i class="fa fa-comments"></i><?php echo $item->numOfComments; ?> <?php if($item->numOfComments>1) echo JText::_('K2_COMMENTS'); else echo JText::_('K2_COMMENT'); ?>
						</a>
						<?php else: ?>
						<a class="ItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
							<i class="fa fa-comments"></i><?php echo JText::_('K2_THE_FIRST_TO_COMMENT'); ?>
						</a>
						<?php endif; ?>
					<?php endif; ?>
					</span>
				</dd>
				<?php endif; ?>
			</dl>
		</aside>
		<?php if($params->get('itemIntroText')): ?>
		<div class="introtext">
			<?php echo $item->introtext; ?>
		</div>
		<?php endif; ?>
		<?php if($params->get('itemReadMore') && $item->fulltext): ?>
		<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
			<?php echo JText::_('ME_K2_READ_MORE'); ?>
		</a>
		<?php endif; ?>
		</div><!-- end main-->

      	
      </div>
      <?php endif; ?>

      <?php if($params->get('itemExtraFields') && count($item->extra_fields)): ?>
      <div class="moduleItemExtraFields">
	      <b><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></b>
	      <ul>
	        <?php foreach ($item->extra_fields as $extraField): ?>
					<?php if($extraField->value != ''): ?>
					<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
						<?php if($extraField->type == 'header'): ?>
						<h4 class="moduleItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
						<?php else: ?>
						<span class="moduleItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
						<span class="moduleItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
						<?php endif; ?>
						<div class="clr"></div>
					</li>
					<?php endif; ?>
	        <?php endforeach; ?>
	      </ul>
      </div>
      <?php endif; ?>

      <div class="clr"></div>

      <?php if($params->get('itemVideo')): ?>
      <div class="moduleItemVideo">
      	<?php echo $item->video ; ?>
      	<span class="moduleItemVideoCaption"><?php echo $item->video_caption ; ?></span>
      	<span class="moduleItemVideoCredits"><?php echo $item->video_credits ; ?></span>
      </div>
      <?php endif; ?>

      <div class="clr"></div>

      <!-- Plugins: AfterDisplayContent -->
      <?php echo $item->event->AfterDisplayContent; ?>

      <!-- K2 Plugins: K2AfterDisplayContent -->
      <?php echo $item->event->K2AfterDisplayContent; ?>
      <?php if($params->get('itemAttachments') && count($item->attachments)): ?>
			<div class="moduleAttachments">
				<?php foreach ($item->attachments as $attachment): ?>
				<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
				<?php endforeach; ?>
			</div>
      <?php endif; ?>

	

      <!-- Plugins: AfterDisplay -->
      <?php echo $item->event->AfterDisplay; ?>

      <!-- K2 Plugins: K2AfterDisplay -->
      <?php echo $item->event->K2AfterDisplay; ?>

      <div class="clr"></div>
    </li>
    <?php endforeach; ?>
    <li class="clearList"></li>
  </ul>
  <?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
	<a class="moduleCustomLink" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

</div>
