<?php
class getList extends CAction{
protected $controller;  
protected $keyField;
protected $categRoot;
public function run() { 

//print_r($_GET);Yii::app()->end();

      $controller = $this->getController();
   $controller->layout = 'application.views.layouts.adview';
     $model_class = ucfirst($controller->getId());
     if($model_class === 'Profile'){
                  $this->keyField = 'cv_id';
                  $this->categRoot = '38';
                }
           else if($model_class === 'Jobs'){
                   $this->keyField = 'job_id';
                   $this->categRoot = '';
                }

         else if($model_class === 'Profiles'){
               $this->keyField = 'id';
                $this->categRoot = '6';
                }
//echo $this->categRoot;
//echo $model_class; Yii::app()->end();

     //$status = 2;//$model_class::STATUS_PUBLISHED;
     // $model = new $model_class('search');
     // $model->unsetAttributes();  // clear any default values
      $filtersForm=new FiltersForm;
     /* if (isset($_GET['FiltersForm'])){*/
            $filtersForm->filters=$_GET['Profiles'];
      echo $filtersForm->filters["category_id"];//Yii::app()->end();
       /*}*/
      $criteria=new CDbCriteria(array(
			//'condition'=>'status= 1',//.$model_class::STATUS_PUBLISHED,
			'order'=>'modified DESC',
			//'with'=>'commentCount',
		));
		/*if(isset($params['cat_id'])){
                           $cat = Category::model()->findByPk($params['cat_id']);   
                           if(!empty($cat)) { $mprms['cattxt'] = $cat->link; $mprms['cat_id'] = $cat->id; } 
                           
                } */
		if(isset($_GET['category']) && ((int)$_GET['category'] !== 6))
			$criteria->addSearchCondition('cat_id',$_GET['category']);
		
	        
                if(isset($filtersForm->filters["category_id"]))
			$criteria->addSearchCondition('category',$filtersForm->filters["category_id"]);

                if($_GET['location'] !== '')
			$criteria->addSearchCondition('location',$_GET['location']);
		
                $dataProvider=new CActiveDataProvider($model_class, array(
			'pagination'=>array(
				'pageSize'=>20 //Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));
                
                if(!empty($dataProvider)){
           if(Yii::app()->request->isAjaxRequest){
               $controller->layout = false;
             //  print_r($_GET);Yii::app()->end();
		$controller->render('list',array(
			'dataProvider'=>$dataProvider,
		));
           }
            else{
                // $controller->layout = 'account';
                $controller->render('list',array(
			'dataProvider'=>$dataProvider,
		));
                
            }
                }
           else $this->renderPartial('_empty') ;    
}

  protected function search($filters)
    {  
        $criteria=new CDbCriteria;

		$model_class = ucfirst($this->getController()->getId());

                  $criteria=new CDbCriteria(array(
               //  'condition'=>'status='.Jobs::STATUS_PUBLISHED ,
                //  'order'=>'modified DESC',
                  //'with'=>'cv_skills',
                 ));
            //  $criteria->compare('title',$model_class->title,true);

                if(isset($filters->filters['tags'])){
                    $criteria->with=array('cv_skills'); 
                    $criteria->condition = '';                  
                    $criteria->compare('skills.name',$filters->tags,true);
                        } // print_r($filters->filters);
	    	//$criteria->compare('location',$filters->location,true);
               // $criteria->compare('category',$filters->category,true);
               
                // echo $_GET['category'];            //  $criteria->compare('email',$model_class->email,true);

                    
                if(isset($_GET['location'])){
                          $criteria->addSearchCondition('location',$_GET['location']);
                }
                             
			                    if(isset($_GET['category']))
			$criteria->addSearchCondition('category',$_GET['category']);
                 if(isset($_GET['cat_id']))
			$criteria->addSearchCondition('category',$_GET['cat_id']);
                 if(isset($_GET['category_id']))
			$criteria->addSearchCondition('category',$_GET['category_id']);
		return new CActiveDataProvider($model_class, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'modified DESC',
			),
                        'pagination'=>array('pageSize'=>10),
		));
	}

}
