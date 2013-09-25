<?php

Yii::import('application.components.widgets.browse.extensions.alphapager.ApActiveDataProvider');
/**
 * This is the Nested Set  model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $root
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 */
class Category extends CActiveRecord
{
public $childs = array();
         /**
	 * Id of the div in which the tree will berendered.
	 */
    const ADMIN_TREE_CONTAINER_ID='category_admin_tree';


	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        /**
	 * @return string the class name
	 */
          public static function className()
	{
		return __CLASS__;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE1: you should only define rules for those attributes that
		// will receive user inputs.
                // NOTE2: Remove ALL rules associated with the nested Behavior:
                //rgt,lft,root,level,id.
		return array( array('name','required'),
			array('link', 'safe'),
		/*	array('level', 'numerical', 'integerOnly'=>true),
			array('root, lft, rgt', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, root, lft, rgt, level', 'safe', 'on'=>'search'),*/
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'Childs' => array(self::HAS_MANY, 'Category', 'parent_id'),
                 //   'getparent' => array(self::BELONGS_TO, 'Category', 'level'),
                 //   'childs' => array(self::HAS_MANY, 'Category', 'level', 'order' => 'id ASC'),		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'root' => 'Root',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('root',$this->root,true);
		$criteria->compare('lft',$this->lft,true);
		$criteria->compare('rgt',$this->rgt,true);
		$criteria->compare('level',$this->level);

		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
	
                return new ApActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,            'alphapagination'=>array(
                'attribute'=>'name',
            ),
        ));
	}

        public function behaviors()
{
    return array(
        'NestedSetBehavior'=>array(
          //  'class'=>'ext.nestedBehavior.NestedSetBehavior',

                  'class'=>'ext.yiiext.behaviors.NestedSetBehavior',
            'leftAttribute'=>'lft',
            'rightAttribute'=>'rgt',
            'levelAttribute'=>'level',
            'hasManyRoots'=>true
            )
    );
}

         /**
	 * @param integer the maximum number of comments that should be returned
	 * @return array the most recently added comments
	 */
	public function findRecentCats($limit=10)
	{
		/* return $this->with('post')->findAll(array(
			'condition'=>'t.status='.self::STATUS_APPROVED,
			'order'=>'t.create_time DESC',
			'limit'=>$limit,
		)); */
		return $this->findAll(array(
			//'condition'=>'t.status='.self::STATUS_APPROVED,
			'order'=>'t.id DESC',
			'limit'=>$limit,
		));
	}


        public function getListed($modelName = 'Ad'){
              
            $subitems = array();
            $children = $this->children()->findAll();
                
            if($children) foreach($children as $child){        
               $subitems[] = $child->getListed();
            }
            $url = ($this->id == 6)? Yii::app()->createUrl('/categories') : Yii::app()->createUrl('ad/index', array('cattxt' => DCUtil::getSeoTitle($this->name), 'cid' => $this->id));   
            $returnarray = array(
                'label' => $this->name, 
                'url'=> $url,
                'linkOptions'=>array('id'=> $this->id)
	    );
           // $homeArr =    array('items'=>array('label'=>'Home'));
            if($subitems != array())
              
                 $returnarray = array_merge($returnarray, array('items' => $subitems));
           
                // $returnarray =  array_merge($returnarray,array('label'=>'Tutors','items' => $itm));   
             
                // $homeArr = array('label'=>'Home');
            return $returnarray; 
      }
	
	/*
	 *
	 *By chandra for ads
	 */
	public function getChilds( $level = 0 ) 
	{
	    $ret = array();
	    $level++;
	    $children = $this->children()->findAll();
		if( $children ){
			$condition = 'ad_id = :cid';
			$params = array();
			
			//check if there is location selected for ads count
			if(isset(Yii::app()->session['lid']) && !empty(Yii::app()->session['lid'])){
				$condition = 'category_id = :cid ';  //AND location_id = :lid';
				$params[':lid'] = Yii::app()->session['lid']; 
			}
			
	    	        foreach($children as $child) {
	    		      $params[':cid'] = $child->id;
	    		      $ret[] = array(	'id' 		=> $child->id, 
	    						'name' 	=> $child->name,
	    						'level'				=> $level,
	    						'childs' 			=> $child->getChilds( $level ),
	    						'count'				=> Ad::model('Ad')->count($condition, $params));
	    	}
	    }
	    
	    return $ret;
	}
        public function getCategoryList()
	{
		$ret = array();
		$root = $this->findByPk(6);
		$parentCategories = $root->children()->findAll();
		
		if(!empty($parentCategories)){
			foreach ($parentCategories as $k){
				if(!$k->isLeaf())
				$ret[] = array(	'id' 		=> $k->id, 
							  	'name' 	=> $k->name,
							  	'childs' 			=> $k->children()->findAll());
				
			}
                        
		}
		return $ret;
                
              

                
                
	}
	public function getCategoryUlList( &$_container , $_data = array() )
	{
		
                if(!empty($_data)){
			foreach ($_data as $k){
				$_container .= '<li>';
				//$category_url = Yii::app()->createUrl('ad/index', array('name' => DCUtil::getSeoTitle($k['name']), 'cid' => $k['id']));
				$category_url = Yii::app()->createUrl('ad/index', array('cattxt' => DCUtil::getSeoTitle($k['name']), 'cid' => $k['id']));
				$_container .= '<a href="' . $category_url . '">' . $k['name'] . '</a>';
				if(!empty($k['childs'])){
					$_container .= '<ul id="megamenu">';
					$this->getCategoryULList( $_container, $k['childs'] );
					$_container .= '</ul>';
				}
				$_container .= '</li>';
			}
		}

	}
	/**
	 * create ready for use in html option category hierarhy
	 *
	 * @param array $_container
	 * @param array $_data
	 */
	public function getCategoryHtmlList( &$_container = array(), $_data = array() )
	{
		if(!empty($_data)){
			foreach ($_data as $k){
				$space = '';
				if(isset($k['level'])){
					$space = str_repeat('&nbsp;' , $k['level']);
				}
				
				$_container[$k['id']] = $space . $k['name'];
				if(!empty($k['childs'])){
					$this->getCategoryHtmlList( $_container, $k['childs'] );
				}
			}
		}
	}
	public function getCategoryHomeBlocks( &$_container , $_data = array()  )
	{
		
		if(!empty($_data)){
			$i = 0;
			foreach ($_data as $k){
				$category_url = Yii::app()->createUrl('ad/index', array('cattxt' => DCUtil::getSeoTitle($k['name']), 'cid' => $k['id']));
				
				if(!isset($k['level'])){
					$_container .= '<div class="panel panel-info">';
    					//$_container .= '<div class="panel-heading"><a href="' . $category_url . '">' . $k['name'] . '</a></div>';
					$_container .= '<div class="panel-heading">' . $k['name'] . '</div>';     
    					$_container .= '<div class="">';
				} else {  //echo $k['level'];
					if( $k['level'] > 0){
						$_container .= '<div class="home_category_block_item">&raquo; <a href="' . $category_url . '">' . $k['name'] . '</a> (' . '0' . ')</div>';
					}
				}
				
				if(!empty($k['childs'])){
					$this->getCategoryHomeBlocks( $_container, $k['childs'] );
				}
				
				if(!isset($k['level'])){
					$_container .= '</div>';
					$_container .= '</div>';
					$i++;
					if($i == 3){
						$i = 0;
						//$_container .= '<div class="clear"></div>';
					}
				}
				
			}//end of foreach
		}//end of if
	} 
		       /** end of chandra*/
		       
        public static  function printULTree(){
		    $categories=Category::model()->findAll(array('order'=>'root,lft'));
		    $level=0;
	       
	       foreach($categories as $n=>$category)
	       {
	       
		   if($category->level==$level)
		       echo CHtml::closeTag('li')."\n";
		   else if($category->level>$level)
		       echo CHtml::openTag('ul')."\n";
		   else
		   {
		       echo CHtml::closeTag('li')."\n";
	       
		       for($i=$level-$category->level;$i;$i--)
		       {
			   echo CHtml::closeTag('ul')."\n";
			   echo CHtml::closeTag('li')."\n";
		       }
		   }
	       
		   echo CHtml::openTag('li',array('id'=>'node_'.$category->id,'rel'=>$category->name));
		   //echo '<div class="home_category_block_item">&raquo;'; 
		     echo CHtml::openTag('a',array('href'=>'#'));
		   echo CHtml::encode($category->name);
		     echo CHtml::closeTag('a');
	       
		   $level=$category->level;
	       }
	       
	       for($i=$level;$i;$i--)
	       {
		   echo CHtml::closeTag('li')."\n";
		   echo CHtml::closeTag('ul')."\n";
	       }

        }

