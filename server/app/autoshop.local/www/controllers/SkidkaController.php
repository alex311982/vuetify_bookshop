<?php

class SkidkaController extends BaseController{

    public function index(){

        $skidki = Discount::model()->findAll();

        $this->render("index", ['discount' => $skidki]);

    }

    public function create(){

        if(isset($_POST['submit'])){
            $discount = new Discount();
            $discount->discount_name = $_POST['name'];
            $discount->discount_tax = $_POST['tax'];
            $discount->discount_type = $_POST['type'];
            $discount->save();
            header('Location: admin.php?c=skidka');
        }
        $this->render("create", []);
    }

    public function update() {

        if(isset($_POST['submit'])){
            $discount = Discount::model()->find($_POST['hidden']);
            $discount->discount_name = $_POST['name'];
            $discount->discount_tax = $_POST['tax'];
            $discount->discount_type = $_POST['type'];
            $discount->save();
            header('Location: admin.php?c=skidka');
        }
        $editId = (isset($_GET['discount_id'])) ? $_GET['discount_id'] : 0;
        $edits = new Discount();
        $discount = $edits->find($editId);

        $result = [];

        foreach ($discount as $attr => $value){
            $result[$attr] = $value;

        }

        $this->render("update", ["discount"=> $result]);
    }

    public function delete() {

        if(isset($_GET['discount_id'])){
            $discount = Discount::model()->find($_GET['discount_id']);
            $discount->delete();

           /* $sql = 'delete from discount where discount_id='.$_GET['discount_id'];
            App::$db->query($sql);*/
        }
        header('Location: admin.php?c=skidka');

    }

}
