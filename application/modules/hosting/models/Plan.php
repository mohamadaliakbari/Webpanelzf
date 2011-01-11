<?php

class Hosting_Model_Plan extends Zend_Db_Table_Abstract {

    protected $_name = 'hosting_plan';

    public function create($name, $qouta, $bandwidth, $reseller, $cost_per_month) {
        $row = $this->createRow();
        $row->name = $name;
        $row->qouta = $qouta;
        $row->bandwidth = $bandwidth;
        $row->reseller = $reseller;
        $row->cost_per_month = $cost_per_month;
        $id = $row->save();
        return $id;
    }

    public function fetchPaginatorAdapter() {
        $select = $this->select()->order('ID DESC');
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
    }

    public function edit($id, $name, $qouta, $bandwidth, $reseller, $cost_per_month) {
        $row = $this->find($id)->current();
        if ($row) {
            $row->name = $name;
            $row->qouta = $qouta;
            $row->bandwidth = $bandwidth;
            $row->reseller = $reseller;
            $row->cost_per_month = $cost_per_month;
            $row->save();
            return true;
        }
    }

    public function remove($id) {
        $row = $this->find($id)->current();
        if ($row) {
            $row->delete();
            return true;
        } else {
            return false;
        }
    }

    public function pairOptions() {
        $select = $this->select();
        $select->from($this, array('id', 'name'))->order('id DESC');
        $result = $this->fetchAll($select);
        $resultArray = array();
        foreach ($result as $row) {
            $resultArray[$row['id']] = $row['name'];
        }
        return $resultArray;
    }

}

?>