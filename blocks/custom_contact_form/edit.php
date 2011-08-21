<?php 
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="ccm-block-field-group">
	<h2>Thank You Message</h2>
	<textarea id="thanksMsg" name="thanksMsg" rows="5" style="width: 95%;"><?php echo $thanksMsg; ?></textarea>
</div>

<div class="ccm-block-field-group">
	<h2>Send Notification Emails To</h2>
	<input type="text" id="notifyEmail" name="notifyEmail" style="width: 95%;" value="<?php echo $notifyEmail; ?>" />
	<i>Separate multiple email addresses with commas</i>
</div>
