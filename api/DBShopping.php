<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 31.12.2017
 * Time: 11:48
 */
class ShoppingDBHandler{
    function start($action,$json){
        session_start();
        require("Tools.php");
        $tools = new Tools();
        $perm = $tools->chkRole(3);
        if(!$perm) {
            return json_encode(array("error"=>"no permisson for Shopping"));
        }
        require("SQLConnector.php");
        $connector = new SQLConnector();
        $conn = $connector->getConnection();
        $data = null;
        switch($action){
            case "getShoppingList" :
                $data = $this->getShoppingList($conn,$tools);
                break;
            case "getCategories" :
                $data = $this->getCategories($conn);
                break;
            case "getProducts" :
                $data = $this->getProducts($conn);
                break;
            case "getUnits" :
                $data = $this->getUnits($conn);
                break;
            case "saveItem":
                $data = $this->createOrUpdateItem($conn,$json);
                break;
            case "createProduct":
                $data = $this->createProduct($conn,$json);
                break;
            case "createCategory":
                $data = $this->createCategory($conn,$json);
                break;
            case "deleteItem" :
                $data = $this->deleteItem($conn,$json);
                break;
            default :
                return json_encode(array("error"=>"unknown shopping Action"));

        }
        mysqli_close($conn);
        return $data;
    }

    function deleteItem($conn,$json){
        $id = $json["id"];
        $stmt = $conn->prepare("DELETE FROM shoppinglist WHERE id=?;");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array("delete"=>true));

    }

    function getShoppingList($conn,$tools){
        $sql = "SELECT sl.*,p.title as ptitle,u.title as utitle,us.name ,us.firstname FROM shoppinglist sl left join products p on p.id = sl.product left join unit u on sl.unit = u.id left join user us on us.id = sl.purchaser";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        if($result != null){
            while ($obj = $result->fetch_object()) {
                $date = $obj->shoppingdate;
                $obj->shoppingdate = $tools->toDateFormat($date);
                array_push($arr,$obj);
            }
        }
        return json_encode($arr);
    }
    function getCategories($conn){
        $sql = "SELECT c.*,u.firstname,u.name FROM category c left join user u on u.id = c.creator";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }
    function getUnits($conn){
        $sql = "SELECT * FROM unit";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }
    function getProducts($conn){
        $sql = "SELECT p.title,p.id,p.category,u.firstname,u.name FROM products p left join user u on u.id = p.creator";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }
    function createOrUpdateItem($conn,$json){
        if($json['id']==-1){
            return $this->createItem($conn,$json);
        }else{
            return $this->updateItem($conn,$json);
        }
    }

    function createItem($conn,$json){
        $product = $json['product'];
        $unit = $json['unit'];
        $amount = $json['amount'];
        if($product == "" || $unit == "" || $amount == ""){
            return json_encode(array("create"=>false,"reason"=>"validation error"));
        }
        $unitId = $this->chkUnit($conn,$unit);
        $sql = "INSERT INTO shoppinglist (`product`,`amount`,`unit`) VALUES(?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii',intval($product),intval($amount),intval($unitId));
        $stmt->execute();
        $stmt->close();
        $itemId = $conn->insert_id;
        return json_encode(array("create"=>true,"id"=>$itemId));
    }

    function createCategory($conn,$json){
        $category = $json['title'];
        $SQLInsert = "INSERT INTO category (`title`,`creator`) VALUES(?,?);";
        $stmt = $conn->prepare($SQLInsert);
        $stmt->bind_param('si',$category,$_SESSION["user"]);
        $stmt->execute();
        $catId = $conn->insert_id;
        $stmt->close();
        return json_encode(array("create"=>true,"id"=>$catId));

    }

    function createProduct($conn,$json){
        if($json["title"]=="" || $json["category"]==""){
            return json_encode(array("create"=>false,"error"=>"validation error"));
        }
        $SQLInsert = "INSERT INTO products (`title`,`creator`,`category`) VALUES(?,?,?);";
        $stmt = $conn->prepare($SQLInsert);
        $stmt->bind_param('sii',$json["title"],$_SESSION["user"],intval($json["category"]));
        $stmt->execute();
        $prodId = $conn->insert_id;
        $stmt->close();
        return json_encode(array("create"=>true,"id"=>$prodId));
    }

    function chkUnit($conn,$unit){
        $SQLGet = "SELECT id from unit WHERE title = ?;";
        $stmt = $conn->prepare($SQLGet);
        $stmt->bind_param('s',$unit);
        $stmt->execute();
        $unitId = null;
        $stmt->bind_result($unitId);
        $stmt->fetch();
        $stmt->close();
        if($unitId==null){
            $SQLInsert = "INSERT INTO unit (`title`) VALUES(?);";
            $stmt2 = $conn->prepare($SQLInsert);
            $stmt2->bind_param('s',$unit);
            $stmt2->execute();
            $unitId = $conn->insert_id;
            $stmt2->close();
        }
        return $unitId;
    }
}