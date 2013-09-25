<?php
Yii::import('application.vendors.yii-mail.YiiMailMessage');

class getContact extends CAction{
      protected $controller; 
      public $modelName ;
      public $step;
      
      public $returnUrl ;
      
      public function run() {
	 // $this->controller->layout = 'application.views.layouts.fancy_box_layout';
              $contact_model=new ContactForm;
              if(isset($_POST['ContactForm'])){
             		$contact_model->attributes=$_POST['ContactForm'];
			if($contact_model->validate()){
                           $message = new YiiMailMessage;
                           $message->view = 'ad_contact';
                           $message->subject = $contact_model->subject;
                           $message->setBody(array('model'=>$contact_model), 'text/html');
                           $message->addTo(Yii::app()->params['supportEmail']);
                           $message->from = $contact_model->email;
                          Yii::app()->mail->send($message);
			   Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                                /*$headers="From: {contact_model->email}\r\nReply-To: {contact_model->email}";
				mail(Yii::app()->params['adminEmail'],$contact_model->subject,$contact_model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();*/
				//$this->refresh();
                           $array = array('contact' => 'success');
                           $json = json_encode($array);
                           echo $json;
                           Yii::app()->end();
                                
		        }
                        else {
                                echo CActiveForm::validate($contact_model);
                                Yii::app()->end();
                             }
                 }
		 //  else
            // $this->getController()->render('application.components.widgets.views.register',array('model'=>$model,'fbUser'=>$this->fbProfile)); 
           //   $this->getController()->render('application.components.widgets.views.contact.contact',array('contact_model'=>$contact_model));
     }
  public function getModule(){
        
        
        
    }
}
?>