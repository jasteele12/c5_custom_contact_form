<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$fh = Loader::helper('form');
?>

<div class="custom_contact_form">
	
	<?php if ($showThanks): ?>
	<div class="success">
		<?php echo nl2br($thanksMsg); ?>
	</div>
	<?php endif; ?>
	
	<?php if (!empty($errors)): ?>
	<div class="errors">
		Please Correct the following errors:
		<ul>
			<?php foreach ($errors as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<form method="post" action="<?php echo $this->action('submit_form'); ?>">

	<?php /* NOTE: If you add a file upload field to your form, you need to change the above <form> tag to:
	<form method="post" action="<?php echo $this->action('submit_form'); ?>" enctype="multipart/form-data">
	(notice that it adds the entype="multipart/form-data" attribute -- form uploads don't work without this) */ ?>

		<?php echo $fh->label('name', 'Name:'); ?>
		<?php echo $fh->text('name', $data->name); ?>

		<br />

		<?php echo $fh->label('email', 'Email:'); ?>
		<?php echo $fh->text('email', $data->email); ?>
		
		<br />
		
		<?php echo $fh->checkbox('optIn', 1, $data->optIn); ?>
		<?php echo $fh->label('optIn', 'Sign me up for your newsletter'); ?>
		
		<br />

		<?php echo $fh->label('message', 'Message:'); ?>
		<?php echo $fh->textarea('message', $data->message); ?>

	  	<br />
	
		<input type="submit" class="submit" value="Send" />

	</form>

</div>
