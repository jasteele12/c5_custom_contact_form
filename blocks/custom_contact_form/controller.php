<?php defined('C5_EXECUTE') or die(_("Access Denied."));

class CustomContactFormBlockController extends BlockController {
/*    ^^^^^^^^^^^^^^^^^
      Change this portion
      of the class name to
      correspond with the
      block's directory name
*/

	protected $btDescription = "Custom Contact Form";
	protected $btName = "Custom Contact Form";
	protected $btTable = 'btCustomContactForm'; //Change db.xml table name to match this
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "450";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = true;
	protected $btCacheBlockOutputLifetime = 300;
	
	public function view() {
		$this->set('showThanks', $this->get('thanks'));
		
		//Send empty data object so fields prepopulate with empty data
		$data = new StdClass;
		$data->name = '';
		$data->email = '';
		$data->message = '';
		$this->set('data', $data);		
	}
		
	/*** FRONT-END PROCESSING ***/
	public function action_submit_form() {
		//Populate data object
		$data = new StdClass;
		$data->name = $this->post('name');
		$data->email = $this->post('email');
		$data->message = $this->post('message');

		//Validate
		$error = $this->validate_form($data);
		
		if ($error->has()) {
			//Fail -- re-display the form with user's prior data entry
			$this->set('errors', $error->getList());
			$this->set('data', $data);
		} else {
			//Success -- send notification email and reload/redirect page to avoid browser warnings about re-posting content if user reloads page 
			$this->send_notification_email($data);
			$this->success_redirect();
		}
	}
	
	public function validate_form($data) { //Note: this function can't just be called "validate" because then C5 automatically calls it to validate the add/edit dialog!
		$error = Loader::helper('validation/error');
		
		if (!$data->name) {
			$error->add('You must enter your name.');
		}
		
		if (!$data->email) {
			$error->add('You must enter your email address.');
		} else if (!$this->validateEmailFormat($data->email)) {
			$error->add('Email address is not in a valid format -- please check that you entered it correctly.');
		}
		
		$iph = Loader::helper('validation/ip');
		if (!$iph->check()) {
			$error->add($iph->getErrorMessage());
		}
		
		//Note that we don't have to validate CSRF tokens ourselves
		// because C5 handles it for us via the $this->action() function.
				
		return $error;
	}
	
	private function validateEmailFormat($email) {
		$regex = "/^\S+@\S+\.\S+$/"; //see: http://stackoverflow.com/questions/201323/what-is-the-best-regular-expression-for-validating-email-addresses#201447
		return (bool)preg_match($regex, $email);
	}
	
	private function send_notification_email($data) {
		$subject = '['.SITE.'] New Contact Form Submission';
		$body = <<<EOB
A new submission has been made to the custom contact form:

Name: {$data->name}
Email: {$data->email}

Message:
{$data->message}

EOB;
//Dev Note: The "EOB;" above must be at the far-left of the page (no whitespace before it),
//          and cannot have anything after it (not even comments).
//			See http://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
		
		//Send email
		$mh = Loader::helper('mail');
		$mh->from(UserInfo::getByID(USER_SUPER_ID)->getUserEmail());
		$mh->to($this->notifyEmail);
		$mh->setSubject($subject);
		$mh->setBody($body); //Use $mh->setBodyHTML() if you want an HTML email instead of (or in addition to) plain-text
		$mh->sendMail(); 
	}

	private function success_redirect($redirect_to_path = '') {
		$redirect_to_page = empty($redirect_to_path) ? Page::getCurrentPage() : Page::getByPath($redirect_to_path);
		$redirect_to_url = Loader::helper('navigation')->getCollectionURL($redirect_to_page); //Location headers should be absolute URL's (see http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.30)
		$redirect_to_url .= (strstr($redirect_to_url, '?') ? '&' : '?') . 'thanks=1';
		header("Location: " . $redirect_to_url);
		die;
	}
}
