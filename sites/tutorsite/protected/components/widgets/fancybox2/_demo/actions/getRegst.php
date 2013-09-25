<?php
Yii::import('userGroups.models.UserGroupsUser');
class getRegst extends CAction{
      protected $controller; 
      public $modelName ;
      public $step;
      private $duration = 2592000;
      public $returnUrl ;
      public function run() { 
          
          
          $regst_form_model=new UserGroupsUser('registration');
	  
           if (isset($_POST['UserGroupsUser'])) {
	  $session = Yii::app()->session;
                $prefixLen = strlen(CCaptchaAction::SESSION_VAR_PREFIX);
                foreach($session->keys as $key)
                {         
                        if(strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
                            
                     
                                $session->remove($key);
               
           }
        $regst_form_model->attributes = $_POST['UserGroupsUser'];
       
        if ($regst_form_model->validate() ) {
	   // $regist_form_model->scenario = 'verification';
	    
	           if( $regst_form_model->save()){   
	                  Yii::app()->user->setFlash('signup','Registration Successful.');
	                  //$regst_form_model->scenario = NULL;
	                  $array = array("signup"=>"success");
                          $json = json_encode($array);
                        
		          echo 'Im here';
			//  echo $json;
                          Yii::app()->end();
	            }
	     
	     
        } else {
            echo CActiveForm::validate($regst_form_model);
            Yii::app()->end();
        }
    }
     
     }
  public function getModule(){
        
        
        
    }
   
        
}
?>