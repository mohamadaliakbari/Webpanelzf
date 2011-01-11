<?php

class Monasebat_AdvertismentindexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexindex');
    }

    public function indexAction() {
	$advertismentmodel = new Monasebat_Model_Ads();
        $this->view->ads = $advertismentmodel->lastAds();
    }
}