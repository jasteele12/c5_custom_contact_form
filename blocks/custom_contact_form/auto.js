ccmValidateBlockForm = function() {
	
	if ($('#thanksMsg').val() == '') {
		ccm_addError('You must enter a Thank-You Message');
	}
	
	if ($('#notifyEmail').val() == '') {
		ccm_addError('You must enter at least one Notification Email Address');
	}
	
	return false;
}
