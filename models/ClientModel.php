<?php
require_once 'configs/database.php';
require_once 'models/model.php';
class ClientModel extends Model{
    public function __construct(){
        $this->table = "clients";
    }
}
?>