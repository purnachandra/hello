<div class="">
<?php
Yii::import('application.components.widgets.browse.extensions.alphapager.ApListView');
Yii::import('application.components.widgets.browse.extensions.alphapager.ApActiveDataProvider');
//$this->widget('application.extensions.alphapager.ApLinkPager',array('pages'=>$alphaPages));

/*$this->widget('application.extensions.alphapager.ApGridView', array(    
'dataProvider'=>$model->search(),'filter'=>$model,'template'=>"{alphapager}\n{pager}\n{items}",));
*/
 $this->widget('ApListView', array(
	'id'=>'main-category-grid',
	'dataProvider'=>$model->search(),
	'itemView' => 'application.components.widgets.browse.views._catindex',
         'template' =>"{alphapager}\n{pager}\n{items}",  //'type'=>'striped bordered condensed',
         'itemsTagName' => 'div',
               'pagerCssClass' => 'btn',            
         'ajaxUpdate'=>false,  
  /*      'pager'=>array(
         'class'=>'SimplePager',
 // 'prevPageLabel'=>'&lt;',
 // 'nextPageLabel'=>'&gt;',      
)*/
       )
       )       ; ?>
</div>
