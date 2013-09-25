<?php
Yii::import('zii.widgets.CPortlet');
Yii::import('application.components.widgets.browse.extensions.alphapager.ApPagination');

class BrowseAll extends CWidget
{
 public function run()
    {  
  
$model=new Category('search');

	 $criteria=new CDbCriteria();
       	if(isset($_GET['tag']))
	   $criteria->addSearchCondition('name',$_GET['tag']);
        
        $alphaPages = new ApPagination('name');
        
        $pages = $alphaPages->pagination;
        $alphaPages->applyCondition($criteria);
        $pages->setItemCount(Subjects::model()->count($criteria));
        $pages->applyLimit($criteria);
	
        $this->getController()->renderPartial('application.components.widgets.browse.views.catindex',array(
			'model'=>$model,
			'alphaPages'=>$alphaPages,
		),false,true);
          }
   
    
}