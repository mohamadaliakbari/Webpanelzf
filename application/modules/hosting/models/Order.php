<?php

class Hosting_Model_Order extends Zend_Db_Table_Abstract {

    protected $_name = 'hosting_order';

    public function create($owner_id, $plan_id, $domain, $tld, $ns1, $ns2, $ns3, $ns4, $register_date, $duration, $admin_panel_url, $username, $password, $cost) {
        $row = $this->createRow();
        $row->owner_id = $owner_id;
        $row->plan_id = $plan_id;
        $row->domain = $domain;
        $row->tld = $tld;
        $row->ns1 = $ns1;
        $row->ns2 = $ns2;
        $row->ns3 = $ns3;
        $row->ns4 = $ns4;
        $row->register_date = $register_date;
        $row->duration = $duration;
        $row->admin_panel_url = $admin_panel_url;
        $row->username = $username;
        $row->password = $password;
        $row->cost = $cost;
        $id = $row->save();
        return $id;
    }

    public function fetchPaginatorAdapter() {
        $select = $this->select();
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
    }

    public function edit($id, $owner_id, $plan_id, $domain, $tld, $ns1, $ns2, $ns3, $ns4, $register_date, $duration, $admin_panel_url, $username, $password, $cost) {
        $row = $this->find($id)->current();
        if ($row) {
            $row->owner_id = $owner_id;
            $row->plan_id = $plan_id;
            $row->domain = $domain;
            $row->tld = $tld;
            $row->ns1 = $ns1;
            $row->ns2 = $ns2;
            $row->ns3 = $ns3;
            $row->ns4 = $ns4;
            $row->register_date = $register_date;
            $row->duration = $duration;
            $row->admin_panel_url = $admin_panel_url;
            $row->username = $username;
            $row->password = $password;
            $row->cost = $cost;
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

}

?>