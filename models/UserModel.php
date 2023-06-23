<?php
require_once 'configs/database.php';
require_once 'models/model.php';
class UserModel extends Model{
    public function __construct(){
        $this->table = "users";
    }
}
?>