public static  function printULTree_noAnchors(){
    $categories=Category::model()->findAll(array('order'=>'lft'));
    $level=0;

foreach($categories as $n=>$category)
{
    if($category->level == $level)
        echo CHtml::closeTag('li')."\n";
    else if ($category->level > $level)
        echo CHtml::openTag('ul')."\n";
    else         //if $category->level<$level
    {
        echo CHtml::closeTag('li')."\n";

        for ($i = $level - $category->level; $i; $i--) {
                    echo CHtml::closeTag('ul') . "\n";
                    echo CHtml::closeTag('li') . "\n";
                }
    }

    echo CHtml::openTag('li');
    echo CHtml::encode($category->name);
    $level=$category->level;
}

for ($i = $level; $i; $i--) {
            echo CHtml::closeTag('li') . "\n";
            echo CHtml::closeTag('ul') . "\n";
        }

}
public function getFullLink($cid){
$cat = Category::model()->findByPk($cid);
echo $cid;
$url = "";                    
                   if($cat->isRoot())  {
                   $url = Yii::app()->createUrl('profiles/list',array("category"=>$cat->id,"ctitle"=>$cat->name)); 
                     }
                   else{ 
                      $m = $cat;$catPath = array();
                      while(!$m->isRoot()){
                            $m->name = urlencode($m->name);$m->name = str_replace('+', '_', $m->name);
                            $catPath[$m->name] = $m->name;
                            $m = $m->parent;                  

                             }    $rev =   array_reverse($catPath); $catText = implode("/",$rev);

          
                         $encname = urlencode($cat->name);$encname =  str_replace('+', '_', $encname);

                         //!$url = "/categories/".$catText."/".$encname."/".$cat->id;
                         $url = "/categories/".$encname."/".$cat->id;
                       
                       }


 return $url;

}
public function getRelCategories($cid){

       $categs=Category::model()->findAll(array('condition'=>'root=:catID',
                       'params'=>array(':catID'=>$cid),			
                        //'order'=>'frequency DESC',
			//'limit'=>$this->maxLocs,
		       ));
       return( CHtml::listData($categs, CHtml::encode('id'), 'name'));

}

