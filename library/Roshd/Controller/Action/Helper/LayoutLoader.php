<?php
/**
 * Set defualt layout, this layout can be overwrited by controller to another layout
 */
class Roshd_Controller_Action_Helper_LayoutLoader extends Zend_Controller_Action_Helper_Abstract {

    /**
     * Set defualt layout, Final layout will be set by controller
     * Steps: (http://www.roshd.ir/fa_IR/layout/module/controller/action/)
     *  1- find $layout, $module, $controller
     *  2- search following:
     *      /modules/$module/views/layouts/$layout/$controller.phtml
     *      /modules/$module/views/layouts/$layout/indexindex.phtml
     *      /views/layouts/$layout/$controller.phtml
     *      /views/layouts/$layout/indexindex.phtml
     *      /views/layouts/defualt/$controller.phtml
     *      /views/layouts/defualt/indexindex.phtml
     *  3- save selected layout for this ($layout, $module, $controller) in cache
     */
    public function preDispatch() {
        $layout = strtolower($this->getRequest()->getParam('layout'));
        if($layout != '') {
            $module = strtolower($this->getRequest()->getModuleName());
            $controller = strtolower($this->getRequest()->getControllerName());
            $bootstrap = $this->getActionController()->getInvokeArg('bootstrap');
            $cache = $bootstrap->getResource('cache');
            $cacheKey = 'presetLayout_' . $layout . '_' . $module . '_' . $controller;
            $presetLayout = $cache->load($cacheKey);
            if (!$presetLayout) {
                $presetLayout = self::_findLayout($layout, $module, $controller);
                $cache->save($presetLayout, $cacheKey);
            }
            $this->getActionController()->getHelper('layout')->setLayoutPath($presetLayout[0]);
            $this->getActionController()->getHelper('layout')->setLayout($presetLayout[1]);
        }
    }

    /**
     * find layout in a inner multiplication of layoutPaths and layouts
     * @param <string> $layout
     * @param <string> $module
     * @param <string> $controller
     * @return <array> ($layoutPath, $layout)
     */
    protected function _findLayout($layout, $module, $controller) {
        $layoutPaths = array();
        $layouts = array($controller, 'indexindex', 'index');

        if (is_dir(APPLICATION_PATH . '/modules/' . $module . '/views/layouts/' . $layout . '/')) {
            $layoutPaths[] = APPLICATION_PATH . '/modules/' . $module . '/views/layouts/' . $layout . '/';
        }

        if (is_dir(APPLICATION_PATH . '/views/layouts/' . $layout . '/')) {
            $layoutPaths[] = APPLICATION_PATH . '/views/layouts/' . $layout . '/';
        }

        $layoutPaths[] = APPLICATION_PATH . '/views/layouts/default/';

        foreach ($layoutPaths as $layoutPath) {
            foreach ($layouts as $layout) {
                if (file_exists($layoutPath . $layout . '.phtml')) {
                    return array($layoutPath, $layout);
                }
            }
        }
    }
}