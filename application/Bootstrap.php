<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initView() {
        // Initialize view
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        //$view->headTitle($view->translate('Zend CMS'));
        //$view->setHelperPath(APPLICATION_PATH . '/views/helpers', 'View_Helper');
        $view->setHelperPath(APPLICATION_PATH . '/views/helpers', 'Application_View_Helper');
        //$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
        //$view->setLfiProtection(false);
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
                        'ViewRenderer'
        );
        $viewRenderer->setView($view);
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

    protected function _initLayoutHelper() {
        $this->bootstrap('frontController');
        $layout = Zend_Controller_Action_HelperBroker::addHelper(new Roshd_Controller_Action_Helper_LayoutLoader());
    }

    protected function _initRoutes() {
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $route = new Zend_Controller_Router_Route(
                        ':language/:layout/:module/:controller/:action/*',
                        array(
                            'language' => 'fa_IR',
                            'layout' => 'monasebat',
                            'module' => 'monasebat',
                            'controller' => 'indexindex',
                            'action' => 'index'
                        )
        );
        $router->addRoute('default', $route);
    }

    protected function _initTranslate() {
        // Get current registry
        $registry = Zend_Registry::getInstance();
        /**
         * Set application wide source Locale
         * This is usually your source string language;
         * i.e. $this->translate('Hi I am an English String');
         */
        $locale = new Zend_Locale('fa_IR');

        /**
         * Set up and load the translations (all of them!)
         * resources.translate.options.disableNotices = true
         * resources.translate.options.logUntranslated = true
         */
        #
        $translate = new Zend_Translate(
                        array(
                            'adapter' => 'gettext',
                            'content' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 'languages',
                            'scan' => Zend_Translate::LOCALE_DIRECTORY
                        )
        );
        /* $translate = new Zend_Translate('gettext', APPLICATION_PATH . DIRECTORY_SEPARATOR .'languages', 'auto',
          array(
          'disableNotices' => true,    // This is a very good idea!
          'logUntranslated' => false,  // Change this if you debug
          )
          ); */
        /**
         * Both of these registry keys are magical and makes
         * ZF 1.7+ do automagical things.
         */
        $registry->set('Zend_Locale', $locale);
        $registry->set('Zend_Translate', $translate);
        return $registry;
    }

    protected function _initAutoload() {
        // Add autoloader empty namespace
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $autoLoader->registerNamespace('Roshd_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
                    'basePath' => APPLICATION_PATH,
                    'namespace' => '',
                    'resourceTypes' => array(
                        'form' => array(
                            'path' => 'forms/',
                            'namespace' => 'Form_',
                        ),
                        'model' => array(
                            'path' => 'models/',
                            'namespace' => 'Model_'
                        ),
                    ),
                ));
        // Return it so that it can be stored by the bootstrap
        return $autoLoader;
    }

}