public function getCategoryName($id){
$cat = Category::model()->findByPk($id);
return $cat->name;
}

/**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggest($keyword,$limit=20)
	{         //$keyword = "eng";
		$models=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->name.' - '.$model->id,  // label for dropdown list
				'value'=>$model->name,  // value for input field
				'id'=>$model->id,       // return values from autocomplete
				//'code'=>$model->code,
				//'call_code'=>$model->call_code,
			);
		} //print_r($suggest);
		return $suggest;
	}
	
        
        
        
        public static function completeTerm($term,$exclude){
            
            $tags=$this->findAll(array(
			'condition'=>'name LIKE :term',
			
			'params'=>array(
				':name'=>'%'.strtr($term,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($tags as $tag)
			$names[]=$tag->name;
		return CJson::encode($names);
            
            
            
        }
/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{     // $link = $this->parent->link;
			      // if(!$link == null) $link = $link."/";
			       // $link = urlencode($this->link);
				//$this->link=$link.urlencode($this->name);
                                 $this->link='categories/'.urlencode($this->name);
				//$this->author_id=Yii::app()->user->id;
			}
			return true;
		}
		else
			return false;
	}
        
       /**
	 * get all parent id and names recursive in one dimensional array
	 * user mainly for breadcrump generation
	 *
	 * @param integer $_category_id
	 * @return array
	 */
	public function getParentRecursive( $_category_id )
	{
		$ret = array();
		$this->setAttribute('id', $_category_id);
		$this->refresh();
		if($parent = $this->lft){
			$ret[$parent->id] = $parent->name;
			if ($parent->lft){
				$ret += $this->getParentRecursive($parent->id);
			}
		}
		return $ret;
	}
        
}