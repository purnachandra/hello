<?php

Yii::import('application.models.UserGroupsUser');
Yii::import('application.models.UserGroupsGroup');
Yii::import('application.validators.passwordStrength');
Yii::import('application.components.UserGroupsIdentity');

class getLogIn extends CAction{
      
      public $fbProfile = null;
      public $model;
      public $login_model;
      const REGISTRATION = 1;
      const LOGIN = 2;
      
      protected function init(){
	    
	    $this->login_model = new LoginForm;  //UserGroupsUser('login');
            if(empty($this->model)) $this->model = new UserGroupsUser('registration');
            if( empty($this->model->facebook )){
                         
                $this->fbProfile = Yii::app()->facebook->getUser();  //print_r($this->fbProfile);Yii::app()->end();
                if ($this->fbProfile) {
                  try {
            // Proceed knowing you have a logged in user who's authenticated.
                       $this->fbProfile = Yii::app()->facebook->api('/me');
                     } catch (FacebookApiException $e) {
               //throw $e;
                 $this->fbProfile = null;
                   }
                }
                $this->model->facebook = $this->fbProfile["id"] ? $this->fbProfile["id"]: null;
                $this->model->email = $this->fbProfile["email"] ? $this->fbProfile["email"]: null;
                $this->model->firstname = $this->fbProfile["first_name"] ? $this->fbProfile["first_name"]: null;
                $this->model->lastname = $this->fbProfile["last_name"] ? $this->fbProfile["last_name"]: null;
                $this->model->displayname = $this->fbProfile["username"] ? $this->fbProfile["username"]: null;
                $this->model->birthdate = $this->fbProfile["birthYear"] 
                                ? sprintf("%04d-%02d-%02d", $this->fbProfile["birthYear"], $this->fbProfile["birthMonth"], $this->fbProfile["birthDay"])
                                           : null;
                $gender = array('female'=>'f','male'=>'m');
                $this->model->username = $this->fbProfile["displayName"] ? $this->fbProfile["displayName"]: null;
               // $this->model->password = $this->fbProfile["identifier"] ? $this->fbProfile["identifier"]: null;
                $this->model->gender = $gender[$this->fbProfile["gender"]];
                $this->model->group_id = 2;
                $this->model->status = 5;  //UserGroupsUser::FACEBOOK;
            }
	    
	    
      }
      
      public function run() {
          $this->controller->layout = 'dashboard.views.layouts.column1';
          // $this->controller->layout = 'application.views.layouts.adview';
       //  echo 'type is: '.$_GET['type'];
         switch((int)$_GET['type']){  
	    
	  case 2:
                 $lfmodel=new LoginForm;
	         $model = new UserGroupsUser('login');
	         if (Yii::app()->request->isAjaxRequest){ 
	              if (isset($_POST['LoginForm'])) {  
		             $model->username = $_POST['LoginForm']['username'];
		             $model->password = $_POST['LoginForm']['password'];
                               //  $model->attributes = $_POST['UserGroupsUser'];
		             if ($model->validate() && $model->login()){
		                   $array = array('login' => 'success');
                                   Yii::app()->user->setFlash('success', 'Successfully logged in.');
                                   $json = json_encode($array);
                                   echo $json; 
			              //    $this->getController()->redirect(array('/userGroups'));
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
	                 //  $this->controller->layout = 'fancy_box_layout';
	            }
             
             $this->getController()->render('dashboard.components.widgets.views.login',array('login_model'=>$lfmodel,'fbUser'=>$this->fbProfile,)); 
             break;
            
          case 1:  //echo $_GET['type'];
                 if(isset($_GET['fbUser']))  $fbUser = $_GET['fbUser'];
	         $model = new UserGroupsUser('registration');
	      //   if (Yii::app()->request->isAjaxRequest){
	              if (isset($_POST['UserGroupsUser'])) {  
		             $model->attributes = $_POST['UserGroupsUser'];
		            
                               if ($model->validate()){
		             if ( $model->save() ){
          
		                   $array = array('signup' => 'success');
                                   Yii::app()->user->setFlash('signup', 'Registration Succefully completed. You can now login.');
                                   $json = json_encode($array);
                                   echo $json; 
			              //    $this->getController()->redirect(array('/userGroups'));
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
			         //  echo CActiveForm::validate($model);
                                   Yii::app()->end();
		               }
	                
                      }
             else
             $this->getController()->render('dashboard.components.widgets.views.register',array('model'=>$model,'fbUser'=>$this->fbProfile)); 
             break;
            
        } //switch
       
}
  public function getModule(){
     
    }
    
}
?>