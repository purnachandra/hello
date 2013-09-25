<?php
class SearchController extends Controller
{
      public $defaultAction = 'search';


      public function actionSearch(){
          $ajaxRequest = false;
          
         $ajaxRequest =  Yii::app()->request->getIsAjaxRequest();
   //print_r($_POST);Yii::app()->end();
          // $controller = $this->getController();
       //  echo $_POST['model_class'];
           switch($_POST['model_class']){
               case 'Profile':
                   if(!empty($_POST['Profile']['cat_id'] ))  {  //echo 'Hello';
                      $cat = Subsubject::model()->findByPk($_POST['Profile']['cat_id']);
                      $this->redirect(array('/profile/list','cattxt'=>$cat->name,
                          'cat_id'=>$_POST['Profile']['cat_id'],
                          'location'=>$_POST['location']
                         )
                              );
                }
                else if(!empty($_POST['location']))
                    $this->redirect(array('/profile/list',
                          'location'=>$_POST['location']
                         )
                              );
               else  $this->redirect(array('/profile/list'        
                         )
                              );
                   break;
               case 'Ad': 
                   if (Yii::app()->request->isAjaxRequest){  //print_r($_POST);Yii::app()->end();
                   if(!empty($_POST['location'])) $loc =      $_POST['location'];
                   if(!empty($_POST['Ad']['category_id'] )) {
                            $cat = Category::model()->findByPk($_POST['Ad']['category_id']);
                            $array = array('url'=>'/ad/index',
                                   'cattxt'=>DCUtil::sanitize($cat->name),
                                    'cid'=>$_POST['Ad']['category_id'],
                                    'location'=>DCUtil::sanitize($_POST['location']),
                                    //'isAjax'=>$ajaxRequest
                                    );
                              $json = json_encode($array);
                              echo $json; 
                              Yii::app()->end();
                                  
                                 }
                /*   else if(!empty($_POST['location'])){  
                    $this->redirect(array('/profiles/list',
                          'location'=>$_POST['location'],'isAjax'=>$ajaxRequest ) );}  */
                   else {
                         $array = array('search' => 'empty');
                          $json = json_encode($array);
                              echo $json; 
                        // echo CActiveForm::validate($model);
                                   Yii::app()->end();
                       Yii::app()->end();
                      // $this->redirect(array('/profiles/list' ));
                   
                   }
           }
                   break;
               case 'Profiles':  //print_r($_POST);
                   if (Yii::app()->request->isAjaxRequest){
                   if(!empty($_POST['location'])) $loc =      $_POST['location'];
                   if(!empty($_POST['Profiles']['category_id'] )) {
                            $cat = Category::model()->findByPk($_POST['Profiles']['category_id']);
                            $array = array('url'=>'/profiles/list',
                                   'catitl'=>DCUtil::sanitize($cat->name),
                                    'category'=>$_POST['Profiles']['category_id'],
                                    'location'=>DCUtil::sanitize($_POST['location']),
                                    //'isAjax'=>$ajaxRequest
                                    );
                              $json = json_encode($array);
                              echo $json; 
                              Yii::app()->end();
                                  
                                 }
                /*   else if(!empty($_POST['location'])){  
                    $this->redirect(array('/profiles/list',
                          'location'=>$_POST['location'],'isAjax'=>$ajaxRequest ) );}  */
                   else {
                         $array = array('search' => 'empty');
                          $json = json_encode($array);
                              echo $json; 
                        // echo CActiveForm::validate($model);
                                   Yii::app()->end();
                       Yii::app()->end();
                      // $this->redirect(array('/profiles/list' ));
                   
                   }
           }
                   break;
                  
                   case 'Profile':  //print_r($_POST);
                   if (Yii::app()->request->isAjaxRequest){
                   if(!empty($_POST['location'])) $loc =      $_POST['location'];
                   if(!empty($_POST['Profile']['category_id'] )) {
                            $cat = Category::model()->findByPk($_POST['Profile']['category_id']);
                            $array = array('url'=>'/classifieds/profile/list',
                                   'cattxt'=>DCUtil::sanitize($cat->name),
                                    'category'=>$_POST['Profiles']['cat_id'],
                                    'location'=>DCUtil::sanitize($_POST['location']),
                                    //'isAjax'=>$ajaxRequest
                                    );
                              $json = json_encode($array);
                              echo $json; 
                              Yii::app()->end();
                                  
                                 }
                /*   else if(!empty($_POST['location'])){  
                    $this->redirect(array('/profiles/list',
                          'location'=>$_POST['location'],'isAjax'=>$ajaxRequest ) );}  */
                   else {
                         $array = array('search' => 'empty');
                          $json = json_encode($array);
                              echo $json; 
                        // echo CActiveForm::validate($model);
                                   Yii::app()->end();
                       Yii::app()->end();
                      // $this->redirect(array('/profiles/list' ));
                   
                   }
           }
                   break;
                   }
        
           }
       
}
