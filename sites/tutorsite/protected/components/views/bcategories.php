  <?php 

   $bcrumbs[] = $this->end;                            

  $this->widget('application.extensions.exbreadcrumbs.EXBreadcrumbs', 
  array(
  //'htmlOptions'=>array('class'=>'breadcrumbs breadcrumb'),
   // 'cssFile' =>  '/themes/redmond/css/styleSample.css',
    'links'=>$this->bcrumbs
    
    
    /*arrray(
        'crumb1' => array('controller/route1','param1'=>'value1',
            'menu'=>array(
                'menu1'=> array('controller/routeMenu1','paramM1' => 'valueM1'),
                'menu2'=> array('controller/routeMenu2','paramM2' => 'valueM2'),
            )
        ),    
        'crumb2' => array('controller/route2','param2'=>'value2'),
        'google' => 'http://www.google.fr',
        'end'
    ),*/
));


?>


 
  






