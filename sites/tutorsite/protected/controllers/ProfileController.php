<?php
//Yii::import('application.extensions.upload.Upload');


class ProfileController extends Controller{
private $_model;
        public $defaultAction = 'index';
	/*public function filters(){
		return array(
			'userGroupsAccessControl', // perform access control for CRUD operations
			array('ext.seo.components.SeoFilter + view'), // apply the filter to the view-action
		);
	}*/
	
        public function behaviors(){
                  return array(
                          'seo'=>array('class'=>'ext.seo.components.SeoControllerBehavior'),
                             );
        }

        
	public function filters(){
		return array(
			'UserGroupsAccessControl', 
		);
	}

	public function accessRules(){
		return array(
                    array('allow', // allow authenticated users to access all actions
                                'actions'=>array('fetch.GetData','list','resume'),
				'users'=>array('*'),
			),     
                    array('allow', // allow authenticated users to access all actions
                                'actions'=>array('postcv','uploadAvatar'),
				'users'=>array('@'),
                               
			),    
                    array('allow',  // allow a user tu open an update view just on their own accounts
				'actions'=>array('update'),
				'expression'=>'$_GET["id"] == Yii::app()->user->id',
				//'ajax'=>true,
			),
                     array(
                     'deny', 
			  'users'=>array('*')
                     )
                    );
	}

        public function actions(){
              return array(
                       
                       'list'=> array('class'=>'application.components.actions.getList'),
                        'locLookup'=>array(
				'class'=>'application.components.actions.SuggestLoc',
				'modelName'=>'Location',
				'methodName'=>'suggest',
			),
                        'fetch.' =>  array('class'=>'application.components.widgets.catProvider',
                                    'modelName'=>$_GET['step']),
                        
                         'update' => 'application.components.actions.UpdateAction',
			
                            );
          }
        
      
        
        		
	public function actionDetail(){
            
                $this->layout = 'application.views.layouts.adview';
		$contact_model=new ContactForm;
		$contact_model->scenario = 'registerwcaptcha';
		
		       $adId = isset($_GET['adid']) ? $_GET['adid']: null;
		        if(empty($adId) || (int)$adId == 0){
			       $this->redirect(Yii::app()->createUrl('/classifieds'));
			}
		         
		if(!empty( $adId ) && is_numeric( $adId )){
			//get classified info
			if(!$adInfo = Yii::app()->cache->get( 'ad_info_' . $adId )) {
				//!$adInfo = Ad::model()->with( 'location','category', 'pics')->findByPk( $adId );
				$adInfo = Ad::model()->with( 'category', 'pics')->findByPk( $adId );
				Yii::app()->cache->set('ad_info_' . $adId , $adInfo);	
			}
			$this->view->adInfo = $adInfo;
				
			//get similar classifieds info
			$similarAdsOptions = array('location' 	=> $adInfo->location, 
									   'search_string'	=> $adInfo->ad_title,
									   'where'			=> 'CA.ad_id <> ' . $adId,
									   'offset' 		=> 0,
									   'limit' 			=> 10);
                        
			$cache_key_name = 'similarAds_' . md5(json_encode($similarAdsOptions));
			if(!$similarAds = Yii::app()->cache->get( $cache_key_name )) {									   
				$similarAds = Ad::model()->getSearchList( $similarAdsOptions );
				Yii::app()->cache->set($cache_key_name , $similarAds);	
			}
			$this->view->similarAds = $similarAds;
		
			
			/**
			 * handle classified contact
			 */
			$adContactModel = new ContactForm();
			$this->view->adContactModel = $adContactModel;
			$this->view->showContactForm = 1;
								
			if(isset($_POST['ContactForm'])){
			       $adContactModel->attributes = $_POST['ContactForm'];
				if($adContactModel->validate()){	
				     $adContactModel->body = nl2br(DCUtil::sanitize($adContactModel->body));
					$this->_sendMails($adInfo,$adContactModel,'','ad_contact');
					$this->view->showContactForm = 0;
				        
				
				}
			}	
			//define error array
			$errorArray = array();
			
			//$mail = new AdMail($this->view->adInfo, AdMail::ADCONTACT);
	               // $mail->send();		
			
			$this->view->defaultFormArray 	= $defaultFormArray;	
			$this->view->errorArray 	= $errorArray;
			/**
			 * end of classified contact 
			 */
		//}
		
		//$this->view->breadcrump 		= array(stripslashes($adInfo->ad_title));
            //    $this->view->pageTitle 			= stripslashes($adInfo->ad_title);
		//$this->view->pageDescription 	= stripslashes(DCUtil::getShortDescription(stripslashes($adInfo->ad_title)));
		//$this->view->pageKeywords 		= stripslashes($adInfo->ad_title);
		}  //else not ajax request
		
		$this->render('detail_tpl',array('contact_model'=>$adContactModel));	
        }
 
