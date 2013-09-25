
                                
          <?php  echo CHtml::link($data->name, Yii::app()->createUrl('/ad/index', array('cattxt' => DCUtil::getSeoTitle($data->name), 'cid' => $data->id)),array('style'=>'font-size:10px;'));?>
      
            <?php //echo $data->name;?>                   