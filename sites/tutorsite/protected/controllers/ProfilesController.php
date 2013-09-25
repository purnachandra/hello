<?php

class ProfilesController extends Controller{
	
        public $userArray = Array();
        public $email = null;
        private $_model;
       
        public $pageTitle;
        
        public $lat = null;
        public $lng = null;
        public $layout = 'application.views.layouts.adview';

        public $oldTags = Array();
        const GROUP_ID_EMPLOYER = 3;
        const LOGO_DIR_HOME = '/files/posts/';

        public function behaviors(){
             return array(
                'seo'=>array('class'=>'ext.seo.components.SeoControllerBehavior'),
             );
        }

	       
	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'list'=> array('class'=>'application.components.actions.getList'),
			'show.' =>  array(
                                            'class'=>'application.components.widgets.listProvider',
                                           // 'modelName'=>$_GET['step']
                                          ),
                        'locLookup'  =>  array(
				             'class'      =>  'application.components.actions.SuggestLoc',
				             'modelName'  =>  'Location',
				             'methodName' =>  'suggest',
			),
                        'catLookup'=>array(
				'class'=>'application.components.actions.SuggestCat',
				'modelName'=>'Category',
				'methodName'=>'suggest',
			),
                                             
                       'siteMap'=> array('class'=>'application.components.actions.siteMap'),
                         'update' => 'dashboard.components.actions.UpdateAction',
		       'adpost' => 'application.components.actions.CreateAction',
		);
	}

        
	public function filters(){
		return array(
			'UserGroupsAccessControl', 
		);
	}
      
         public function accessRules(){
	
            return array(
		 array( 
                     'allow',
			   'actions'=>array('default','siteMap','list','view','captcha','locLookup','catLookup','uploadLogo','post'),
			   'users'=>array('*'),
                       ),
                array('allow', // allow authenticated users to access all actions
                                'actions'=>array('postad','adpost'),
				'users'=>array('@'),
			), 
                array(
                     'allow',  
			  'actions'=>array('admin'),
			  'users'=>array('admin'),
                       ),
                array('allow',  // allow a user tu open an update view just on their own accounts
				'actions'=>array('update'),
				'expression'=>'$_GET["id"] == Yii::app()->user->id',
				//'ajax'=>true,
			),
                 array(
                     'deny', 
			  'users'=>array('*')
                     ),
                
               );
        }

        protected function performAjaxValidation($model){
             if(isset($_POST['ajax']) && $_POST['ajax']==='job-form'){
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
             }
        }

         /**
	 * Manages all models.
	 */
	public function actionDefault()
	{
		$this->layout = 'adview';
		$this->render('default',array(
			
		));
	}
       /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Profiles('search');
		if(isset($_GET['Profiles']))
			$model->attributes=$_GET['Profiles'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionView(){
             
                $model = $this->loadModelOld($_GET['id']);
               
                $this->pageTitle=$model->cname.'-'.$model->location;

                $cloc = preg_replace('/\s+/', '+',$model->location);
                $address = $cloc.",+Hyderabad,+Andhra+Pradesh,+India&sensor=false";
                $address='http://maps.google.com/maps/api/geocode/json?address='.$address;

		
                $this->render('view',array(
			            'model'=>$model,
                                    'address'=>$address,
                       		));
         }


         protected function gridLogo($data,$row){
            return  CHtml::image($data->logo,'',
                    array("style"=>"width:30px;height:30px;vertical-align:middle")).'<br/>' . 
                           date("F j, Y",$data->modified);
         }  

       
	public function loadModelOld(){
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					$condition='status='.Profiles::STATUS_PUBLISHED.' OR status='.Profiles::STATUS_ARCHIVED;
				else  
					$condition='';
                              
				$this->_model = Profiles::model()->findByPk($_GET['id']);
                                
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


        public function setFlash( $key, $value, $defaultValue = null ){
                  Yii::app()->user->setFlash( $key, $value, $defaultValue );
        }
        
	/**
	 *upload logo facebook like
	 */
               
        public function actionUploadLogo(){
             
              $image = CUploadedFile::getInstanceByName('file');
              $imid = $_GET['imid'];$adid = $_GET['adid'];
		//   if(isset($images) && count($images) > 0 ) {   
		     
                        $uid = Yii::app()->user->id;
                        $apath = 'posts/'.$adid;
                        $ad = Profiles::model()->findByPk($adid);
                        $ad->saveImage($image,'',$apath,$imid);
                        $ad->save();
                    
                  //      }
                        
           echo Yii::app()->baseUrl.'/image/default/create/id/'.$imid.'&version=medium';         
         // $this->redirect('/profile/id/'.Yii::app()->user->id);
        }	 

    public function saveImages($image,$il){
             
             
                  //echo $image->name; echo $il->image_path;
                if($image->saveAs(Yii::getPathOfAlias('webroot').$il->image_path)){    
                     try{  //print_r($il->attributes);
                           $ilg = Yii::app()->eimage->load(Yii::getPathOfAlias('webroot').$il->image_path);
                           $ilg->resize(400, 400); 
                           if($ilg->save()){ 
                              
                               Yii::app()->user->setFlash('success','Image upload successful.');
                               return $image;
                           }  
                       } 
                  catch(Exception $e){
                           Yii::app()->user->setFlash('error',
                                'Retry:'. $e->getMessage().'. Please verify your image and try again!' );
                  }
              }  
    }
    
    
     /**
	 * Updates a user data
	 * if the update is successfull the user profile will be reloaded
	 * You can change password or mail indipendently
	 * @param integer $id the ID of the model to be updated
	*/
	public function actionPostad(){      
             $this->layout = 'account';
                 $model = $this->loadModel(Yii::app()->user->id);
                       
            if( isset( $_POST['Profiles'] ) ){
                   $model->attributes = $_POST['Profiles'];
                   $model->ug_id = Yii::app()->user->id;	      
             if( $model->save()){ 
                   if( Yii::app()->request->isAjaxRequest ){
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode( array(
                                   'status' => 'success',
                                   'content' => 'Ad successfully updated',
                           ));
                           exit;
                        }
                   else
                        $this->redirect( array('/userGroups') );
                  }
              }
              
            
              if( Yii::app()->request->isAjaxRequest ){
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
        
   public function loadModel(){
          
         $uid = Yii::app()->user->id;
          if( $this->_model === null ){
               if( $uid > 0 )
                   $this->_model = Profiles::model()->findByAttributes(array( 'ug_id'=>(int)$uid));
          if( $this->_model === null )
              $this->_model = new Profiles();
               //throw new CHttpException( 404, 'The requested page does not exist.' );
           }
            
           return $this->_model;
      }
}