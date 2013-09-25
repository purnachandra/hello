<?php

/**
 * Main configuration.
 * All properties can be overridden in mode_<mode>.php files
**/
    require_once(dirname(__FILE__) . '/system.config.php');
    
    Yii::setPathOfAlias('image' , dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'image');
    Yii::setPathOfAlias('dashboard' , dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'dashboard');
    Yii::setPathOfAlias('bootstrap', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'dashboard/library/bootstrap');
    Yii::setPathOfAlias('avatars', dirname(__FILE__).'/../../files/images/users');
             
    return array(
        //'baseUrl' => '/sites/caringtutors.com',
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
        'modulePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules',
       	'name' => 'Pride Home Tutions',
        'defaultController'=>'site',
                
	'preload' => array('log','uiSettings','clientScript','DCInit'),
	'import' => array(
                   
	        'application.models.*',
		'application.components.*',
		'application.components.widgets.*',
                'image.models.*',
                'image.components.*',
                'application.modules.image.models.Image',
                'application.vendors.yii-mail.YiiMailMessage',
                       
	),
            
        'aliases' => array(
		
                'accounts'=>dirname(__FILE__).'/../modules/userGroups',
        ),
                
        'controllerMap'=>array(
                'min'=>array(
                    'class' => 'ext.minScript.controllers.ExtMinScriptController',
                ),
        ),
                
        /******************************************************/            
        /*** A P P L I C A T I  O N   C O M  P O N E N T S  ***/
        /******************************************************/
    
        'components' => array(
            
            'widgetFactory' => array(
                'class'=>'EWidgetFactory',
              'widgets' => array(
                'CJuiButton' => array(
                    'themeUrl' => '/public/css/jqueryui',
                    'theme' => 'fc',
                ),
               
                'CJuiTabs' => array(
                    'themeUrl'=>'/public/css/jqueryui/themes',
                    'theme' => 'fc',
                ),
              ),
            ),         
            'session'=>array(
                        'class'=>'CHttpSession',
		        'autoStart' => true,
		        'sessionName' => 'caringtutors'
		    ),
	    'cache' =>array(
		        'class'=>'system.caching.CFileCache',
		    ),
                              
            'clientscript'=>array(
                        'class'=>'ext.minScript.components.ExtMinScript',
                      'scriptMap'=>array(
                       // 'themeUrl' => Yii::app()->baseUrl.'/public/css/jqueryui/fc/jquery-ui.css'
                        //'jquery-ui.css' => '/public/css/jqueryui/fc/jquery-ui.css',
                      ),
            ),  
                              
                    //FACEBOOK SOCIAL PLUGINS
            'facebook' => array(
                        'class' => 'ext.yii-facebook-opengraph.SFacebook',
                        'appId'=>'375330325919116', // needed for JS SDK, Social Plugins and PHP SDK
                        'secret'=>'9dd58ddf6809bd4171d41c1c8d720605', // needed for the PHP SDK
                        //'fileUpload'=>false, //needed to support API POST requests which send files
                        //'trustForwarded'=>false, // trust HTTP_X_FORWARDED_* headers ?
                        //'locale'=>'en_US', // override locale setting (defaults to en_US)
                        //'jsSdk'=>true, // don't include JS SDK
                        //'async'=>true, // load JS SDK asynchronously
                        //'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
                        'status'=>false, // JS SDK - check login status
                        //'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
                        //'oauth'=>true,  // JS SDK - enable OAuth 2.0
                        //'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
                        //'frictionlessRequests'=>true, // JS SDK - enable frictionless requests for request dialogs
                        //'html5'=>true,  // use html5 Social Plugins instead of XFBML
                        'ogTags'=>array(  // set default OG tags
                        'title'=>'caringtutors.com',
                             //'description'=>'MY_WEBSITE_DESCRIPTION',
                            //'image'=>'URL_TO_WEBSITE_LOGO',
                        ),
                    ), 
                           
                         
                    //FILE MANAGEMENT          
            'file' => array(
                        'class'=>'application.extensions.file.CFile',
                    ),
                                    
                    //USER LOGIN
            'user'=>array(
                            //enable cookie-based authentication
                        'class' => 'application.components.WebUserGroups',
                        'allowAutoLogin' => true,
                        'loginUrl'  => array('/'),
                        'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
                        'returnUrl' => array('/'),
                    ),
                                                
                    // URL MANAGEMENT :uncomment the following to enable URLs in path-format
                                
            'urlManager'=>array(
                                    
                        'urlSuffix' => '.html',
                        'urlFormat' => 'path',
                                          
                        'rules' => array(
                                '/' => 'site/page/view/home',
                                   // 'tutors/<cattxt:.*>/<cid:\d+>' => 'profile/list',
                                 '/find-tutor' => 'site/browse',   
                                'profile/*'=>'/dashboard/public',
                                'logout' => '/user/logout',
                                
                                'index.html' => 'site/index', 
                                'contact_us' => 'site/contact',
                                'join_us' => 'site/registration',  
                                                                                              
                                  //  'tutors/<cattxt:.*>/<cat_id:\d+>' => 'profile/list',
                                  //  'tutors/<cattxt:.*>/<cat_id:\d+>/<location:(.*)>' => 'dashboard/profile/list',
                                                  
                                'tutor_registration' => '/postAd/registration/postcv',
                                'trainers' => '/profile/list',  
                                                                                                
                                'subjects/index' => 'categories',
                                   
                                'trainers' => '/ad/index',
                                'tutor(<adtitle:.*>)_<adid:\d+>' => 'ad/detail',
                                'categories/<cattxt:.*>/<cid:\d+>' => 'ad/index',
                                    
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                                                                 
                            ),
                            'showScriptName'=>false,
            ),
                                
                    
            'db'=>array(
                                            
                            'connectionString' => 'mysql:host=localhost;dbname=caringtu_pravi',
                            'emulatePrepare' => true,
                            'username' => 'Your username',
                            'password' => 'Your Password',
                            'charset' => 'utf8',
                            'tablePrefix' => 'tbl_',
                            'enableParamLogging' => true,
			    'schemaCachingDuration' => 1
            ),    
         
                                          
            'image'=>array(
                            'class'=>'ImgManager',
                            'versions'=>array(
                                    'small'=>array('width'=>120,'height'=>120),
                                    'medium'=>array('width'=>320,'height'=>320),
                                    'large'=>array('width'=>640,'height'=>640),
                            ),
            ),
                    
            'mail' => array(
                                'class' => 'application.vendors.yii-mail.YiiMail',
                                'transportType' => 'php',
                                'viewPath' => 'application.views.mail',
                                'logging' => true,
                                'dryRun' => false
            ),
           		
                                               
                                   
            'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                                array(
                                    'class'=>'CFileLogRoute',
                                    'levels'=>'error, warning',
                                ),
                                // uncomment the following to show log messages on web pages
                                array(
                                    'class'=>'CWebLogRoute',
                                    'showInFireBug' => true
                                ),
                        ),
                    ),
            ),

            /*******************************************************************/    
            /***A P P L I CA T I O N  M O D U L E S C O N F I G U R A T I O N***/
            /*******************************************************************/            
                
            'modules'=>array( 
                'dashboard' => array(
                                'class' => 'application.modules.dashboard.DashboardModule',
                                'accessCode'=>'pride_56!@__&*(',
                                'profile' => array('Profiles','Profile')
                ),    
                'image' => array(
                            'createOnDemand'=>true, // requires apache mod_rewrite enabled
                            'install'=>true, // allows you to run the installer
                ),
                                  
            ),
            
            /******************************************************************************/    
            /************** A P P L I CA T I O N  L E V E L  P A R A M E  T E R S *********/
            /*****************************************************************************/    
            
            'params' => array(
                       // 'avatarsPrefix'=>'/sites/caringtutors.com/uploads/avatars',
                       // 'logosPrefix' => '/sites/caringtutors.com/uploads/logos/',
                        'adminEmail' => 'admin@pridehometutions.in',
                       // 'ad-adminEmail' => 'ad-admin@caringtutors.com',
                        'supportEmail' => 'support@pridehometutions.in',
            	    
            ) 
);