<?php

class GenreController extends BaseController{
    
	public function index(){
            
            $genres = Genre::model()->findAll();
            
		$this->render("index", ["genre"=> $genres]);
	}
                
        public function update() {

            if(isset($_POST['submit1'])){     
                $genre = Genre::model()->find($_POST['hidden']); 
                $genre->genre_name = $_POST['genre'];
                $genre->save();
                header('Location: admin.php?c=genre');
            }
            
            $editId = (isset($_GET['genre_id'])) ? $_GET['genre_id'] : 0;
            $edits = new Genre();
            $genre = $edits->find($editId);
            $result = [];
            
            foreach ($genre as $attr => $value){
                $result[$attr] = $value;
            }
            $this->render("update", ["genre"=> $result]); 
        
        }
        
        
        public function delete() {
            
           if(isset($_GET['genre_id'])){
            $delete = Genre::model()->find($_GET['genre_id']); 
            $delete->delete();
            
            $sql = 'delete from genre_book where genre_id='.$_GET['genre_id'];
            App::$db->query($sql);
           }
           header('Location: admin.php?c=genre');
            
        }
        
        public function create() {
            
            if(isset($_POST['submit'])){ 
            $genre = new Genre();
            $genre->genre_name = $_POST['genre'];
            
            $genre->save();
            header('Location: admin.php?c=genre');
            }
            $this->render("create", []);
            
        }
}