	protected function gridDetail($data,$row){
              $model= Profile::model()->findByAttributes(array('ug_id' => $data->id));
              return $this->renderPartial('index',array('model'=>$model),true); 
       }
	
      
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
       /**
	 * Updates a user data
	 * if the update is successfull the user profile will be reloaded
	 * You can change password or mail indipendently
	 * @param integer $id the ID of the model to be updated
	*/
	  public function actionPostcv(){      
                 $this->layout = 'adpost';
                 $model = $this->loadModel(Yii::app()->user->id);
                        
                    if( isset( $_POST['Profile'] ) ){
                          $model->attributes = $_POST['Profile'];
                          $model->ug_id = Yii::app()->user->id;	      
                          if( $model->save()){ 
                              if( Yii::app()->request->isAjaxRequest ){
                                   Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                   echo CJSON::encode( array(
                                          'status' => 'success',
                                          'content' => 'Post successfully updated',
                                    ));
                                   exit;
                                  }
                              else
                                 $this->redirect( array('/userGroups') );
                              }
                    }
                    if( Yii::app()->request->isAjaxRequest ){
                          //echo 'ajax request';Yii::app()->end();
                          // $this->renderPartial( '_resume', array('model' => $model ), false, true );
                          // Stop jQuery from re-initialization
                              Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                              echo CJSON::encode( array(
                                    'status' => 'failure',
                                    'content' => $this->renderPartial( '_form', array(
                                    'model' => $model ), true, true ),
                              ));
                              exit;
                    }
                       else
                         $this->render( '_form', array( 'model' => $model) );
	  }
            
          public function actionUploadAvatar(){
                     $imid = $_GET['imid'];  //echo $imid; Yii::app()->end();
                     $image = CUploadedFile::getInstanceByName('file');
              
		 //  if(isset($image) && count($images) > 0 ) {   
		     
                        $uid = Yii::app()->user->id; 
                        $cv = Profile::model()->findByAttributes(array( 'ug_id'=>(int)$uid));
                        $apath = 'users/'.$uid;
                       //Yii::app()->image->save
                        $cv->saveImage($image,'',$apath,$imid);
                           $cv->save();
                           
                //   } $this->redirect('/profile/id/'.Yii::app()->user->id);
                           
                   echo Yii::app()->baseUrl.'/image/default/create/id/'.$imid.'&version=medium';
         }	 
      
          
	  public function setFlash( $key, $value, $defaultValue = null ){
                    Yii::app()->user->setFlash( $key, $value, $defaultValue );
          } 
       
 
         public function loadModel(){
          
         $uid = Yii::app()->user->id;
          if( $this->_model === null ){
               if( $uid > 0 )
                   $this->_model = Profile::model()->findByAttributes(array( 'ug_id'=>(int)$uid));
          if( $this->_model === null )
              $this->_model = new Profile();
               //throw new CHttpException( 404, 'The requested page does not exist.' );
           }
            
           return $this->_model;
      }
	
}