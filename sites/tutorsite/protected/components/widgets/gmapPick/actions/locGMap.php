<?php
class locGMap extends CAction{
   
    private $assets;
    public $model;
    public $mapViewFile = 'application.components.widgets.gmapPick.views.picker';
    
    protected function init()
  {    if(empty($this->assets)){
    	        $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/../assets');
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=' . $this->map_key . '&sensor=false');
		//$cs->registerScriptFile($this->assets . '/jquery-1.7.2.min.js');
		$cs->registerScriptFile($this->assets . '/jquery-gmaps-latlon-picker.js');
		$cs->registerCssFile($this->assets . '/jquery-gmaps-latlon-picker.css');
        }
  } 
    public function run(){
	
        $controller = $this->getController();
        $controller->layout = 'application.components.widgets.gmapPick.views.layouts.google_map_layout';
        $model = $this->model;
        $this->model = new Ad;
	$controller->render($this->mapViewFile,array('model'=>$this->model));
   
    }
       

}