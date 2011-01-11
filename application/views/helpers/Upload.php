<?php
class Application_View_Helper_Upload extends Zend_View_Helper_Abstract {
    public function upload($uploadDir) {
        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->setDestination($uploadDir);
        $files = $upload->getFileInfo();
        $i = 0;
        foreach ($upload->getFileInfo() as $info) {
            $extension = pathinfo(($info['name']), PATHINFO_EXTENSION);
            $fileNames[$i] = 'file' . $i . time() . "." . $extension;
            $upload->addFilter('Rename', array('target' => $uploadDir . DIRECTORY_SEPARATOR . $fileNames[$i], 'overwrite' => true));
            $upload->receive($info['name']);
            $i++;
        }
        return $fileNames;
    }
}