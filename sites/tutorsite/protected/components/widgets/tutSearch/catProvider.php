<?php

class catProvider extends CWidget{
    
    protected $controller; 
    public $modelName ;
    public $model;
    public $root;
    public $category;
    public static function actions(){
         return array(
                   'GetData' => 'application.components.widgets.tutSearch.actions.getCats',
                    'search' => 'application.components.widgets.tutSearch.actions.doSearch'
        );
    }
    
     public function getModule()   {
        // return 'postAd';
     }
        
     public function init()
    {   if(empty($this->root)){
        $roots = Category::model()->roots()->findAll();
         $this->root = $roots[0];}
    }
    
    public function run(){
        $roots = Category::model()->roots()->findAll();
        $root = $roots[0];
        $controller = $this->getController();
        
        echo '<div class="panel panel-success"><div class="panel-heading"><h3 class="panel-title">Search Tutors</h3></div>';
        echo '<div class="panel-body">';
              
         $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'searchForm',
                            'action'=>Yii::app()->createUrl('/site/fetch.search'),
                            'enableAjaxValidation'=>false,
         ));
      
        echo '<div class="control-group">';
        echo CHtml::activeLabelEx($this->model,'category_id',array('class'=>'control-label')); 
        echo '<div class="controls">';
        echo CHtml::activeDropDownList($this->model,'scat_id', CHtml::listData($this->root->children()->findAll(),CHtml::encode('id'), 'name'),
           array( 'prompt' => '---Select a category---',
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('/site/fetch.GetData',array('modelName'=>$this->modelName)), 
                  'update'=>'#'.$this->modelName.'_category_id',
                  'beforeSend' => 'js:function(){ 
                                    // $("#something").hide();
                                     $("#something").addClass("loading");
                                     }',
                  'complete' => 'js:function(){ //js:alert("completed");
                                   //  $("#something").show();
                                     $("#something").removeClass("loading");
                                     }',    
                  
                     'data'=>array('super_id'=>'js:this.value'), 
                  ))); 
            echo '<br>';
            echo CHtml::label('Sub category','',array('class'=>'control-label'));
            echo '<br>';
            $catarr = array();
         
            if(!empty($this->model->category_id)){
                   $scat =  Category::model()->findByPk($this->model->category_id);
                   $catarr = array( $scat->id => $scat->name );   
            }
                  
                   echo CHtml::activeDropDownList($this->model,'category_id',$catarr,array('prompt'=>'---choose one---')); 
               
                   echo '</div>';
                   echo '</div>';
         
         echo '<br><div class="form-actions">';

         $this->widget('bootstrap.widgets.TbButton', array(
                              'buttonType' => 'ajaxSubmit',
			      'type' =>'custom',
                              'url' => array('/site/fetch.search'),
                               'label' => 'Search', 'icon' => 'ok',
                              'htmlOptions'=>array("id"=>"search","class" => "btn btn-primary"),
                              'ajaxOptions' => array(
                              'beforeSend' => 'function() { 
                                     $("#search").attr("disabled",true);
                                                 }',
                              'complete' => 'function() { 
                                    $("#searchForm").each(function(){
                                    // this.reset();
			  
                              });
                            $("#search").attr("disabled",false);
                         
                        }',
		       'success'=>'function(data){  
                            var obj = jQuery.parseJSON(data);  //alert(data);
	                    var $href = "";
	                    if("url" in obj){ // js:alert(obj["url"]);
	                        if(obj["location"])
	                          $href = "/categories/" + obj["cattxt"] + "/" + obj["cid"] + "/" + obj["location"];
	                        else $href =  "/categories/" + obj["cattxt"] + "/" + obj["cid"];   
	                        window.location.href = $href;
	                    }
                            else if("search" in obj){
	                       $("#earch-error-div").html("<h6>Choose a Category!</h6>");
	                       $("#earch-error-div").show();
	   	            }
	                }'
	       ),
        )); 
            
        echo '</div>';
       
        $this->endWidget();
        echo '</div></div>';
    }
        
}

?>