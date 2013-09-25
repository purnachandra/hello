<?php
class getBrowse extends CAction{
 protected $controller; 
    public $modelName ;
    public $model;
    public $category;
   
       
    protected function formatData($person) {
      return array(
          'text'=>
           !empty($person->id) ?
	   
	CHtml::link("<span>".$person['name']."</span>","#", array( 'id'=> $person->id,'class'=>'cat-tree-item'))
	   
	   : $person['name'],
          'id'=>$person['id'],
          'hasChildren'=>isset($person['childs'])
          );
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
         
        $cat = Category::model()->findByPk($this->model->category_id);
        $label = empty($cat)? 'Choose Your Training Category':$cat->name;
        $controller = $this->getController();
       // $controller->layout = 'fancy_box_layout';
        $this->modelName = ucfirst($controller->getId());
        $data = $this->getDataFormatted($this->getData());
        $controller->render('dashboard.components.widgets.views.browser',array('modelName'=>$this->modelName,'data'=>$data));
        echo CHtml::activeLabel($this->model,'category_id');
       
       
       
         }
}