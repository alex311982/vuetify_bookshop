<?php

class BookController extends BaseController{
    
	public function index(){
            
        $books = Book::model()->findAll();

        foreach ($books as $key => $value) {
            $sql = 'select * from author_book where book_id='.$value['book_id'];
            $authors = App::$db->select($sql);
            $book_author = [];

                foreach ($authors as $v) {
                    $author = Author::model()->find($v['author_id']);
                    $book_author[] = $author->author_name;
                }

            $books[$key]["book_author"] = implode(",", $book_author);
            
            $sql = 'select * from genre_book where book_id='.$value['book_id'];
            $genres = App::$db->select($sql);
            $book_genre = [];
            
            foreach ($genres as $v) {
                $genre = Genre::model()->find($v['genre_id']);
                $book_genre[] = $genre->genre_name;
            }
            $books[$key]["book_genre"] = implode(",", $book_genre);

            $sql = 'select * from discount where discount_id='.$value['book_discount_id'];
            $discount = App::$db->select($sql, true);

            $books[$key]["book_discount"] = (sizeof($discount)) ? $discount["discount_name"] : " no discount";
//            $book_discount = [];
//
//            foreach ($discounts as $v){
//                $discount = Discount::model()-find($v['discount_id']);
//                $book_discount[]=$discount->discount_name;
//            }
//            $books[$key]["discount_name"] = implode(",",$book_discount);
        }
        //var_dump($books);
        $this->render("index", ["book"=> $books]);

	}
                
        public function update() {
            
            if(isset($_POST['submit'])){     
                $book = Book::model()->find($_POST['hidden']); 
                $book->book_name = $_POST['book'];
                $book->book_description = $_POST['book_description'];
                $book->book_price = $_POST['book_price'];
                $book->book_discount_id = $_POST["discount"];

                $book->save();

                $book->saveAuthors($_POST['author']);

                $book->saveGenres($_POST['genre']);
            
                header('Location: admin.php?c=book');
            }
            $editId = (isset($_GET['book_id'])) ? $_GET['book_id'] : 0;
            $edits = new Book();

            $books = $edits->find($editId);
            if ($books != NULL){
            $result = [];

            foreach ($books as $attr => $value){
                $result[$attr] = $value;
            }
            
            $book_genre = [];
            $sql = 'select * from genre_book where book_id='.$books->book_id;
            $genres = App::$db->select($sql);
            
            foreach ($genres as $v) {
                $book_genre[] = $v["genre_id"];
            }
            $result["book_genre"] = $book_genre;

            $sql = 'select * from discount where discount_type = 1';
            $discounts = App::$db->select($sql);

            $book_authors = [];
            $sql = 'select * from author_book where book_id='.$books->book_id;
            $authors = App::$db->select($sql);
            
            foreach ($authors as $v) {
                $book_authors[] = $v["author_id"];
            }
            $result["book_author"] = $book_authors;
            $genres = Genre::model()->findAll(); 
            $authors = Author::model()->findAll();
            $this->render("update", [
                "books"=> $result,
                "genres"=>$genres,
                "authors"=>$authors,
                "discount"=> $discounts
                ]);
            }  else {
                echo 'Такая книга не найдена !';
            }
        }
        
        public function delete() {
            
            if(isset($_GET['book_id'])){
                $book = Book::model()->find($_GET['book_id']);
                $book->delete();
            /*
            $sql = 'delete from book where book_id='.$_GET["book_id"];
            App::$db->query($sql);
            
            $sql = 'delete from genre_book where book_id='.$_GET["book_id"];
            App::$db->query($sql);
            
            $sql = 'delete from author_book where book_id='.$_GET["book_id"];
            App::$db->query($sql);
            */
            header('Location: admin.php');
            
           }            
        }
        
        public function create() {
            
            if (sizeof($_POST) !=0){
                if (!isset($_POST["genre"]) || sizeof($_POST["genre"]) == 0){
                    echo 'выберите жанр ';
                }elseif (!isset($_POST["author"]) || sizeof($_POST["author"]) == 0){
                    echo 'выберите автора ';
                }elseif ($_POST["name_book"] == '') {
                    echo 'выберите книгу ';
                }else{
                    $book = new Book();
                    $book->book_name = $_POST["name_book"];
                    $book->book_description = $_POST["description_book"];
                    $book->book_price = $_POST["price_book"];
                    $book->book_discount_id = $_POST["discount"];
                    $book->save();

                    $book->saveGenres($_POST['genre']);


                    $book->saveAuthors($_POST['author']);

                    header('Location: admin.php?c=book');
                }
            }
            $genres = Genre::model()->findAll(); 
            $authors = Author::model()->findAll();
            $discount = Discount::model()->findAll(["discount_type" => 1]);
            $this->render("create", ["genres"=>$genres,"authors"=>$authors,'discount'=>$discount]);
        }
}


