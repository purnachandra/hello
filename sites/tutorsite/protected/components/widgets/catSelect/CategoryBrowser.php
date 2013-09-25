<?php
//Yii::import('application.models.Subject');

class CategoryBrowser extends CWidget{
    
    protected $controller; 
    public $modelName ;
    public $model;
    public $category;
    public static function actions(){
        return array(
                   'browse'=>'dashboard.components.actions.getBrowse',
        );
    }
    
     public function getModule()   {
        // return 'postAd';
     }
    protected function formatData($person) {
      return array(
'text'=>CHtml::link($person['name'],'#',array('id'=> $person->id,'onClick'=>'$("#Ad_category_id").val($(this).attr("id"));$("#Ad_category_title").val($(this).text());return false;')),
'id'=>$person['id'],
'hasChildren'=>isset($person['childs']));
    }

    protected function getDataFormatted($data) {
        foreach($data as $k=>$person) {
            $personFormatted[$k] = $this->formatData($person);
            $parents = null;
            if (isset($person['childs'])) {
                $parents = $this->getDataFormatted($person['childs']);
                $personFormatted[$k]['children'] = $parents;
            }
        }
        return $personFormatted;
    }

    
   
    public function actionTreeFill() {
        if ( ! isset($_GET['root']))
            $personId = 'source';
        else
            $personId = 6;//$_GET['root'];

        $persons = ($personId == 'source') ?
$this->getData() : $this->recursiveSearch($personId, $this->getData());

$dataTree = array();
        if (is_array($persons)) {
            foreach($persons as $parent)
                $dataTree[] = $this->formatData($parent);
        }
        echo json_encode($dataTree);
// echo CTreeView::saveDataAsJson($dataTree);
    }

protected function recursiveSearch($id, $rootnode) {
       if (is_array($rootnode)) {
            foreach($rootnode as $person) {
                if ($person['id'] == $id)
                    return $person["childs"];
                else {
                    $r = $this->recursiveSearch($id, $person["childs"]);
                    if ($r !== null)
                         return $r;
}
}
}
return null;
    }
    
    protected function getData() {
        return Category::model()->getCategoryList();
    }
    
    public function run(){
        
        //print_r($data);Yii::app()->end();
        $cat = Category::model()->findByPk($this->model->category_id);
        $label = empty($cat)? 'Choose Your Training Category':$cat->name;
        $controller = $this->getController();
        
        $target = 'window.location='."'".$controller->createUrl('site/contact')."'";
        $this->modelName = ucfirst($controller->getId());
        $data = $this->getDataFormatted($this->getData());
           
        $controller->renderPartial('application.components.widgets.catSelect.views.catBrowser',array('modelName'=>$this->modelName,'data'=>$data));
          
         }
}

?>