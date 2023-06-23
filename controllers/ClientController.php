<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['LoginOK'])) {
    include "Controller.php";
    require_once 'models/ClientModel.php';
    require_once 'models/TokenModel.php';
    class ClientController extends Controller
    {
        public function index()
        {
            require "views/Clients/index.php";
        }

        //Lấy token để cấp quyền cho các hành động trên website
        public function getToken(){
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                $authorizationHeader = $headers['Authorization'];
                $token_tmp = str_replace('Bearer ', '', $authorizationHeader);
                $token_auth = $_COOKIE['token_tmp'];
                if($token_auth == $token_tmp && isset($_SESSION['LoginOK'])){
                    $id = $_SESSION['LoginOK'];
                    $tokenModel = new TokenModel();
                    $token_ = $tokenModel->get(['user'], [$id], ['and'], "Order by created_at DESC", "LIMIT 1");
                    if(count($token_) > 0){
                        $token_ = $token_[0];
                        if($token_['expired_at'] != null){
                            $expired_at = new DateTime($token_['expired_at']);
                            $now = new DateTime();
                            if($expired_at > $now)  echo $token_['token'];
                            else    echo false;
                        }else{
                            echo $token_['token'];
                        }
                    }else{
                        echo false;
                    }
                }else{
                    echo false;
                }
            }else{
                echo false;
            }
        }

        //Ủy quyền cho các hoạt động thông qua xác thực token
        public function Auth($tokenModel)
        {
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                $authorizationHeader = $headers['Authorization'];
                $token = str_replace('Bearer ', '', $authorizationHeader);
                if(isset($_SESSION['LoginWithGoogle'])){
                    $tokenInfoUrl = "https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=" . urlencode($token);
                    $response = file_get_contents($tokenInfoUrl);
                    if ($response) {
                        $tokenInfo = json_decode($response, true);
                        if ($tokenInfo && isset($tokenInfo['error'])) {
                            return false;
                        } else {
                            return true;
                        }
                    } else {
                        return false;
                    }
                }elseif(isset($_SESSION['LoginWithAccount'])){
                    if (isset($_SESSION['LoginOK'])) {
                        $id = $_SESSION['LoginOK'];
                        $token_ = $tokenModel->get(['user'], [$id], ['and'], "Order by created_at DESC", "LIMIT 1");
                        if(count($token_) > 0){
                            if($token_[0]['token'] == $token && $token_[0]['expired_at'] == null){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
            }
        }

        //Lấy danh sách khách hàng có trong hệ thống
        public function getClient()
        {
            $clientModel = new ClientModel();
            $tokenModel = new TokenModel();
            if ($this->Auth($tokenModel)) {
                echo $clientModel->getJsonQuery("SELECT t1.id, t1.fullname, t1.email, t1.gender, t1.address, t2.fullname as CreatedBy
            FROM clients t1 inner join users t2 on t1.CreatedBy = t2.id");
            } else {
                echo false;
            }
        }

        //Kiểm tra email đã tồn tại trong hệ thống hay chưa
        public function checkMail()
        {
            $clientModel = new ClientModel();
            $tokenModel = new TokenModel();
            if ($this->Auth($tokenModel)) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["email"])) {
                        echo false;
                    } else {
                        $email = $this->test_input($_POST["email"]);
                        echo $clientModel->checkMail($email);
                    }
                } else
                    echo false;
            } else
                echo false;

        }

        //Thêm khách hàng vào hệ thống
        public function insert()
        {
            $clientModel = new ClientModel();
            $tokenModel = new TokenModel();
            if ($this->Auth($tokenModel)) {
                $id = $_SESSION['LoginOK'];
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["fullname"])) {
                        echo false;
                    } else {
                        $fullname = $this->test_input($_POST["fullname"]);
                    }
                    if (empty($_POST["email"]) && count($clientModel->get(['email'], [$_POST["email"]], ['and'])) == 0) {
                        echo false;
                    } else {
                        $email = $this->test_input($_POST["email"]);
                    }
                    if (empty($_POST["address"])) {
                        echo false;
                    } else {
                        $address = $this->test_input($_POST["address"]);
                    }
                    if (empty($_POST["gender"])) {
                        echo false;
                    } else {
                        $gender = $this->test_input($_POST["gender"]);
                        if ($gender == "male") {
                            $gender = true;
                        } else
                            $gender = false;
                    }
                    $clientModel = new ClientModel();
                    if (
                        $clientModel->insert(
                            ['fullname', 'email', 'address', 'gender', 'CreatedBy'],
                            [$fullname, $email, $address, $gender, $id]
                        )
                    ) {
                        echo true;
                    } else {
                        echo false;
                    }
                } else
                    echo false;
            } else
                echo false;
        }

        //Chỉnh sửa thông của khách hàng
        public function update()
        {
            $clientModel = new ClientModel();
            $tokenModel = new TokenModel();
            if ($this->Auth($tokenModel)) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["id"])) {
                        echo false;
                    } else {
                        $id_ = $this->test_input($_POST["id"]);
                    }
                    if (empty($_POST["fullname"])) {
                        echo false;
                    } else {
                        $fullname = $this->test_input($_POST["fullname"]);
                    }
                    if (empty($_POST["email"])) {
                        echo false;
                    } else {
                        $email = $this->test_input($_POST["email"]);
                        $old_email = '';
                        $client = $clientModel->get(['id'], [$_POST["id"]], ['and']);
                        if(count($client) > 0){
                            $old_email = $client[0]['email'];
                        }else   echo false;
                        if($email != $old_email){
                            $new_email = $clientModel->get(['email'], [$_POST["email"]], ['and']);
                            if(count($new_email) > 0)   echo false;
                        }
                    }
                    if (empty($_POST["address"])) {
                        echo false;
                    } else {
                        $address = $this->test_input($_POST["address"]);
                    }
                    if (empty($_POST["gender"])) {
                        echo false;
                    } else {
                        $gender = $this->test_input($_POST["gender"]);
                        if ($gender == "male") {
                            $gender = true;
                        } else
                            $gender = false;
                    }
                    $clientModel = new ClientModel();
                    if (
                        $clientModel->update(
                            ['fullname', 'email', 'address', 'gender'],
                            [$fullname, $email, $address, $gender],
                            ['id'],
                            [$id_],
                            ['and']
                        )
                    ) {
                        echo true;
                    } else {
                        echo false;
                    }
                } else
                    echo false;
            } else
                echo false;
        }

        //Xóa khách hàng khỏi hệ thống
        public function delete()
        {
            $clientModel = new ClientModel();
            $tokenModel = new TokenModel();
            if ($this->Auth($tokenModel)) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["id"])) {
                        echo false;
                    } else {
                        $id_ = $this->test_input($_POST["id"]);
                    }
                    $clientModel = new ClientModel();
                    if ($clientModel->delete(['id'], [$id_], ['and'])) {
                        echo true;
                    } else {
                        echo false;
                    }
                } else
                    echo false;
            } else
                echo false;
        }
        public function test(){
            echo $_SESSION['LoginWithGoogle'];
        }
    }
} else {
    header("location: index.php");
}
?>