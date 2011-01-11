<?php

class Monasebat_Model_Ads extends Zend_Db_Table_Abstract {

    protected $_name = 'ads';

    public function createAds($title, $describe, $link, $image) {
        $row = $this->createRow();
        $row->title = $title;
        $row->describe = $describe;
        $row->link = $link;
        $row->image = $image;
        $id = $row->save();
        return $id;
    }

    public function fetchPaginatorAdapter() {
	$select = $this->select();
	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
	return $adapter;
    }

    public function updateAds($id, $title, $describe, $link, $image) {
	$row = $this->find($id)->current();
	if ($row) {
            $row->title = $title;
            $row->describe = $describe;
            $row->link = $link;
            $row->image = $image;
            $row->save();
            return true;
	} else {
            die();
	    return false;
	}
    }

    public function deleteAds($id) {
	$row = $this->find($id)->current();
	if ($row) {
	    $row->delete();
	    return true;
	} else {
	    return false;
	}
    }

    public function lastAds() {
        $select = $this->select();
	$select->order('id DESC')
               ->limit(1);
	return $this->fetchAll($select)->current()->toArray();
    }
}
?>