<?php
if (!isset($_SESSION)) {
    session_start();
}
include "Controller.php";
require_once 'models/UserModel.php';
require_once 'models/TokenModel.php';
class UserController extends Controller
{
    //Chức năng đăng nhập
    public function index()
    {
        if (isset($_SESSION['LoginOK'])) {
            header("location: index.php?controller=client");
        } else {
            $passwordErr = $emailErr = "";
            $errorArr = array();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $userModel = new UserModel();
                $tokenModel = new TokenModel();
                $pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
                if (empty($_POST["email"])) {
                    $emailErr = "Hãy nhập tài khoản email!";
                } else if (!preg_match($pattern, $_POST["email"])) {
                    $emailErr = "Địa chỉ email không hợp lệ!";
                } else {
                    $user = $userModel->get(['email'], [$_POST["email"]], ['and']);
                    if (count($user) == 0) {
                        $emailErr = "Tài khoản không tồn tại trong hệ thống!";
                    } else {
                        if (empty($_POST["password"]) || strlen($_POST["password"]) < 8) {
                            $passwordErr = "Mật khẩu tối thiểu 8 ký tự và không được để trống!";
                        } else {
                            $password = $this->test_input($_POST["password"]);
                            $user = $user[0];
                            if (password_verify($password, $user['password'])) {
                                $_SESSION['LoginOK'] = $user['id'];
                                $_SESSION['LoginWithAccount'] = true;
                                $token = bin2hex(random_bytes(16));
                                $tokenModel->insert(['token', 'user'], [$token, $user['id']]);
                                header("location: index.php?controller=client");
                            } else {
                                $passwordErr = "Mật khẩu không chính xác!";
                            }
                        }
                    }
                }
            }
            if ($passwordErr != "" || $emailErr != "") {
                $errorArr = array($passwordErr, $emailErr);
            }
            require "views/users/index.php";
        }
    }

    //Kiểm tra email đã tồn tại trong hệ thống của người dùng chưa
    public function checkMail()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["email"])) {
                echo false;
            } else {
                $email = $this->test_input($_POST["email"]);
                $userModel = new UserModel();
                echo $userModel->checkMail($email);
            }
        } else
            echo false;
    }

    //Chức năng đăng ký
    public function register()
    {
        $passwordErr = $emailErr = $fullnameErr = $addressErr = "";
        $errorArr = array();
        $success = "Đăng ký tài khoản thành công!";
        $error = "Đăng ký tài khoản thất bại";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new UserModel();
            if (empty($_POST["email"])) {
                $emailErr = "Hãy nhập email!";
            } else if (count($userModel->get(['email'], [$_POST["email"]], ['and'])) > 0) {
                $emailErr = "Email đã tồn tại trong hệ thống rồi!";
            } else {
                $email = $this->test_input($_POST["email"]);
            }
            if (empty($_POST["password"]) || strlen($_POST["password"]) < 8) {
                $passwordErr = "Mật khẩu tối thiểu 8 ký tự và không được để trống!";
            } else {
                $password = password_hash($this->test_input($_POST["password"]), PASSWORD_DEFAULT);
            }
            if (empty($_POST["fullname"])) {
                $fullnameErr = "Hãy nhập đầy đủ họ tên!";
            } else {
                $fullname = $this->test_input($_POST["fullname"]);
            }
            if (empty($_POST["address"])) {
                $addressErr = "Hãy nhập địa chỉ!";
            } else {
                $address = $this->test_input($_POST["address"]);
            }
            if ($passwordErr == "" && $emailErr == "" && $fullnameErr == "" && $addressErr == "") {
                if ($userModel->insert(['email', 'password', 'fullname', 'address'], [$email, $password, $fullname, $address])) {
                    require_once("views/Users/send_email.php");
                    $subject = "[Hệ thống] Chào mừng bạn đến với hệ thống quản lý khách hàng.";
                    $body = "Chào " . $fullname . ",<br>" . "Chào mừng bạn đến với hệ thống quản lý khách hàng của chúng tôi, <a href='http://localhost/EXERCISE/index.php?controller=user'>nhấn vào đây</a> để đăng nhập và sử dụng hệ thống.";
                    $success = "Đăng ký tài khoản thành công!";
                    sendemailforAccount($email, $subject, $body);
                    header("location: index.php?controller=user&success=" . $success);
                } else {
                    $_SESSION['error'] = "Đăng ký tài khoản thất bại!";
                    header("location: index.php?controller=user&action=register&error=" . $error);
                }
            } else {
                $errorArr = array($passwordErr, $emailErr, $fullnameErr, $addressErr);
            }
        }
        require "views/users/register.php";
    }

    //Chức năng đăng nhập bằng google ủy quyền bằng OAUTH2
    function loginWithGoogle()
    {
        if (isset($_GET['code']) && isset($_GET['prompt']) && isset($_GET['authuser']) && $_GET['prompt'] == 'consent' && $_GET['authuser'] == 1 || $_GET['authuser'] == 0) {
            $client_id = '945161652386-ptbvf9j28sp24s3hpmvbpl3fcpmh9crc.apps.googleusercontent.com';
            $client_secret = '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';
            $redirect_uri = 'http://localhost:80/OAUTH/index.php?controller=user&action=loginWithGoogle';
            $code = $_GET['code'];
            $url = 'https://accounts.google.com/o/oauth2/token';
            $data = array(
                'code' => $code,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'grant_type' => 'authorization_code'
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            if ($response === false) {
            } else {
                $token_data = json_decode($response, true);
                if (isset($token_data['access_token'])) {
                    $access_token = $token_data['access_token'];
                    $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
                    $userinfo_headers = array(
                        'Authorization: Bearer ' . $access_token
                    );
                    $userinfo_context = stream_context_create(
                        array(
                            'http' => array(
                                'header' => $userinfo_headers
                            )
                        )
                    );
                    $userinfo_response = file_get_contents($userinfo_url, false, $userinfo_context);
                    if ($userinfo_response !== false) {
                        $userinfo_data = json_decode($userinfo_response, true);
                        $userModel = new UserModel();
                        $tokenModel = new TokenModel();
                        $user = $userModel->get(['email'], [$userinfo_data['email']], ['and']);
                        if(count($user) > 0){
                            if($tokenModel->insert(['user', 'token'], [$user[0]['id'], $access_token])){
                                $_SESSION['LoginOK'] = $user[0]['id'];
                                $_SESSION['LoginWithGoogle'] = true;
                                header("location: index.php?controller=client");
                            }else{
                                header("location: index.php?controller=user");
                            }
                        }else{
                            if($userModel->insert(['email', 'fullname'], [$userinfo_data['email'], $userinfo_data['name']])){
                                $user = $userModel->get(['email'], [$userinfo_data['email']], ['and'])[0];
                                if($tokenModel->insert(['user', 'token'], [$user['id'], $access_token])){
                                    $_SESSION['LoginOK'] = $user['id'];
                                    $_SESSION['LoginWithGoogle'] = true;
                                    header("location: index.php?controller=client");
                                }else{
                                    header("location: index.php?controller=user");
                                }
                            }else{
                                header("location: index.php?controller=user");
                            }
                        }
                    } else {
                        header("location: index.php?controller=user");
                    }
                } else {
                    header("location: index.php?controller=user");
                }
            }
        }else{
            header("location: index.php?controller=user");
        }
    }

    //Chức năng đăng xuất
    public function logout()
    {
        if (isset($_SESSION['LoginOK'])) {
            $id = $_SESSION['LoginOK'];
            if(isset($_SESSION['LoginWithAccount'])){
                unset($_SESSION['LoginOK']);
                $tokenModel = new TokenModel();
                $tokenModel->update(['expired_at'], [(new DateTime())->format('Y-m-d H:i:s')], ['token'], [$_SESSION['token']], ['and']);
                unset($_SESSION['LoginWithAccount']);
            }else{
                $tokenModel = new TokenModel();
                $token_ = $tokenModel->get(['user'], [$id], ['and'], "Order by created_at DESC", "LIMIT 1");
                $url = 'https://accounts.google.com/o/oauth2/revoke?token=' . $token_[0]['token'];
                $response = file_get_contents($url);
                unset($_SESSION['LoginOK']);
                unset($_SESSION['LoginWithGoogle']);
                $tokenModel->update(['expired_at'], [(new DateTime())->format('Y-m-d H:i:s')], ['token'], [$_SESSION['token']], ['and']);
                header('Location: index.php');
            }
        }
        header("location: index.php");
    }
}
?>