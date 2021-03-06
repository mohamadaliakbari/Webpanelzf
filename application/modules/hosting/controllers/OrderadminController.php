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
class Hosting_OrderadminController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function preDispatch() {
        $this->_helper->layout->setLayout('indexadmin');
    }

    public function actiondescriptionAction() {
        $actionName = $this->getRequest()->getParam('actionName');
        switch ($actionName) {
            case 'index':
                $this->view->msg = $this->view->translate('list of all Orders, Use functions icon to edit and delete plan');
                break;
            case 'add':
                $this->view->msg = $this->view->translate('Creating new Order');
                break;
            case 'edit':
                $this->view->msg = $this->view->translate('Edit exists Order');
                break;
            case 'delete':
                $this->view->msg = $this->view->translate('Delete Order');
                break;
        }
    }

    public function indexAction() {
        $model = new Hosting_Model_Order();
        $adapter = $model->fetchPaginatorAdapter();
        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $page = $this->_request->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function addAction() {
        $form = new Hosting_Form_Order();
        $form->setAction($this->view->url());
        $form->setMethod('post');
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $model = new Hosting_Model_Order();
                $result = $model->create($form->getValue('owner_id')
                                , $form->getValue('plan_id')
                                , $form->getValue('domain')
                                , $form->getValue('tld')
                                , $form->getValue('ns1')
                                , $form->getValue('ns2')
                                , $form->getValue('ns3')
                                , $form->getValue('ns4')
                                , $form->getValue('register_date')
                                , $form->getValue('duration')
                                , $form->getValue('admin_panel_url')
                                , $form->getValue('username')
                                , $form->getValue('password')
                                , $form->getValue('cost'));
                if ($result) {
                    $this->_redirect($this->view->url(array('action' => 'index')));
                }
            }
        }
        $this->view->form = $form;
    }

    public function editAction() {
        $form = new Hosting_Form_Order();
        $model = new Hosting_Model_Order();
        $form->setAction($this->view->url());
        $form->setMethod('post');
        $id = $this->_request->getParam('id');
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $result = $model->edit($id
                                , $form->getValue('owner_id')
                                , $form->getValue('plan_id')
                                , $form->getValue('domain')
                                , $form->getValue('tld')
                                , $form->getValue('ns1')
                                , $form->getValue('ns2')
                                , $form->getValue('ns3')
                                , $form->getValue('ns4')
                                , $form->getValue('register_date')
                                , $form->getValue('duration')
                                , $form->getValue('admin_panel_url')
                                , $form->getValue('username')
                                , $form->getValue('password')
                                , $form->getValue('cost'));
                if ($result) {
                    $this->_redirect($this->view->url(array('action' => 'index')));
                }
            }
        } else {
            $plan = $model->find($id)->current()->toArray();
            $form->populate($plan);
        }
        $this->view->form = $form;
    }

    public function deleteAction() {
        $accept = $this->_request->getParam('accept');
        if (isset($accept)) {
            if ($accept == TRUE) {
                $model = new Hosting_Model_Order();
                $id = $this->_request->getParam('id');
                $model->remove($id);
            }
            $params = $this->getRequest()->getParams();
            unset($params['accept']);
            unset($params['id']);
            $params['action'] = 'index';
            $this->_redirect($this->view->url($params, null, true));
        }
    }

}