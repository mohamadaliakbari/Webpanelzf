<?php
/**
 * Roshd Network
 *
 * LICENSE
 *
 * This source file is subject to Roshd Public License that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.roshd.ir/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@roshd.ir so we can send you a copy immediately.
 *
 * @category   Zend
 * @package
 * @copyright  Copyright (c) 2005-2011 Roshd Network (http://www.roshd.ir)
 * @license    http://www.roshd.ir/license     Roshd Public License
 * @version    $Id:
 * @
 */

class Monasebat_AdvertismentadminController extends Zend_Controller_Action {

    public function init() {
        $this->view->headLink()->appendStylesheet($this->view->baseUrl('sites/monasebat/style/admin.css'));
        $this->view->headLink()->appendStylesheet($this->view->baseUrl('sites/monasebat/style/admin-advertisment.css'));
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexadmin');
    }

    public function indexAction() {
        $advertismentlist = new Monasebat_Model_Ads();
	$adapter = $advertismentlist->fetchPaginatorAdapter();
	$paginator = new Zend_Paginator($adapter);
	$paginator->setItemCountPerPage(10);
	$page = $this->_request->getParam('page', 1);
	$paginator->setCurrentPageNumber($page);
	$this->view->paginator = $paginator;
    }

    public function addAction() {
        $advertismentform = new Monasebat_Form_Ads();
        $advertismentform->setAction($this->view->url());
        $advertismentform->setMethod('post');
        if ($this->getRequest()->isPost()) {
            if ($advertismentform->isValid($_POST)) {
                $fileNames = $this->view->upload('./files/monasebat.com/ads');
                $advertismentmodel = new Monasebat_Model_Ads();
                $result = $advertismentmodel->createAds( $advertismentform->getValue('title')
                                                       , $advertismentform->getValue('describe')
                                                       , $advertismentform->getValue('link')
                                                       , $fileNames[0]);
                if ($result) {
                    $this->_redirect($this->view->url(array('action' => 'index')));
                }
            }
        }
        $this->view->advertismentform = $advertismentform;
    }

    public function editAction() {
        $advertismentmodel = new Monasebat_Model_Ads();
	$advertismentform = new Monasebat_Form_Ads();
	$advertismentform->setAction($this->view->url());
	$advertismentform->setMethod('post');
	$id = $this->_request->getParam('id');
	if ($this->getRequest()->isPost()) {
	    if ($advertismentform->isValid($_POST)) {
                $fileNames = $this->view->upload('./files/monasebat.com/ads');
		$result = $advertismentmodel->updateAds( $id
                                                       , $advertismentform->getValue('title')
                                                       , $advertismentform->getValue('describe')
                                                       , $advertismentform->getValue('link')
                                                       , $fileNames[0]);
		$this->_redirect($this->view->url(array('action' => 'index')));
	    }
	} else {
	    $ads = $advertismentmodel->find($id)->current();
	    $advertismentform->populate($ads->toArray());
	}
	$this->view->advertismentform = $advertismentform;
    }

    public function deleteAction() {
        $accept = $this->_request->getParam('accept');
        if (isset ($accept)) {
            if($accept == TRUE) {
                $advertismentmodel = new Monasebat_Model_Ads();
                $id = $this->_request->getParam('id');
                $advertismentmodel->deleteAds($id);
            }
            $this->_redirect($this->view->url(array('action' => 'index')));
        }
    }
}