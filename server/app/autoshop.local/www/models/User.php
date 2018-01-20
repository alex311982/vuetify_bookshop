<?php

class User extends Models{
    
    public $id = 0;
    public $login;
    public $password;
    public $name;
    public $token;
    public $discount;

    public function getTableName(){
        return "user";
    }
    
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function findByToken($token){
        $sql = "select * from ".$this->getTableName()." u
                LEFT JOIN discount d ON(u.discount = d.discount_id) where token = ?";
        $sql = App::$db->prepare($sql);
        $sql->execute(array($token));
        $sqlResult = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sqlResult) {
            foreach ($sqlResult as $attr => $value) {
                $this->$attr = $value;
            }

            return $this;
        } else {
            return null;
        }
    }

    public function findByLogin($login){
            $sql = App::$db->prepare("select * from ".$this->getTableName()." where login = ?");
            $sql->execute(array($login));
            $sqlResult = $sql->fetch(PDO::FETCH_ASSOC);

                if ($sqlResult) {
                    foreach ($sqlResult as $attr => $value) {
                        $this->$attr = $value;
                    }

                    return $this;
                } else {
                    return null;
                }
    }

   public function generateToken($length = 15){
       $token = "";
       $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
       $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
       $codeAlphabet.= "0123456789";
       $max = strlen($codeAlphabet); // edited

       for ($i=0; $i < $length; $i++) {
           $token .= $codeAlphabet[$this->cryptoRrandSecure(0, $max-1)];
       }

       return $token;
   }

    private function cryptoRrandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    public function find($id){
        $sql = "select * from ".$this->getTableName()." where  id = ?";

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
        if(!empty($this->id)){
            $this->update();
        }else{
            return $this->insert();
        }
    }

    private function insert(){
        $sql = "insert into ".$this->getTableName();
        $fields = "";
        $values = "";
        $comma = 0;
        $sqlValues = [];
        foreach ($this as $attr => $value){
            if($attr != "id" && $attr != "db"){
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
        $sth = $this->db->prepare($sql);

        $result = $sth->execute($sqlValues);
        $this->find($this->db->lastId());
        return $result;
    }

    private function update(){
        $sql = "update ".$this->getTableName()." set ";
        $fields = "";
        $comma = 0;

        foreach ($this as $attr => $value){
            if($attr != "db"){
                if($comma != 0){
                    $fields .= ", ";
                }
                $fields .= $attr."='".$value."'";
                $comma++;
            }
        }
        $sql .= $fields." where id=".$this->id;
        $this->db->sqlQuery($sql);
    }

}
