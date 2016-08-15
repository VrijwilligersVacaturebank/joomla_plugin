<?php
/**
 * Joomla! 1.5 component Vrijwilligersvacaturebank_nl
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author vrijwilligersvacaturebank
 * @package Joomla
 * @subpackage Vrijwilligersvacaturebank_nl
 * @license GNU/GPL
 *
 *
 */

defined('_JEXEC') or die('Restricted access');

$row = $this->row;
if(JV == 'j2') {
    //j2 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
?>

        <script type="text/javascript">
        <?php if(version_compare( JVERSION, '1.6.0', 'lt' )) { ?>
        function submitbutton(task) {
        <?php } else { ?>
        Joomla.submitbutton = function(task) {
        <?php } ?>
            var form = document.adminForm;
            if (task == 'cancel') {
                submitform( task );
            }
            else if (form.key.value == "") {
                form.key.style.border = "1px solid red";
                form.key.focus();
                 alert( "<?php echo JText::_('COM_EPAGEO_NEEDKEY', true ); ?>" );
            }
            else if(form.secert.value == "") {
                alert( "<?php echo JText::_('COM_EPAGEO_NEEDSECERT', true ); ?>" );
            }
			else if(form.route.value == "") {
                alert( "<?php echo JText::_('COM_EPAGEO_NEEDROUTE', true ); ?>" );
            }
            else {
                submitform( task );
            }
        }
        </script>
        <form action="index.php" method="post" name="adminForm" id="adminForm">

        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_EPAGEO_DETAILS'); ?></legend>

            <table class="admintable">
            <tr>
                <td width="200" class="key">
                    <label for="title">
                        <?php echo JText::_( 'COM_EPAGEO_CONSUMER_KEY' ); ?>:
                    </label>
                </td>
                <td>
                    <input class="inputbox" type="text" name="key" id="key" size="60" value="<?php echo @$row->key; ?>" />
                </td>
            </tr>
			<tr>
                <td class="key">
                    <label for="secert">
                      <?php echo JText::_( 'COM_EPAGEO_CONSUMER_SECERT' ); ?>:
                    </label>
                </td>
                <td>
                    <p><input class="inputbox" type="text" name="secert" id="secert" value="<?php echo @$row->secert; ?>" /></p>
                </td>
            </tr>
            <tr>
                <td width="200" class="key">
                    <label for="route">
                        <?php echo JText::_( 'COM_EPAGEO_ROUTE' ); ?>:
                    </label>
                </td>
                <td>
                    <input class="inputbox" type="text" name="route" id="route" size="60" value="<?php echo @$row->route; ?>" />
                </td>
            </tr>
            
            </table>
        </fieldset>

        <div class="clr"></div>
        <input type="hidden" name="task" value="save" />
        <input type="hidden" name="option" value="com_vrijwilligersvacaturebank_nl" />
        <input type="hidden" name="controller" value="application" />
        <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
        <input type="hidden" name="textfieldcheck" value="<?php echo @$n; ?>" />
        </form>

<?php
}
else {
    //j3 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
    JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
    JHtml::_('bootstrap.tooltip');
?>
        <script type="text/javascript">
        <?php if(version_compare( JVERSION, '1.6.0', 'lt' )) { ?>
        function submitbutton(task) {
        <?php } else { ?>
        Joomla.submitbutton = function(task) {
        <?php } ?>
            var form = document.adminForm;
            if (task == 'cancel') {
                submitform( task );
            }
            else if (form.key.value == "") {
                form.key.style.border = "1px solid red";
                form.key.focus();
                 alert( "<?php echo JText::_('COM_EPAGEO_NEEDKEY', true ); ?>" );
            }
            else if(form.secert.value == "") {
                alert( "<?php echo JText::_('COM_EPAGEO_NEEDSECERT', true ); ?>" );
            }
			else if(form.route.value == "") {
                alert( "<?php echo JText::_('COM_EPAGEO_NEEDROUTE', true ); ?>" );
            }
            else {
                submitform( task );
            }
        }
        </script>
        <form action="index.php" method="post" name="adminForm" id="adminForm">

        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_EPAGEO_DETAILS'); ?></legend>

            <table class="admintable">
            <tr>
                <td width="200" class="key">
                    <label for="title">
                        <?php echo JText::_( 'COM_EPAGEO_CONSUMER_KEY' ); ?>:
                    </label>
                </td>
                <td>
                    <input class="inputbox" type="text" name="key" id="key" size="60" value="<?php echo @$row->key; ?>" />
                </td>
            </tr>
			<tr>
                <td class="key">
                    <label for="custom_script">
                      <?php echo JText::_( 'COM_EPAGEO_CONSUMER_SECERT' ); ?>:
                    </label>
                </td>
                <td>
                    <p><input class="inputbox" type="text" name="secert" id="secert" value="<?php echo @$row->secert; ?>" /></p>
                </td>
            </tr>
            <tr>
                <td width="200" class="key">
                    <label for="alias">
                        <?php echo JText::_( 'COM_EPAGEO_ROUTE' ); ?>:
                    </label>
                </td>
                <td>
                    <input class="inputbox" type="text" name="route" id="route" size="60" value="<?php echo @$row->route; ?>" />
                </td>
            </tr>
            
            </table>
        </fieldset>

        <div class="clr"></div>

        <input type="hidden" name="task" value="save" />
        <input type="hidden" name="option" value="com_vrijwilligersvacaturebank_nl" />
        <input type="hidden" name="controller" value="application" />
        <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
        <input type="hidden" name="textfieldcheck" value="<?php echo @$n; ?>" />
        </form>

<?php }?>