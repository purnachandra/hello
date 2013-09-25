<?php
class getData extends CAction{
private $userArray = array();

public $model_name;

    public function run(){
       // $controller = $this->getController();
 

    // get the Model Name
   // $model_class = ucfirst($controller->getId());
 
   // if(isset($_GET['category'])){
  //     $controller->render('relcat'); 
 //   }

    // create the Model
  //  $model = new $model_class();
    // $model=new Location;
 
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
      /*  if(isset($_POST['Location']))
        {
            $model->attributes=$_POST['Location'];
            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>"Location successfully added"
                        ));
                    exit;               
                }
                else
                    $controller->redirect(array('view','id'=>$model->id));
            }
        }
 
        if (Yii::app()->request->isAjaxRequest)
        {   
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=> $controller->renderPartial('location', array('location'=>$model), true)));
            exit;               
        }
        else
            $controller->render('location',array('location'=>$model,)); */
echo 'Test succeeded'; 
           }
       

}