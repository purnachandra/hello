<style>
      .map_canvas img {
	 max-width: none !important;
       }
     
</style>

  


	<div class="info_box">
		
    <fieldset id="_MAP_783" class="gllpLatlonPicker">
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'pick-form',
	'action' => array("/ad/postAd",array('step'=>'location')),
	               )); ?>

        <span>
                <div class="publish_label_conatiner">
                   <?php echo  CHtml::activeLabelEx($model,'ad_address');?>
		</div>
                <?php echo $form->textField($model,'location',array('value'=>'Hyderabad, India','class'=>'gllpSearchField gllpLocationName','style'=>"width:318px;")); ?>
        </span>    
        <span><input class="gllpSearchButton" value="search" type="button"></span>
	
	<?php //echo CHtml::activelabelEx($model,$this->latitudeAttribute); ?>
			<?php echo $form->hiddenField($model,'ad_lat', array('class'=>'gllpLatitude')); ?>

			<?php //echo CHtml::activelabelEx($model,$this->longitudeAttribute); ?>
			<?php echo $form->hiddenField($model,'ad_lng', array('class'=>'gllpLongitude')); ?>
			
	 <?php
	 
	 
	 echo CHtml::ajaxLink('Yes this is my location', '', array(
				//'dataType'=>'json',
                                //'type'=>'post',
				'success'=> "function(data){ // alert('bahot satara');
					  $('div.addrselect', $(parent.document)).html($('#Ad_location').clone(true)); 
		       	         	  $('div.lngselect', $(parent.document)).html($('#Ad_ad_lng').clone(true));
					  $('div.latselect', $(parent.document)).html($('#Ad_ad_lat').clone(true));
		        		   parent.jQuery.fancybox.close();
                                               }"
				 ),
				 array('id'=>'location_ok-'.uniqid(),'target'=>"_parent","class" => "btn btn-primary pull-left")     
				      
				      );
	
	/* $this->widget('bootstrap.widgets.TbButton',
		array(
                     'buttonType' => 'ajaxLink',
		     'url' => array('/ad/publish'),
                     'label' => 'Yes, this is my location', 
                     'htmlOptions'=>array('id'=>'location_ok','target'=>"_parent","class" => "btn btn-primary pull-left"),
                     'ajaxOptions' => array(
				'dataType'=>'json',
                                'type'=>'post',
				'success'=> "function(data){  alert('bahot satara');
					  $('div.addrselect', $(parent.document)).html($('#Ad_location').clone(true)); 
		       	         	  $('div.lngselect', $(parent.document)).html($('#Ad_ad_lng').clone(true));
					  $('div.latselect', $(parent.document)).html($('#Ad_ad_lat').clone(true));
		        		   parent.jQuery.fancybox.close();
                                               }"
				 ),
          ));*/ ?>
	 
        <div class="clear"></div>
	
<?php $this->endWidget(); ?>
 
	
		
		
			<?php //echo CHtml::activelabelEx($model,$this->zoomAttribute); ?>
			<?php echo CHtml::activeHiddenField($model,'zoom', array('class'=>'gllpZoom')); ?>
		
		<div class="row" style="padding:3px;">
			<div class="gllpMap" >Google Maps</div>
	</div> 
     
   </fieldset>
</div>
 
 