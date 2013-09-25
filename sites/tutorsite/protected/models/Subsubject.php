<?php



class Subsubject extends CActiveRecord
{



    public $gtext;
	/**
	 * The followings are the available columns in table 'subject':
	 * @var integer $id
	 * @var string $name
	 * @var string $text
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subsubjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name','length','max'=>255),
			array('id, name', 'required'),

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
			//subj' => array(self::BELONGS_TO, 'Subject', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',

		);
	}

           public function getSubSubjects($filter){
         //       $filter = $_POST['subject_id'];
         //  echo $filter;
         if($filter[2] == 'S')
            $filter = "SX";
          if($filter[2] == 'T')
            $filter = "CE";
            if($filter[2] == 'L')
            $filter = "LT";

        $subsubjects=

        Subsubject::model()->findAll(array(
			'condition'=>'id LIKE :filter',
			'order'=>'id',
			//'limit'=>$limit,

			'params'=>array(
				':filter'=>"$filter%",
			),
		));
            return $subsubjects;
             /* $data = CHtml::listData($data, CHtml::encode('id'), 'name');*/
            /*$subsubjects=$this->findAll(array(
			'condition'=>'id LIKE :filter',
			'order'=>'id',
			//'limit'=>$limit,

			'params'=>array(
				':filter'=>"$filter%",
			),
		));
           return $subsubjects;*/

          //    return( CHtml::listData($subsubjects, CHtml::encode('id'), 'name'));

        }
         public function getText(){
                      return $this->name;
                   }

      public function getSubjUrl()
    {  $link = null; $prms = array();
       if(Yii::app()->controller->id == 'jobs') {
                 $link = 'jobs/list';
                 $prms = array('jid'=>$this->id,'jtype'=>$this->name );
           }
       else if(Yii::app()->controller->id == 'cvs') {

               $link = 'cvs/list';  
               $prms = array(  'vid'=>$this->id,'vtype'=>$this->name,);
 
            }
        return Yii::app()->createUrl($link,$prms );
    }
}
