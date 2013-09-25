<?php

Yii::import('zii.widgets.CPortlet');

class BreadCategories extends CPortlet
{      public $contentCssClass="breadcrumbs";
        public $decorationCssClass="";
//        public $tagName = "";
        public $titleCssClass = '';
	public $title="You are here!";
	public $maxCategories=20;
        public $locLink ;
        public $parent;
        public $ctitle;
        public $category;
        public $categRoot;
        public $catPath=array();  //="xyz+abc/pqr+stu";
        public $catText;         
        public $bcrumbs = array();
        public $roots;
     //   public $id = 'breadcrumb';
        public $end;
        public $visiblie = false;
	
        public function getLink($cat){

         switch($cat->root){

                 case 6: $locLink = '/profiles/list';break;
                 case 38:  $locLink = '/profile/list';break;

                  case 45:  $locLink = '/jobs/list';break;




                    }


             return $locLink;


        }
        public function getRoots(){
               
                         if(empty($this->category)){
                      $roots = Category::model()->roots()->findAll();
                      return $roots;
                    }    
            }
            
	public function getCategories($cid)
	{    

             

	       $this->locLink = '/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id;
	
                           
                           $model = Category::model()->findByPk($cid);
                           
                           if($model->isLeaf()) {
                          $parent = $model->parent;$model = $parent;}
                      else $parent = $model;
                         $data = $model->children()->findAll();
                            return $data;
           
                       
                                	
        }
    
	protected function renderContent()
	
	{  	
		
	  $controller = $this->getController();
             $model_class = ucfirst($controller->getId());
            

                 if($model_class === 'Ad'){
                               $this->categRoot = '6';
                               if(isset($_GET['id']))   {
                                     $prof = Ad::model()->findByPk($_GET['id']);
                                     $this->category = $prof->cat_id;
                                     $this->end = null;//isset($_GET['title'])? $_GET['title']:'';
                                       }  
                               else if(isset($_GET['cid']))   $this->category = $_GET['cid'];
                               else $this->category = 6;
                               if($this->category == 0){
                                    $this->roots = Category::model()->roots()->findAll();}
                               else { 
                                   $rt = Category::model()->findByPk($this->category);
                                  if(($rt != NULL) && (!$rt->isRoot())) $this->roots[]= $rt->parent;
                                 $this->roots[] = Category::model()->findByPk($this->category);
            			       }

                            foreach($this->roots as $rt) { 
                                if($rt->isRoot())
                                          $this->bcrumbs[$rt->name] = 
                                        array('profiles/siteMap',"category"=>$rt->id,"map"=>$rt->name);
                                       //   CHtml::link($rt->name  ,Yii::app()->createUrl('profiles/siteMap',array("category"=>$rt->id,"map"=>$rt->name)));    
                                 else  
                                      $this->bcrumbs[$rt->name] = 
                                       Yii::app()->createUrl('classifieds/ad/index', array('name' => DCUtil::getSeoTitle($rt->name), 'cid' => $rt->id)); 
                                         //array("/".$rt->link."/".$rt->parent->id);
                                    //  echo CHtml::link($rt->parent->name.' training'  ,"/".$rt->link."/".$rt->parent->id);      
                       
                       
                       	
              
                 
                 foreach($this->getCategories($rt->id) as $child) {
                                      $url = "";                    
                   if($child->isRoot())  {
                   $url = Yii::app()->createUrl('profiles/siteMap',array("category"=>$child->id,"map"=>$child->name)); 
                     }
                   else{            
                        
                          $root = Category::model()->findByPk($child->root);
                            $child->name = $child->name;  //.' training';    //." ".$root->name;

                       
                        $url = "/".$child->link."/".$child->id;                        
                       } 
                     $this->bcrumbs[$rt->name]['menu'][$child->name] = array($url);
                     // echo CHtml::link($child->name  ,$url);        
                         
                             }
                         
   
                            } 

                        }  /* profiles */
      //   $this->bcrumbs[] = $this->end; 
       //  echo $model_class.'yes';Yii::app()->end();
	 
	  if($model_class === 'Ad')  
         	$this->render('bcategories');                //  $this->render('testExpand');

		                               
                  }   


        

  }
