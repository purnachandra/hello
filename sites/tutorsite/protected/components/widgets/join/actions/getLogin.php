<?php
Yii::import('application.models.UserGroupsUser');
Yii::import('application.components.UserGroupsIdentity');
class getLogIn extends CAction{
      
     
      public $model;
      public $login_model;
      const REGISTRATION = 1;
      const LOGIN = 2;
      
      protected function init(){
	    $this->login_model = new LoginForm;
            if(empty($this->model)) $this->model = new UserGroupsUser('registration');
           
	    
      }
      
      public function run() {
	     $assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias('application.components.widgets.join' ) . '/assets' );
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile( $assets . '/join.js',  CClientScript::POS_END );
	 
         switch((int)$_GET['type']){  
	    
	  case 2:
                 $lfmodel=new LoginForm;
	         $model = new UserGroupsUser('login');
	         if (Yii::app()->request->isAjaxRequest){ 
	              if (isset($_POST['LoginForm'])) {  
		             $model->username = $_POST['LoginForm']['username'];
		             $model->password = $_POST['LoginForm']['password'];
                             
		             if ($model->validate() && $model->login()){
		                   $array = array('login' => 'success');
                                   Yii::app()->user->setFlash('success', 'Successfully logged in.');
                                   $json = json_encode($array);
                                   echo $json; 
			          
                                   Yii::app()->end();
		              }
		              else{
			           echo CActiveForm::validate($model);
                                   Yii::app()->end();
		               }
	                 }
                    }//ajax req 
	            else{   
	                   $this->init();
	               
	            }
             
             $this->getController()->render('application.components.widgets.join.views.login',array('login_model'=>$lfmodel)); 
             break;
            
          case 1: 
                
	         $model = new UserGroupsUser('registration');
	     
	              if (isset($_POST['UserGroupsUser'])) {  
		             $model->attributes = $_POST['UserGroupsUser'];
			     
		             if($model->group_name === "Tutor") $model->group_id = 4;
			     else if($model->group_name === "Student") $model->group_id = 3;
			     
                             if ($model->validate()){
		             if ( $model->save() ){
          
		                   $array = array('signup' => 'success');
                                   Yii::app()->user->setFlash('signup', 'Registration Succefully completed. You can now login.');
                                   $json = json_encode($array);
                                   echo $json; 
			          
                                   Yii::app()->end();
		              }
                               }
		              else{
                                     $ary = $model->getErrors();
                                     $lst = array();
                                     foreach( array_keys($ary) as $k ){
                                        $v = $ary[$k];
                                        $lst = array_merge( $lst,  array_values($v) );
                                          }
                                   echo json_encode($lst);
			       
                                   Yii::app()->end();
		               }
	                
                      }
             else
             $this->getController()->render('application.components.widgets.join.views.register',array('model'=>$model)); 
             break;
            
        } //switch
       
}
  public function getModule(){
     
    }
    
}
?>