<?php
require_once 'configs/database.php';
class Model{
    protected $table;

    //Kết nối với cơ sở dữ liệu
    public function connectDb() {
        try{
            $dbh = new PDO("mysql:host=localhost;dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
        }catch(PDOException $e){
            echo "Kết nối thất bại: " . $e->getMessage();
        }
        return $dbh;
    }

    //Đóng kết nối
    public function closeDb($connection = null) {
        mysqli_close($connection);
    }
    function get_sql_query($query){
        $dbh = $this->connectDb();
        $stmt = $dbh->prepare($query);
        if($stmt->execute()){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }else{
            return false;
        }
    }

    //Lấy dữ liệu Json phục vụ cho Ajax 1
    function getJsonQuery($query){
        $dbh = $this->connectDb();
        $stmt = $dbh->prepare($query);
        if($stmt->execute()){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array("data" => $data));
        }else{
            return false;
        }
    }

    //Lấy dữ liệu Json phục vụ cho Ajax 2
    function getJson($condition = [], $value_condition = [], $logic = [], $orderby = ""){
        $dbh = $this->connectDb();
        $sql = "SELECT * FROM `".$this->table."`";
        #Chuẩn bị các điều kiện
        if(!empty($condition)){
            $sql.= " WHERE ";
            //Thêm các điều kiện
            for($i = 0; $i < count($condition); $i++){
                $sql .= "`".$condition[$i]."` = ? ".$logic[$i]." ";
            }
            $sql = trim($sql);
            $sql = substr($sql, 0, strlen($sql)-strlen($logic[count($logic)-1]));
        }
        $sql .= $orderby;
        
        //Thực thi
        $stmt = $dbh->prepare($sql);
        if(!empty($condition)){
            //Thêm các values điều kiện
            for($i = 0; $i < count($value_condition); $i++){
                $stmt->bindValue($i+1, $value_condition[$i]);
            }
        }
        if($stmt->execute()){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array("data" => $data));
        }else{
            return false;
        }
    }

    //Lấy dữ liệu từ bảng cơ sở dữ liệu nhanh bao gồm các tham số điều kiện và logic
    function get($condition = [], $value_condition = [], $logic = [], $orderby = "", $limit = ""){
        $dbh = $this->connectDb();
        $sql = "SELECT * FROM `".$this->table."`";
        #Chuẩn bị các điều kiện
        if(!empty($condition)){
            $sql.= " WHERE ";
            //Thêm các điều kiện
            for($i = 0; $i < count($condition); $i++){
                $sql .= "`".$condition[$i]."` = ? ".$logic[$i]." ";
            }
            $sql = trim($sql);
            $sql = substr($sql, 0, strlen($sql)-strlen($logic[count($logic)-1]));
        }
        $sql .= $orderby." ";
        $sql .= $limit;
        //Thực thi
        $stmt = $dbh->prepare($sql);
        if(!empty($condition)){
            //Thêm các values điều kiện
            for($i = 0; $i < count($value_condition); $i++){
                $stmt->bindValue($i+1, $value_condition[$i]);
            }
        }
        if($stmt->execute()){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }else{
            return false;
        }
    }

    //Thêm dữ liệu vào bảng cơ sở dữ liệu nhanh bao gồm các cột và giá trị
    function insert($column = [], $value = []){
        $dbh = $this->connectDb();
        $sql = "INSERT INTO `".$this->table."`(";
        //Thêm các columns
        for($i = 0; $i < count($column); $i++){
            $sql .= "`".$column[$i]."`, ";
        }
        $sql = trim($sql);
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql .= ") VALUES (";
        //Thêm các values
        for($i = 0; $i < count($value); $i++){
            $sql .= "?, ";
        }
        
        $sql = trim($sql);
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql .= ")";
        //Thực thi
        $stmt = $dbh->prepare($sql);
        for($i = 0; $i < count($value); $i++){
            $stmt->bindValue($i+1, $value[$i]);
        }
        return $stmt->execute();
    }

    //Cập nhật dữ liệu từ bảng cơ sở dữ liệu nhanh bao gồm các cột cần cập nhật và giá trị cập nhật kèm theo đó là các điều kiện và logic của nó.
    function update($column = [], $value = [], $condition = [], $value_condition = [], $logic = []){
        $dbh = $this->connectDb();
        $sql = "UPDATE `".$this->table."` SET ";

        //Thêm các columns
        for($i = 0; $i < count($column); $i++){
            $sql .= "`".$column[$i]."` = ?, ";
        }
        $sql = trim($sql);
        $sql = substr($sql, 0, strlen($sql)-1);
        if(!empty($condition)){
            $sql .= " WHERE ";
            //Thêm các điều kiện
            for($i = 0; $i < count($condition); $i++){
                $sql .= "`".$condition[$i]."` = ? ".$logic[$i]." ";
            }
            $sql = trim($sql);
            $sql = substr($sql, 0, strlen($sql)-strlen($logic[count($logic)-1]));
        }
        
        
        //Thực thi
        $stmt = $dbh->prepare($sql);
        //Thêm các values update
        for($i = 0; $i < count($value); $i++){
            $stmt->bindValue($i+1, $value[$i]);
        }
        if(!empty($condition)){
            //Thêm các values điều kiện
            for($i = 0; $i < count($value_condition); $i++){
                $stmt->bindValue($i+count($value)+1, $value_condition[$i]);
            }
        }
        return $stmt->execute();
    }

    //Xóa dữ liệu từ bảng cơ sở dữ liệu nhanh bao gồm các điều kiện và giá trị của điều kiện và logic
    function delete($condition = [], $value_condition = [], $logic = []){
        $dbh = $this->connectDb();
        $sql = "DELETE FROM `".$this->table."` WHERE ";
        #Chuẩn bị các điều kiện
        if(!empty($condition)){
            //Thêm các điều kiện
            for($i = 0; $i < count($condition); $i++){
                $sql .= "`".$condition[$i]."` = ? ".$logic[$i]." ";
            }
            $sql = trim($sql);
            $sql = substr($sql, 0, strlen($sql)-strlen($logic[count($logic)-1]));
        }
        
        //Thực thi
        $stmt = $dbh->prepare($sql);
        if(!empty($condition)){
            //Thêm các values điều kiện
            for($i = 0; $i < count($value_condition); $i++){
                $stmt->bindValue($i+1, $value_condition[$i]);
            }
        }
        return $stmt->execute();
    }

    //Hàm kiểm tra email có tồn tại trong bảng đó hay không!
    public function checkMail($email){
        $dbh = $this->connectDb();
        $stmt = $dbh->prepare("Select* from ".$this->table." where email = ?");
        $stmt->bindValue(1, $email);
        if($stmt->execute()){
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($data) > 0)    return false;
            else return true;
        }else   return false;
    }
}

?>