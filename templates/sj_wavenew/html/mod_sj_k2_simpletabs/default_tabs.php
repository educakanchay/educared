<?php
/*
 * @package Sj K2 Simple Tabs
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
ob_start();

?>

<ul class="spt-tabs" >
<?php  foreach ($list as $key=>$items) {?>
	<?php
	$catename=K2SimpleTabsHelper::truncate($items[0]['name'], $params->get('category_title_max_characs',20));
	$string_color1=strstr($catename, "|" );
	$string_color2=str_replace("|", "#", $string_color1);
	$string_cate=str_replace($string_color1, "", $catename);
	?>
	<li class="spt-tab">
		<span class="spt-tab-inner category-id-<?php echo $key ?>">
			<?php echo $string_cate;?>
		</span>
	</li>			
<?php }  ?>
</ul>
<?php
$tabs_markup = ob_get_contents();
ob_end_clean();	
 ?>	