<?php
class ApiController extends BaseController{

    public function __construct()
    {
        $this->cors();
    }

    private function getRequestToken(){
        if(isset($_SERVER["HTTP_TOKEN"])){
            return $_SERVER["HTTP_TOKEN"];
        }else{
            $this->requestError(400, "need token");
        }
    }

    /*
     * get all genre
     * request type GET
     * url - api/getGenres
     * response type - json|xml|txt|html
     */
    public function getGenres(){
        $this->cors();
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $genres = Genre::model()->findAll();

        $this->sendResponse(["success" => 1, "data" => $genres]);
        exit();
    }

    /*
    * get all authors
    * request type GET
    * url - api/getAuthors
    * response type - json|xml|txt|html
    */
    public function getAuthors(){
        $this->cors();
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $authors = Author::model()->findAll();

        $this->sendResponse(["success" => 1, "data" => $authors]);
        exit();
    }

    /*
  * get book by id
  * request type GET
  * url - api/book/(auto id).(response type)
  * response type - json|xml|txt|html
  */
    public function getBookById(){
        $this->cors();
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }

        $request = $this->getRequestParams();
        $requiredParams = ["id"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is required"]);
            }
        }
        $book = Book::model()->findById($request["id"]);
        $this->sendResponse(["success" => 1, "data" => $book]);
    }
    /*
   * get all books
   * request type GET
   * url - api/getBooks
   * response type - json|xml|txt|html
   */
    public function getBooks(){
        $this->cors();
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }

        $request = $this->getRequestParams();

        $params = [];

        if (isset($request['author'])){
            $params['author'] = $request['author'];
        }
        if (isset($request['genre'])){
            $params['genre'] = $request['genre'];
        }

        $books = Book::model()->findByAttributes($params);

        $this->sendResponse(["success" => 1, "data" => $books]);
        exit();
    }

    /*
    * authorization
    * request type POST
    * url - api/auth
    * login - require, user login
    * password - require, user password
    * name - user name
    *
    * return user token
    */
    public function auth(){
        $this->cors();
        if($this->getRequestType() !== "POST") {
            $this->requestError(405);
        }
        $request = $this->getRequestParams();
        $requiredParams = ["login", "password"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is message"]);
            }
        }

        $user = User::model()->findByLogin($request["login"]);
        if($user == null){
            $this->sendResponse(["success" => 0, "message" => 'login not found']);
        }else{
            if($user->password === md5($request["password"])){
                $token = $user->generateToken();
                $user->token = $token;
                $user->save();
            }else{
                $this->requestError(401);
            }
        }

        $this->sendResponse(["success" => 1, "data" => ["token" => $token]]);
    }

    /**
    * get uder data
    * request type GEt
    * url - api/user
    * token - require
    *
    * return user data
    */
    public function user(){
        $this->cors();
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $token = getallheaders()['token'];

        $user = User::model()->findByToken($token);
        if($user == null){
            $this->sendResponse(["success" => 0, "message" => 'login not found']);
        }else{
            unset($user->password);
            unset($user->token);
        }

        $this->sendResponse(["success" => 1, "data" => $user]);
    }

    /*
    * registration
    * request type POST
    * url - api/registration
    * login - require, user login
    * password - require, user password
    * name - user name
    *
    * return user token
    */

    public function registration(){
        $this->cors();
        if($this->getRequestType() !== "POST") {
            $this->requestError(405);
        }
        $request = $this->getRequestParams();
        $requiredParams = ["login", "password"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is required"]);
            }
        }

        $user = User::model()->findByLogin($request["login"]);
        if($user == null){
            $newUser = new User();

            $token = $newUser->generateToken();

            $newUser->login = $request["login"];
            $newUser->password = md5($request["password"]);
            $newUser->name = array_key_exists("name", $request)?$request["name"]:'';
            $newUser->token = $token;
            $newUser->discount = 0;
            $newUser->save();
        }else{
            $this->sendResponse(["success" => 0, "message" => 'This login is exists']);
        }

        $this->sendResponse(["success" => 1, "data" => ["token" => $token]]);
    }

    /*
     * order
     * request type PUT
     * url - api/order
     * token - require, http parameter token
     * book - require, array  book[0]['id']=1&book[0]['count']=2&book[1]['id']=2&book[1]['count']=1
     *
     * return error or success
     */
    public function order()
    {
        $this->cors();
        if ($this->getRequestType() !== "PUT") {
            $this->requestError(405);
        }

        $token = $this->getRequestToken();

        $request = $this->getRequestParams();
        $requiredParams = ["book"];
        foreach ($requiredParams as $param) {
            if (!isset($request[$param]) || $request[$param] == '') {
                $this->sendResponse(["success" => 0, "message" => $param . " parameter is required"]);
            }
        }

        if(!is_array($request["book"])){
            $this->sendResponse(["success" => 0, "message" => "parameter book must be is array"]);
        }

        $user = User::model()->findByToken($token);
        if($user == null){
            $this->sendResponse(["success" => 0, "message" => "user not found"]);
        }else{
            $orderResult = Order::add($request, $user);

            if($orderResult === true){
                $this->sendResponse(["success" => 1, "message" => "order has been created"]);
            }else{
                $this->sendResponse(["success" => 0, "message" => $orderResult["message"]]);
            }

        }
    }

    /*
     * orderHistory
     * request type GET
     * url - api/history
     * token - require, http parameter token
     *
     * return order history
     */
    public function orderHistory()
    {
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }

        $token = $this->getRequestToken();

        $user = User::model()->findByToken($token);
        if($user) {
            //$orders = Order::model()->findAll(["user" => $user->id]);
            $orders = Order::getHistory($user->id);
            $this->sendResponse(["success" => 1, "data" => $orders]);
        }else{
            $this->sendResponse(["success" => 0, "message" => "user not found"]);
        }
    }

    /*
     * orderHistory
     * request type DELETE
     * url - api/deleteOrder
     * token - require, http parameter token
     * orderId - require, order id
     *
     * return success or error
     */
    public function deleteOrder()
    {
        if($this->getRequestType() !== "DELETE") {
            $this->requestError(405);
        }

        $token = $this->getRequestToken();

        $request = $this->getRequestParams();
        $requiredParams = ["orderId"];
        foreach ($requiredParams as $param) {
            if (!isset($request[$param]) || $request[$param] == '') {
                $this->sendResponse(["success" => 0, "message" => $param . " parameter is required"]);
            }
        }

        $user = User::model()->findByToken($token);

        if($user) {
            $order = Order::model()->findOrder($user, $request["orderId"]);

            if($order != null) {
                $order->orders_status = 2;
                $order->save();
                $this->sendResponse(["success" => 1, "message" => "order has been delete"]);
            }else{
                $this->sendResponse(["success" => 0, "message" => "order not found"]);
            }

        }else{
            $this->sendResponse(["success" => 0, "message" => "user not found"]);
        }
    }
}


