<?php

class Monasebat_menuindexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexindex');
    }

    public function indexAction() {
	
    }

    public function topAction() {
        $menumodel = new Monasebat_Model_Menu();
        $this->view->top = $menumodel->topMenu();
    }

    public function bottomAction() {
        $menumodel = new Monasebat_Model_Menu();
        $this->view->bottom = $menumodel->bottomMenu();
    }
}