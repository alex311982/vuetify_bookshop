<?php

class UserController extends BaseController{
    
	public function index(){
            
        $users = User::model()->findAll();
        $this->render("index", ["users"=> $users]);
        
	}
        
        public function update() {
            if(isset($_POST['submit1'])){     
                $users = User::model()->find($_POST['hidden']);
                $users->discount = $_POST['discount'];
                $users->save();
                header('Location: admin.php?c=user');
            }
            $editId = (isset($_GET['user_id'])) ? $_GET['user_id'] : 0;
            $user = User::model()->find($editId);

            $discounts = Discount::model()->findAll(["discount_type" => 2]);

            $this->render("update", ["user"=> $user, "discounts" => $discounts]);
        }
}


