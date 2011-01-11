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

class Monasebat_MenuadminController extends Zend_Controller_Action {

    public function init() {
        $this->view->headLink()->appendStylesheet($this->view->baseUrl('sites/monasebat/style/admin.css'));
        $this->view->headLink()->appendStylesheet($this->view->baseUrl('sites/monasebat/style/admin-menu.css'));
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexadmin');
    }

    public function indexAction() {
        $menulist = new Monasebat_Model_Menu();
	$adapter = $menulist->fetchPaginatorAdapter();
	$paginator = new Zend_Paginator($adapter);
	$paginator->setItemCountPerPage(10);
	$page = $this->_request->getParam('page', 1);
	$paginator->setCurrentPageNumber($page);
	$this->view->paginator = $paginator;
    }

    public function addAction() {
        $menuform = new Monasebat_Form_Menu();
        $menuform->setAction($this->view->url());
        $menuform->setMethod('post');
        if ($this->getRequest()->isPost()) {
            if ($menuform->isValid($_POST)) {
                $menumodel = new Monasebat_Model_Menu();
                $result = $menumodel->createMenu( $menuform->getValue('title')
                                                , $menuform->getValue('link')
                                                , $menuform->getValue('place'));
                if ($result) {
                    $this->_redirect($this->view->url(array('action' => 'index')));
                }
            }
        }
        $this->view->menuform = $menuform;
    }

    public function editAction() {
        $menumodel = new Monasebat_Model_Menu();
	$menuform = new Monasebat_Form_Menu();
	$menuform->setAction($this->view->url());
	$menuform->setMethod('post');
	$id = $this->_request->getParam('id');
	if ($this->getRequest()->isPost()) {
	    if ($menuform->isValid($_POST)) {
		$result = $menumodel->updateMenu( $id
                                                       , $menuform->getValue('title')
                                                       , $menuform->getValue('link')
                                                       , $menuform->getValue('place'));
		$this->_redirect($this->view->url(array('action' => 'index')));
	    }
	} else {
	    $Menu = $menumodel->find($id)->current();
	    $menuform->populate($Menu->toArray());
	}
	$this->view->menuform = $menuform;
    }

    public function deleteAction() {
        $accept = $this->_request->getParam('accept');
        if (isset ($accept)) {
            if($accept == TRUE) {
                $menumodel = new Monasebat_Model_Menu();
                $id = $this->_request->getParam('id');
                $menumodel->deleteMenu($id);
            }
            $this->_redirect($this->view->url(array('action' => 'index')));
        }
    }
}