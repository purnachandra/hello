
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->view->pageTitle?></title>

<meta name="description" content="<?=$this->view->pageDescription?>" />
<meta name="keywords" content="<?=$this->view->pageKeywords?>" />
<meta name="robots" content="index , follow" />
<meta name="googlebot" content="noindex , nofollow" />
<meta name="rating" content="general" />


<?php

		$cs = Yii::app()->clientScript;
		//$cs->registerCoreScript('jquery');
		$cs->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyDUPhG1gc0pREJzCzAhrBhqVtJK1enVbWk&sensor=false');
		
		
                ?>
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->baseUrl; ?>/public/css/jquery-gmaps-latlon-picker.css" media="screen, projection" />

<script src="<?php echo Yii::app()->baseUrl; ?>/public/js/jquery-gmaps-latlon-picker.js"></script>

</head>
<body>
<?php echo $content;?>
</body>
</html>
