<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Commentlogin Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');
ob_clean();
if (JRequest::getvar('mode', '', 'get', 'string'))
   {
?>
    <script type="text/javascript">
        window.onload=function()
        {
            window.opener.location.reload();
            window.close();
        }
    </script>
<?php exit;
    } ?>
<div class="componentheading">
    Login</div>
<form action="<?php echo JURI::base(); ?>index.php?option=com_user" method="post" name="com-login" id="com-form-login">
    <table class="contentpane" width="100%" align="center" border="0" cellpadding="4" cellspacing="0">
        <tbody><tr>
                <td colspan="2">
                </td>
            </tr>
        </tbody></table>
    <fieldset class="input">
        <p id="com-form-login-username">
            <label for="username">Username</label><br>
            <input name="username" id="username" class="inputbox" alt="username" size="18" type="text">
        </p>
        <p id="com-form-login-password">
            <label for="passwd">Password</label><br>
            <input id="passwd" name="passwd" class="inputbox" size="18" alt="password" type="password">
        </p>
        <input name="Submit" class="button" value="Login" type="submit">
    </fieldset>
    <input name="option" value="com_user" type="hidden">
    <input name="task" value="login" type="hidden">
 <?php echo JHTML::_('form.token'); ?>
</form>
<?php
exit;
?>