<style>
.map_canvas img {
	max-width: none !important;
}

.map_canvas {
	margin-left: 20px;
	padding: 5px;
}

       
        </style>


    <div class="publish_section_header">  
        <h2><?=Yii::t('publish_page_v2', 'Location')?></h2>
    </div>
    
<div class="row-fluid">
	<div class="info_box">
					<div id="gmap_detail" style="width: 245px; "></div> 
    <fieldset id="_MAP_783" class="gllpLatlonPicker">
	
        <span>
                <div class="publish_label_conatiner">
                   <?php echo  CHtml::activeLabelEx($model,'ad_address');?>
		</div>
                <?php echo CHtml::activeTextField($model,'ad_address',array('class'=>'gllpSearchField gllpLocationName span10')); ?>
        </span>    
        <span><input class="gllpSearchButton" value="search" type="button"></span>      
	
        <div class="clear"></div>
	
           
	<div class="row" >
			<div class="gllpMap" >Google Maps</div>
		</div>
		<div class="row">
			<?php //echo CHtml::activelabelEx($model,$this->latitudeAttribute); ?>
			<?php echo CHtml::activeHiddenField($model,'ad_lat', array('class'=>'gllpLatitude')); ?>

			<?php //echo CHtml::activelabelEx($model,$this->longitudeAttribute); ?>
			<?php echo CHtml::activeHiddenField($model,'ad_lng', array('class'=>'gllpLongitude')); ?>
		
			<?php //echo CHtml::activelabelEx($model,$this->zoomAttribute); ?>
			<?php echo CHtml::activeHiddenField($model,'zoom', array('class'=>'gllpZoom')); ?>
		</div>
		 
     
   </fieldset>
</div>
 </div>   
 	