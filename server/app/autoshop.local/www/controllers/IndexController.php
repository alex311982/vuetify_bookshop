<?php
class IndexController extends BaseController{
	public function index(){  
            $genres = Genre::model()->findAll();
            $authors = Author::model()->findAll();
            
            $params = [];
            $post_genre ='';
            $post_author = '';
            if(sizeof($_POST) != 0){
                
                if (isset($_POST['genres']) && $_POST['genres'] != ''){
                    $post_genre = $_POST['genres'];
                  $params["genre"] = $_POST['genres'];
                } 

                if (isset($_POST['authors']) && $_POST['authors'] != ''){
                    $post_author = $_POST['authors'];
                   $params["author"] = $_POST['authors'];
                   
                }
                $books  =  Book::model()->findByAttributes($params);
            } else {
                $books = Book::model()->findAll();
            }
            $this->render("index", ['genre'=>$genres,'author'=>$authors,
                'book'=>$books,'post_genre'=>$post_genre,'post_author'=>$post_author]);
	}
        
        public function view() {
            $form = [
                //'login' => ['lable' => 'Login','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели login!'],
                //'password' => ['lable' => 'Password','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели password!'],

                'name' => [
                    'lable' => 'Имя',
                    'type' => 'text',
                    'value' => '',
                    'error' => false,
                    'visible' => true,
                    'errorText' => 'не ввели имя!'
                    ],
                'family_name' => [
                    'lable' => 'Фамилия',
                    'type' => 'text',
                    'value' => '',
                    'error' => false,
                    'visible' => true,
                    'errorText' => 'не ввели фамилию!'
                    ],
                'addres' => [
                    'lable' => 'адрес',
                    'type' => 'text',
                    'value' => '',
                    'error' => false,
                    'visible' => true,
                    'errorText' => 'не ввели адрес!'
                    ],
                'count' => [
                    'lable' => 'Количество',
                    'type' => 'number',
                    'value' => 1,
                    'error' => false,
                    'visible' => true,
                    'errorText' => 'не ввели количество!'
                    ],
           
            ];
            if (isset($_GET['id'])){
                $book = Book::model()->find($_GET['id']);
                $res_book['name'] = $book->book_name;
                $res_book['description'] = $book->book_description;
                $res_book['price'] = $book->book_price;
                $discount = Discount::model()->find($book->book_discount_id);
                $res_book['discountCost'] = round($book->book_price * $discount->discount_tax / 100, 2);
                $res_book['id'] = $book->book_id;
                $sql = 'select * from genre_book where book_id = '.$book->book_id;
                $genres = App::$db->select($sql);
                
                $all_genre = [];
                $all_author = [];
                
                    foreach ($genres as $genre) {
                        $res_genre = Genre::model()->find($genre['genre_id']);
                        $all_genre[] = $res_genre->genre_name;
                    }
                
                $sql = 'select * from author_book where book_id = '.$book->book_id;
                $authors = App::$db->select($sql);
                
                    foreach ($authors as $author) {
                        $res_author = Author::model()->find($author['author_id']);
                        $all_author[] = $res_author->author_name;
                    }
                
                if(isset($_POST['submit'])){
                    foreach ($_POST as $key => $value) {
                        if(isset($form[$key]) ){
                        if($value == ""){
                            $error = TRUE;
                        }  else {
                            $error = FALSE;
                        }
                        $form[$key]['value'] = $value;
                        $form[$key]['error'] = $error;   
                        }
                    }
                }
                $this->render('view',[
                    'form' => $form, 
                    'id'=> $_GET['id'], 
                    'book'=>$res_book,
                    'genre'=>$all_genre,
                    'author'=>$all_author
                        ]); 
            }
        }
        
