<?php
class Order extends Models{

    public $orders_data;
    public $orders_client_id;
    public $orders_cost;
    public $orders_status;
    public $orders_id;



    public function getTableName(){
    return "orders";
    }
    
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public static function findOrder(User $user, $orderId){
        $order = self::model()->findAll(["orders_client_id" => $user->id, "orders_id" => $orderId]);

        if(isset($order[0])){
            $orderObj = new self; //Order
            foreach ($order[0] as $k => $v){
                $orderObj->$k = $v;
            }
            return $orderObj;
        }else{
            return null;
        }
    }

    public static function add($data, $user){
        try {
            $orderCost = 0;
            foreach ($data["book"] as $k => $item) {
                $book = Book::model()->find($item->id);
                $discount = Discount::model()->find($book->book_discount_id);
                $book_cost = $book->book_price - round($book->book_price *
                (!empty($discount->discount_tax)?$discount->discount_tax:0) / 100, 2);

                $orderCost += ($book_cost * $item->count);
            }

            $order = new self;
            $order->orders_client_id = $user->id;
            $order->orders_data = date("Y-m-d H:i:s", strtotime("now"));
            if($user->discount != 0) {
                $discount = Discount::model()->find($user->discount);
                $order->orders_cost = $orderCost - round($orderCost * $discount->discount_tax / 100, 2);
            }else{
                $order->orders_cost = $orderCost;
            }
            $order->orders_status = 1;

            if($order->save()) {

                foreach ($data["book"] as $k => $item) {
                    $sql = "insert into book_order (book_id, book_count, order_id) values ( ?, ?, ?)";
                    $sqlDb = App::$db->prepare($sql);
                    $result = $sqlDb->execute(array($item->id, $item->count, $order->orders_id));
                    if (!$result) {
                        throw new Exception('cannot add book to order');
                    }
                }
            }else{
                throw new Exception('cannot add order record');
            }
            return true;
        }catch (Exception $e){

            $sql = "delete book_order order_id = ?";
            $sqlDb = App::$db->prepare($sql);
            $sqlDb->execute(array($order->orders_id));
            $order->delete();

            return ["status" => 0, "message" => $e->getMessage()];
        }
    }

    public static function getHistory($userId){
        $sql = "select * from orders where orders_status <> 2 and orders_client_id = ?";
        $sqlDb = App::$db->prepare($sql);
        $sqlDb->execute(array($userId));
        $orders = $sqlDb->fetchAll(PDO::FETCH_ASSOC);

        foreach ($orders as $k => $row){
            $sql = "
              select book.book_id, book.book_name, book.book_price, book_order.book_count from book
              right join book_order on book.book_id = book_order.book_id
              where book_order.order_id = ?
            ";
            $sqlDb = App::$db->prepare($sql);
            $sqlDb->execute(array($row["orders_id"]));
            $books = $sqlDb->fetchAll(PDO::FETCH_ASSOC);
            $orders[$k]["books"][] = $books;
        }
        return $orders;
    }


}

