<?php

class Genre extends Models{
    
    public $genre_id = 0;
    public $genre_name;


    public function getTableName(){
        return "genre";
    }

    public function delete() {
        $sql = $this->db->prepare("DELETE FROM ".$this->getTableName()." where ".$this->getTableName()."_id = ?");

        $sql->execute(array($this->genre_id));

        $sql = 'delete from genre_book where genre_id='.$this->genre_id;
        App::$db->query($sql);

    }

    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    
}
