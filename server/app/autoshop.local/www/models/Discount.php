<?php

class Discount extends Models{

    public $discount_id = 0;
    public $discount_name;
    public $discount_tax;
    public $discount_type;


    public function getTableName(){
        return "discount";
    }

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

}
