<?php

Yii::import('application.components.widgets.EFancyBox');
class contactProvider extends CWidget{
    
    public $title='Contact Form';
    public $visible=true; 
    public $breadcrumbs;
    public $returnUrl = 'test';
    public $fbmail;
    public $facebook;
    public $model;
    public $contact_model;
    public $layout;
    public $modalId = 'contact-modal';
    public $contactViewFile = 'application.components.widgets.views.contact.contact';
    
    public function init()
    {
	$this->contact_model = new ContactForm;
       /* $this->config = array(
	         'title'   => 'Contact the Advertiser',
        
	//'width' => '67%',
       // 'height' => '54%',
        'enableEscapeButton' => false,
        'overlayShow' => true,
        'overlayOpacity' => 0,
        'hideOnOverlayClick' => false,
       
	'type'          => 'iframe',
          'onClosed'      =>  'function(){alert("are you sure?");parent.location.reload(true);}',
        'afterClose'=> 'function () {
            window.location.reload();
        }',
	'helpers' => '{  overlay : {closeClick: false,
	                 opacity: 0.8, css: {"background-color": "#3f4534"}
	
	            },
	  }'
       // 'helpers' => '{  overlay : {closeClick: false}}'
           );
        $this->target =   '#advt-contact'      ;
         parent::init();*/
    }
 
    
    public static function actions(){
        return array(
                  
        'modal'=>'application.components.actions.getContact',
        );
    }
    
    public function getModule()   {
        // return 'postAd';
    }
        
    
    
    public function run(){
                   
            
            $this->renderContent();
       /* parent::run();*/
   
    }
   
   protected function renderContent(){
      // $this->render('_contact',array('contact_model'=>$this->contact_model));
    $this->controller->renderPartial($this->contactViewFile,array('contact_model'=>$this->contact_model),false,true);
   /* $this->widget('bootstrap.widgets.TbButton', array(
                                             'type' => 'primary',
                                             'size' => 'large',
                                             'url' =>  array('/site/contact.modal'),
                                             'icon' => 'envelope', 
                                             'label' => 'Reply to this Ad', 
                                             // 'htmlOptions'=>array("class" => "btn btn-primary pull-right"),
                                              'htmlOptions'=>array(  
                                                     'id' => 'advt-contact' 
                                                    )
                                              )); */
   }

}
                                     