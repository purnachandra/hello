<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
class getCats extends CAction{
      protected $controller; 
      public $modelName ;
      public $step;
      
      public function run() { 
          $modelName = $_GET['modelName'];
          $cat=Category::model()->findByPk((int)$_POST['super_id']);
          $data = $cat->children()->findAll();
                   
          $data=CHtml::listData($data,'id','name'); 
          echo "<option value=''>---Choose Sub Category---</option>";
          foreach($data as $value=>$name)
                     echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                     
}
  public function getModule(){
        
        
        
    }
}