        public function order() {
            
            $form = [
                //'login' => ['lable' => 'Login','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели login!'],
                //'password' => ['lable' => 'Password','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели password!'],

                'name' => ['lable' => 'Имя','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели имя!'],
                'family_name' => ['lable' => 'Фамилия','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели фамилию!'],
                'addres' => ['lable' => 'адрес','value' => '','type' => 'text','error' => false,'errorText' => 'не ввели адрес!'],
                'count' => ['lable' => 'количество','value' => 1,'type' => 'number','error' => false,'errorText' => 'не ввели количество!']
            ];
            if(isset($_POST['submit'])){
                
            $error = FALSE;
            
                foreach ($_POST as $key => $value) {

                    if($value == ""){
                        $error = TRUE; 
                        if(isset($form[$key])){
                            $form[$key]['error'] = $error;    
                        }
                    }
                    if(isset($form[$key])){
                        $form[$key]['value'] = $value;
                   }                      
                }
                if($error == FALSE){
            $orders = new Order();
            $orders->order_book_id = $_POST['book_id'];
            $orders->order_addres = $_POST['addres'];
            $orders->order_fio = $_POST['name']." ".$_POST['family_name'];
            $orders->order_count = $_POST['count'];
            $orders->order_status = 0;
            $orders->save();
            
            $res_book = Book::model()->find($orders->order_book_id);
            $sql = 'select * from author_book where book_id='.$orders->order_book_id;
            $authors = App::$db->select($sql);

            $book_author = [];
                foreach ($authors as $v) {
                    $author = Author::model()->find($v['author_id']);
                    $book_author[] = $author->author_name;
                }
            $sql = 'select * from genre_book where book_id='.$orders->order_book_id;
            $genres  = App::$db->select($sql);
            
            $genre_name = [];
                foreach ($genres as $value) {
                    $genre = Genre::model()->find($value['genre_id']);
                    $genre_name[] = $genre->genre_name;
                }
                
            $header = [];
            $mesage = 'Новый заказ \n ';
            $mesage.='книга '.$res_book->book_name.'\n ';
            $mesage.='автор '.implode(',', $book_author).'\n ';
            $mesage.='жанр '.implode(',', $genre_name).'\n ';
            $mesage.='количество '.$orders->order_count.'\n ';
            $body ='ФИО '.substr(htmlspecialchars(trim($orders->order_fio)), 0, 1000)."\n";
            $body.='адресс '.substr(htmlspecialchars(trim($orders->order_addres)), 0, 1000)." ";
            $to = 'Nikolaev.ua@gmail.com';
            //$sendaddress = mail($to,$mesage,'ЗАКАЗЧИК \n'."$body Content-type: text/plain; charset='utf-8'" );
            $sendaddress = true;
            if($sendaddress =="true"){
                    echo '<font color="green"><h2>Спасибо!<br />Ваш заказ оформлен.</h2></font>';
                    echo '<form action = "index.php" method = "post">';
                    echo '<input type = submit value = "НАЗАД">';
                    echo '</form>';
                    }else {
                    echo '<font color="red">Ваш заказ не оформлен!</font>';
                    }
                    exit();
                }
            }
            
            $book = Book::model()->find($_GET['id']);
                $rbook['name'] = $book->book_name;
                $rbook['description'] = $book->book_description;
                $rbook['price'] = $book->book_price;;
                $rbook['discount'] = $book->book_discount_id;
                $rbook['id'] = $book->book_id;
                
                $sql = 'select * from genre_book where book_id = '.$book->book_id;
                $genres = App::$db->select($sql);
                
                $all_genre = [];
                $all_author = [];
                    foreach ($genres as $genre) {
                        $res_genre = Genre::model()->find($genre['genre_id']);
                        $all_genre[] = $res_genre->genre_name;
                    }
                
                $sql = 'select * from author_book where book_id = '.$book->book_id;
                $authors = App::$db->select($sql);
                
                    foreach ($authors as $author) {
                        $res_author = Author::model()->find($author['author_id']);
                        $all_author[] = $res_author->author_name;
                    }

            $this->render('view',[
                    'form' => $form, 
                    'id'=> $_GET['id'], 
                    'book'=>$rbook,
                    'genre'=>$all_genre,
                    'author'=>$all_author
                        ]); 
        }

}


