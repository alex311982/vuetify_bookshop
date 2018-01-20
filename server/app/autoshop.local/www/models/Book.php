<?php

class Book extends Models{
    
    public $book_id = 0;
    public $book_name;
    public $book_description;
    public $book_price;
    public $book_discount_id;

    public function getTableName(){
        return "book";
    }

    public function findAll($params = [], $orders = []){
      $q = "select * from book b LEFT JOIN discount d ON(b.book_discount_id = d.discount_id)";
      $books = App::$db->select($q);
      foreach ($books as $key=>$value){
          $sql = '
          select genre.* 
          from genre_book 
          left join genre on genre_book.genre_id = genre.genre_id 
          where genre_book.book_id='.$value['book_id'];
          $genres = App::$db->select($sql);
          $genreIds = [];
          foreach ($genres as $genre) {
              $genreIds[] = $genre['genre_id'];
          }
          $books[$key]["genres"] = $genreIds;

          $sql = '
          select author.* 
          from author_book 
          left join author on author_book.author_id = author.author_id 
          where author_book.book_id='.$value['book_id'];

          $authors = App::$db->select($sql);
          $authorIds = [];
          foreach ($authors as $author) {
              $authorIds[] = $author['author_id'];
          }

          $books[$key]["authors"] = $authorIds;

      }
        return $books;
    }

    public function findById($id)
    {
      $q = "select * from book b LEFT JOIN discount d ON(b.book_discount_id = d.discount_id) WHERE book_id = $id";
      $book = (object)App::$db->select($q)[0];
        $sql = '
          select genre.* 
          from genre_book 
          left join genre on genre_book.genre_id = genre.genre_id 
          where genre_book.book_id='.$id;
        $genres = App::$db->select($sql);
        $book->genres = $genres;
        $sql = '
          select author.* 
          from author_book 
          left join author on author_book.author_id = author.author_id 
          where author_book.book_id='.$id;

        $authors = App::$db->select($sql);
        $book->authors = $authors;
        return $book;
    }

    public static function findByAttributes($params) {
        $genres = [];
        $authors = [];
        $b = [];
        $a = [];
        if (isset($params['genre'])){
        $sql = 'select * from genre_book where genre_id='.$params['genre'];
        $genres = App::$db->select($sql);
            foreach ($genres as $value) {
                $book = Book::model()->find($value['book_id']);
                if($book){
                $b[$book->book_id] = [
                    "book_id" => $book->book_id,
                    "book_name" => $book->book_name,
                ];
                }
            }   
        }

        if(isset($params["author"])){
        $sql = 'select * from author_book where author_id='.$params['author'];
        $authors = App::$db->select($sql);
            foreach ($authors as $value) {
                $book = Book::model()->find($value['book_id']);
                if($book){
                $a[$book->book_id] = [
                    "book_id" => $book->book_id,
                    "book_name" => $book->book_name,
                ];
                }
            }
        }


        if(sizeof($a) != 0 && sizeof($b) != 0){

            $result = array_uintersect_uassoc($a, $b, function(){}, "strcasecmp");
        }  elseif (sizeof($a) == 0 && sizeof($b) != 0){
                $result = $b;
        }  elseif (sizeof($b) == 0 && sizeof($a) != 0){
                $result = $a;
        }else{
            if(isset($params["author"]) || isset($params['genre'])){
                $result =[];
            }else {
                $result = self::model()->findAll();
            }
        }
        return $result;
        
    }

    public function saveAuthors($authors) {

        $sql = "delete from author_book where book_id = " . $this->book_id;
        $this->db->sqlQuery($sql);

        $sqlauth = '(' . implode(", {$this->book_id}), (", $authors) . ", {$this->book_id})";
        $sql = "insert into author_book VALUES $sqlauth";

        $this->db->sqlQuery($sql);

    }

    public function saveGenres($genres) {

        $sql = "delete from genre_book where book_id = " . $this->book_id;
        $this->db->sqlQuery($sql);

        $sqlgenres = '(' . implode(", {$this->book_id}), (", $genres) . ", {$this->book_id})";
        $sql = "insert into genre_book VALUES $sqlgenres";
        $this->db->sqlQuery($sql);

    }

    public function delete() {
        $sql = $this->db->prepare("DELETE FROM ".$this->getTableName()." where ".$this->getTableName()."_id = ?");

        $sql->execute(array($this->book_id));

        $sql = 'delete from genre_book where book_id='.$this->book_id;
        App::$db->query($sql);

        $sql = 'delete from author_book where book_id='.$this->book_id;
        App::$db->query($sql);

    }

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

}
