<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
class doSearch extends CAction{
     
      
        public function run() { 
            $ajaxRequest = false;
          
            $ajaxRequest =  Yii::app()->request->getIsAjaxRequest();
        //print_r($_GET);Yii::app()->end();
         
                   if (Yii::app()->request->isAjaxRequest){ 
                   if(!empty($_POST['location'])) $loc = $_POST['location'];
                   if(!empty($_POST['Ad']['category_id'] )){
                        $cat = Category::model()->findByPk($_POST['Ad']['category_id']);
                        $array = array(
                            'url'=>'/ad/index',
                            'cattxt'=>DCUtil::sanitize($cat->name),'cid'=>$_POST['Ad']['category_id'],'location'=>DCUtil::sanitize($_POST['location']));
                              $json = json_encode($array);
                              echo $json; 
                              Yii::app()->end();
                                  
                   }
               
                   else{
                    
                        $array = array('search' => 'empty');
                        $json = json_encode($array);
                        echo $json; 
                        
                        Yii::app()->end();
                       
                   
                   }
          
        }
        
    }
    
    public function getModule(){
           
        
    }
}
