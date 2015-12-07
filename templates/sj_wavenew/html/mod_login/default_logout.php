<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="logout-form" class="yt-loginform">
	<div class="yt-login">
		<button type="submit" name="Submit" class="login-switch">
			<i class="fa fa-sign-out nomargin"></i>
			<?php if ($params->get('greeting')) : ?>
				<?php if ($params->get('name') == 0) : {
					echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name')));
				} else : {
					echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
				} endif; ?>
			<?php endif; ?>
		</button>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
