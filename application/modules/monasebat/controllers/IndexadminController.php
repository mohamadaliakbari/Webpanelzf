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

class Monasebat_IndexadminController extends Zend_Controller_Action {

    public function init() {
        $this->view->headLink()->appendStylesheet($this->view->baseUrl('sites/monasebat/style/admin.css'));
    }

    public function  preDispatch() {
        $this->_helper->layout->setLayout('indexadmin');
    }

    public function indexAction() {
        
    }

    public function topAction() {
        // action body
    }

    public function bottomAction() {
        // action body
    }
}