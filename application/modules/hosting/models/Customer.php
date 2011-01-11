<?php

class Hosting_Model_Customer extends Zend_Db_Table_Abstract {

    protected $_name = 'hosting_customer';

    public function create($firstname, $lastname, $email, $telephone, $mobile, $country, $state, $city, $address, $postal_code, $discount) {
        $row = $this->createRow();
        $row->firstname = $firstname;
        $row->lastname = $lastname;
        $row->email = $email;
        $row->telephone = $telephone;
        $row->mobile = $mobile;
        $row->country = $country;
        $row->state = $state;
        $row->city = $city;
        $row->address = $address;
        $row->postal_code = $postal_code;
        $row->discount = $discount;
        $id = $row->save();
        return $id;
    }

    public function fetchPaginatorAdapter() {
        $select = $this->select()->order('id DESC');
        $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
        return $adapter;
    }

    public function edit($id, $firstname, $lastname, $email, $telephone, $mobile, $country, $state, $city, $address, $postal_code, $discount) {
        $row = $this->find($id)->current();
        if ($row) {
            $row->firstname = $firstname;
            $row->lastname = $lastname;
            $row->email = $email;
            $row->telephone = $telephone;
            $row->mobile = $mobile;
            $row->country = $country;
            $row->state = $state;
            $row->city = $city;
            $row->address = $address;
            $row->postal_code = $postal_code;
            $row->discount = $discount;
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
        $select->from($this, array('id', 'firstname', 'lastname'))->order('id DESC');
        $result = $this->fetchAll($select);
        $resultArray = array();
        foreach ($result as $row) {
            $resultArray[$row['id']] = $row['firstname'].' '.$row['lastname'];
        }
        return $resultArray;
    }

}

?>