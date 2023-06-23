<?php
    $controller = isset($_GET['controller']) ? $_GET['controller'] : 'user';
    $action     = isset($_GET['action']) ? $_GET['action'] : 'index';
    $controller = ucfirst($controller);
    $fileController = $controller . "Controller.php";
    $pathController = "controllers/$fileController";
    if (!file_exists($pathController)) {
        echo "Không tìm thấy trang này!"; //Nếu đoạn này xảy ra, chương trình dừng thực hiện
        die();
    }
    require_once "$pathController";
    $classController = $controller."Controller";
    $object = new $classController();
    if (!method_exists($object, $action)) {
        echo "Không tìm thấy trang này!"; //Nếu đoạn này xảy ra, chương trình dừng thực hiện //Kiểm tra action có tồn tại trong Controller ko
        die(); //OK
    }
    $object->$action();
?>