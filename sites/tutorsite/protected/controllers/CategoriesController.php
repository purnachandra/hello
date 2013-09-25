<?php
Yii::import('application.extensions.alphapager.ApPagination');
//require_once 'QueryPath/QueryPath.php';
class CategoriesController extends Controller
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function actionIndex()
	{
         $this->layout = 'application.views.layouts.adview';
	// $this->layout = 'rename_account';
         $model=new Category('search');

	 $criteria=new CDbCriteria();
       	if(isset($_GET['tag']))
			$criteria->addSearchCondition('name',$_GET['tag']);
        
        $alphaPages = new ApPagination('name');
        
        $pages = $alphaPages->pagination;
        $alphaPages->applyCondition($criteria);
        $pages->setItemCount(Subjects::model()->count($criteria));
        $pages->applyLimit($criteria);
	/*$dataProvider=new CActiveDataProvider('Post', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));*/

		$this->render('index',array(
			'model'=>$model,
			'alphaPages'=>$alphaPages,
		));
		
}

/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{       
         $this->layout = 'rename_account';
	
	$id = $_GET['id'];
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Subjects::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}