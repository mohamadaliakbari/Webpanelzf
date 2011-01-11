<?php

class Hosting_OrderindexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexindex');
    }

    public function indexAction() {
	$model = new Hosting_Model_Order();
    }
}