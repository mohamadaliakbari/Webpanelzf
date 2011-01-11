<?php

class Hosting_IndexindexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexindex');
    }

    public function indexAction() {
	$loader = Zend_Loader_Autoloader::getInstance();
        //die(print_r($loader->getAutoloaders()));
        $class = new Monasebat_Model_Ads();
        //$result = $class->fetchAll();
        //echo $result[0]->title;
        //exit();

        
    }
}