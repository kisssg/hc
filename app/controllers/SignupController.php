<?php
class SignupController extends ControllerBase {
	protected function initialize(){
		$this->tag->setTitle("SignUp/In");
		parent::initialize();		
	}
	public function indexAction() {
	}
	public function registerAction() {
		$user = new Users ();
		
		// Store and check for errors
		$success = $user->save ( $this->request->getPost (), [ 
				"username",
				"email", 
		] );
		
		if($success){
			echo '{"result":"success"}';
			
		}else{
			echo '{"result":"Sorry, the following problems were generated:';
			
			$messages=$user->getMessages();
			
			foreach ($messages as $message){
				echo $message->getMessage(),"<br/>";
			}
			echo '"}';
		}
		$this -> view->disable();
		
	}
}