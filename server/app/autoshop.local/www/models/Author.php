<?php

class Author extends Models{
    
    public $author_id = 0;
    public $author_name;


    public function getTableName(){
        return "author";
    }

    public function delete() {
        $sql = $this->db->prepare("DELETE FROM ".$this->getTableName()." where ".$this->getTableName()."_id = ?");

        $sql->execute(array($this->author_id));

        $sql = 'delete from author_book where author_id='.$this->author_id;
        App::$db->query($sql);

    }

    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    
}
