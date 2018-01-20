<?php

abstract class Models{
    
    protected $db;
    private static  $_models = [];


    abstract public function getTableName();
    
    public function __construct(){
        $this->db = App::$db;
    }
    
    public static function model($className = __CLASS__){
        if(isset(self::$_models[$className])){
            return self::$_models[$className];
        }else{
            self::$_models[$className] = new $className();
            return self::$_models[$className];
        }
    }

    public function findAll($params = [], $orders = []){
        $sql = "select * from ".$this->getTableName();
        $dbParams = [];
        if(count($params) != 0){
            $where = " where ";
            $ind = 0;
            foreach ($params as $key => $val){
                if($ind != 0){
                    $where .= " and ";
                }
                $where .= $key . ' = ? ';
                $dbParams[] = $val;
                $ind++;
            }
            
            $sql .= $where;
        }
        
        if(count($orders) != 0){
            $order = " order by ";
            $ind = 0;
            foreach ($orders as $key => $val){
                if($ind != 0){
                    $order .= ", ";
                }
                $order .= $key." ".$val;
                $ind++;
            }
            $sql .= $order;
        }
        $sth = $this->db->prepare($sql);
        $sth->execute($dbParams);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
    public function find($id){
        $sql = "select * from ".$this->getTableName()." where ".$this->getTableName()."_id = ?";

        $sql = $this->db->prepare($sql);
        $sql->execute(array($id));
        $sqlResult = $sql->fetch(PDO::FETCH_ASSOC);

        if($sqlResult){
            foreach ($sqlResult as $attr => $value){
                $this->$attr = $value;
            }

            return $this;
        }else{
            return null;
        }
        
    }
    
    public function save(){
        $id = $this->getTableName()."_id";
        if(!empty($this->$id)){
            $this->update();
        }else{
            return $this->insert();
        }
    }
    
    
    private function update(){
        $sql = "update ".$this->getTableName()." set ";
        $fields = "";
        $comma = 0;

        foreach ($this as $attr => $value){

            //if( !in_array(gettype($value), ['boolean', 'integer', 'double', 'string'])) continue;

            if($attr != "db"){
                if($comma != 0){
                    $fields .= ", ";
                }
                $fields .= $attr."='".$value."'";
                $comma++;
            }
        }
        $id = $this->getTableName()."_id";
        $sql .= $fields." where ".$this->getTableName()."_id=".$this->$id;
        $this->db->sqlQuery($sql);
    }

    private function insert(){
        $sql = "insert into ".$this->getTableName();
        $fields = "";
        $values = "";
        $comma = 0;
        $sqlValues = [];
        foreach ($this as $attr => $value){
            if($attr != $this->getTableName()."_id" && $attr != "db"){
                if($comma != 0){
                    $fields .= ", ";
                    $values .= ", ";
                }
                $fields .= $attr;
                $values .= "?";
                $sqlValues[] = $value;
                $comma++;
            }
        }
        $sql = $sql." ($fields) values ($values)";
       //echo $sql;
        //print_r($sqlValues);
        $sth = $this->db->prepare($sql);
        $result = $sth->execute($sqlValues);
        //print_r($sth);
        //$this->id = $this->db->lastId();
        $this->find($this->db->lastId());
        return $result;
    }
    
    public function delete() {
        $sql = $this->db->prepare("DELETE FROM ".$this->getTableName()." where ".$this->getTableName()."_id = ?");
		
        $sql->execute(array($this->{$this->getTableName() . '_id'}));
    }

    
}