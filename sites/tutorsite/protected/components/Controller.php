<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController{
	/**
	 * @var mixed the default tooltip for every controller.
	 * if you give to this parameter a boolean false value instead of an array,
	 * the controller will not be displayed in the permission menagement view.
	 * for more information view the documentation in the userGroups module.
	 */
	public static $_permissionControl = array('read' => false, 'write' => false, 'admin' => false);
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * The filter method for 'UserGroupsAccessControl' filter.
	 * This filter is a wrapper of {@link UserGroupsAccessControl}.
	 * To use this filter, you must override {@link accessRules} method.
	 * @param CFilterChain $filterChain the filter chain that the filter is on.
	 */
	
	private $_assetsUrl;
	
	public $returnUrl;
	
	public $view;
	
	public function init(){         
	     parent::init();	
	     $this->view = new stdClass();
	     //if(isset($_GET['login']))
		$cs = Yii::app()->clientScript;
             // $cs->registerCoreScript('jquery');
        
	}
	
	public function filterUserGroupsAccessControl($filterChain){
		Yii::import('application.models.UserGroupsUser');
		Yii::import('application.models.UserGroupsConfiguration');
		Yii::import('application.components.UserGroupsAccessControl');
		$filter=new UserGroupsAccessControl;
		$filter->setRules($this->accessRules());
		$filter->filter($filterChain);
	}
	
	protected function afterRender($view, &$output){
             parent::afterRender($view,$output);
            //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
            Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
            Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
            return true;
        }
       
    /**
    * @return string the base URL that contains all published asset files of this module.
    */
     public function getAssetsUrl(){
        if($this->_assetsUrl===null)
            Yii::app()->getAssetManager()->publish( 
                    Yii::getPathOfAlias( 'redmond' ), false, -1, false );
        return $this->_assetsUrl;
     }
    
     public function registerImage($file){
        return $this->getAssetsUrl().'/img/'.$file;
    }
    
    /**
    * @param string the base URL that contains all published asset files of this module.
    */
    public function setAssetsUrl($value){
        $this->_assetsUrl=$value;
    }
    
     public function registerCss($file, $media='all'){
        $href = $this->getAssetsUrl().'/css/'.$file;
        return '<link rel="stylesheet" type="text/css" href="'.$href.'" media="'.$media.'" />';
    }
    
    //UTILITY FUNCTIONS
    public function registerCssAndJs($folder, $jsfile, $cssfile){
        $sourceFolder = YiiBase::getPathOfAlias($folder);
        $publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerScriptFile($publishedFolder . $jsfile, CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($publishedFolder . $cssfile);
    }
    
    public  function registerJs($folder, $jsfile){
        $sourceFolder = YiiBase::getPathOfAlias($folder);
        $publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerScriptFile($publishedFolder .'/'.  $jsfile);
        return $publishedFolder .'/'. $jsfile;
    }
	
}