<?php

class Monasebat_Model_Menu extends Zend_Db_Table_Abstract {

    protected $_name = 'menu';

    public function createMenu($title, $link, $place) {
        $row = $this->createRow();
        $row->title = $title;
        $row->link = $link;
        $row->place = $place;
        $id = $row->save();
        return $id;
    }

    public function fetchPaginatorAdapter() {
	$select = $this->select();
	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
	return $adapter;
    }

    public function updateMenu($id, $title, $link, $place) {
	$row = $this->find($id)->current();
	if ($row) {
            $row->title = $title;
            $row->link = $link;
            $row->place = $place;
            $row->save();
            return true;
	} else {
            die();
	    return false;
	}
    }

    public function deleteMenu($id) {
	$row = $this->find($id)->current();
	if ($row) {
	    $row->delete();
	    return true;
	} else {
	    return false;
	}
    }
    
    public function topMenu() {
        $select = $this->select();
        $select->where("place = 'top'");
	$select->order('id DESC')
               ->limit(1);
	return $this->fetchAll($select);
    }

    public function bottomMenu() {
        $select = $this->select();
        $select->where("place = 'bottom'");
	$select->order('id DESC')
               ->limit(1);
	return $this->fetchAll($select);
    }
}
?>