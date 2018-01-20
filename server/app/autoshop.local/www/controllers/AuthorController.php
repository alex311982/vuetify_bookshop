<?php

class AuthorController extends BaseController{
    
	public function index(){
            
        $author = Author::model()->findAll();            
        $this->render("index", ["author"=> $author]);
        
	}
        
        public function update() {
            if(isset($_POST['submit1'])){     
                $author = Author::model()->find($_POST['hidden']); 
                $author->author_name = $_POST['author'];
                $author->save();
                print_r($author);
                header('Location: admin.php?c=author');
            }
            $editId = (isset($_GET['author_id'])) ? $_GET['author_id'] : 0;
            $edits = new Author();
            $authors = $edits->find($editId);

            $result = [];
            
            foreach ($authors as $attr => $value){
                $result[$attr] = $value;
                
            }
            
            $this->render("update", ["author"=> $result]); 
        }
        
        public function delete() {
            
            if(isset($_GET['author_id'])){
            $author = Author::model()->find($_GET['author_id']); 
            $author->delete();
/*
            $sql = 'delete from author_book where author_id='.$_GET['author_id'];
            App::$db->query($sql);*/
           }
           header('Location: admin.php?c=author');
           
        }
        
        public function create() {
            
            if(isset($_POST['submit'])){ 
            $author = new Author();
            $author->author_name = $_POST['author'];
            $author->save();
            header('Location: admin.php?c=author');
            }
            $this->render("create", []);
        }
}


