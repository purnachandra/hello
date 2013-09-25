<?php
class siteMap extends CAction{
    protected $controller;  

public function run() { 

      $controller = $this->getController();
      $controller->layout = 'main';
      $model_class = ucfirst($controller->getId());
      $controller->render('sitemap');

     }
  
} 
