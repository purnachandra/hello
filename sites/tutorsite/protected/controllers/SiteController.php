<?php

// Yii::import('application.components.Controller');

class SiteController extends Controller{

     public $layout= 'main';
     public $locLink;
     public $locData; 

     public function filters(){
          return array(
                array('ext.seo.components.SeoFilter + view'), // apply the filter to the view-action
          );
     }

     public function behaviors(){
             return array(
                'seo'=>array('class'=>'ext.seo.components.SeoControllerBehavior'),
               
                );
             
     }
     
     public function accessRules()
    {
        return array(
            array('allow',
                'controllers'=>array('site'),
                'actions'=>array('error'),
            ),

         );
    }
     public function actions(){
		return array(
		         'captcha'=>array(
				'class'=>'CCaptchaAction',
                              	'backColor'=>0xFFFFFF,
			 ),
			'page'=>array(
				'class'=>'CViewAction',
				//'layout' => 'home', //'renderAsText' => true
			 ),
                        'locLookup'  =>  array(
				             'class'      =>  'application.components.actions.SuggestLoc',
				             'modelName'  =>  'Location',
				             'methodName' =>  'suggest',
			 ),
                        
			/* Tutor search*/
                        'fetch.' =>  array(
                                   'class'=>'application.components.widgets.tutSearch.catProvider',
                                   'modelName'=>$_GET['modelName']
                         ),
                         
			 /*
			  *'categories.' =>  array(
                                            'class'=>'application.components.subjProvider',
                                            'modelName'=>$_GET['modelName']
                                          ),
                        'catree.' =>  array(
                                            'class'=>'application.components.widgets.catBrowser',
                                            
                                          ),
                        'quick.' => array('class'=>'application.components.widgets.msgProvider',
                                           ),
                         
                         */
			 
                        'login.'    =>  array('class'=>'application.components.widgets.join.loginProvider'),  
                        
			'contact.'    =>  array('class'=>'application.components.widgets.contactProvider'),
			'tagLookup' => array( 'class'=>'application.components.actions.SuggestTag',
                                       'modelName'=>'Skills',
				       'methodName'=>'suggest'
                                     ),   
                          'gmap.'  =>  array(
                                            'class'=>'application.components.widgets.gmapPick.LocationWidget',
                                            'defaultLocation'=>'Hyderabad, India'
                        ),
                        );
	}
        
       
	public function actionIndex(){
	  
	  $this->render('default');
	  
	}
	
	public function actionBrowse(){
         
          return $this->render('browse');    
	}
	
        public function actionError(){
           if(isset($_GET["login"]))$this->refresh();
	  if($error=Yii::app()->errorHandler->error)
          {   //$this->redirect(array('site/index'));
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }

	        	//$this->render('error');
	      
	}

    
      

	public function actionContact(){
	 
 
	  //$this->layout = 'application.views.layouts.adview';
           	$model=new ContactForm;
		
		if(isset($_POST['ContactForm'])){
             		$model->attributes=$_POST['ContactForm'];
			if($model->validate()){
                               
                                $headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['supportEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
				Yii::app()->sms->send(array('to'=>$model->mobile, 'message'=>'Thanks for contacting us. We will reply to your query shortly-tutorsite team'));
                              // Yii::app()->end();
			}
		}
	$this->render('_contact',array('contact_model'=>$model));        
	
	}
 }