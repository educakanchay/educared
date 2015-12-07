<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

?>

<ul class="breadcrumb<?php echo $moduleclass_sfx; ?>">
	<?php
	if ($params->get('showHere', 1))
	{
		echo '<li class="active here">' . JText::_('MOD_BREADCRUMBS_HERE_ME') . '</li>';
	}
	else
	{
		echo '<li class="active"><span class=" fa fa-angle-right"></span></li>';

	}

	// Get rid of duplicated entries on trail including home page when using multilanguage
	for ($i = 0; $i < $count; $i++)
	{
		if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
		{
			unset($list[$i]);
		}
	}

	// Find last and penultimate items in breadcrumbs list
	end($list);
	$last_item_key = key($list);
	prev($list);
	$penult_item_key = key($list);

	// Make a link if not the last item in the breadcrumbs
	$show_last = $params->get('showLast', 1);

	// Generate the trail
	foreach ($list as $key => $item) :
	$string_color1=strstr($item->name, "|" );
	$string_color2=str_replace("|", "#", $string_color1);
	$string_cate=str_replace($string_color1, "", $item->name);
	if ($key != $last_item_key)
	{
		
		// Render all but last item - along with separator
		echo '<li>';
		if (!empty($item->link))
		{
			echo '<a href="' . $item->link . '" class="pathway">' . $string_cate . '</a>';
		}
		else
		{
			echo '<span>' . $string_cate . '</span>';
		}

		if (($key != $penult_item_key) || $show_last)
		{
			
			echo '<span class="divider fa fa-angle-right"></span>';
		}

		echo '</li>';
	}
	elseif ($show_last)
	{
		// Render last item if reqd.
		echo '<li class="active">';
		echo '<span>' . $string_cate . '</span>';
		echo '</li>';
	}
	endforeach; ?>
</ul>
