<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 31.12.2017
 * Time: 11:48
 */
class DoShoppingDBHandler{
    function start($action,$json){
        require_once("Tools.php");
        $tools = new Tools();
        $perm = $tools->chkRole(2);
        if(!$perm) {
            return json_encode(array("error"=>"no permisson for DoShoppingHandler!"));
        }
        require("SQLConnector.php");
        $connector = new SQLConnector();
        $conn = $connector->getConnection();
        $data = null;
        switch($action){
            case "getShoppingListToBuy":
                $data = $this->getShoppingListToBuy($conn);
                break;
            case "buyItem":
                $data = $this->buyItem($conn,$json,$tools);
                break;
            default :
                $data = json_encode(array("error"=>"unknown doshopping Action"));

        }
        mysqli_close($conn);
        return $data;
    }

    function buyItem($conn,$json,$tools){
        $id = $json["item"]["id"];
        $user =$tools->getCurrentUser();
        $date = new DateTime();
        $mysqlTime = $date ->format("Y-m-d H:i:s");
        $sql = "UPDATE shoppinglist set shoppingdate=? , purchaser=? where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii',$mysqlTime,$user,$id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array("buy"=>true));

    }
    function getShoppingListToBuy($conn){
        $sql = "SELECT sl.*,p.title AS article, c.title AS categorytitle ,u.title AS unittitle FROM shoppinglist sl JOIN unit u ON u.id = sl.unit JOIN products p ON p.id = sl.product JOIN category c ON p.category = c.id WHERE shoppingdate IS NULL ORDER BY c.title";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        $prod = null;
        $currentCat = null;
        while ($obj = $result->fetch_object()) {
            $tmpCat = $obj->categorytitle;
            if($tmpCat != $currentCat){
                if($prod!=null){
                    array_push($arr,["category"=>$currentCat,"items"=>$prod]);
                }
                $prod = array();
                $currentCat = $tmpCat;
            }
            array_push($prod,$obj);
        }
        if($prod!=null){
            array_push($arr,["category"=>$currentCat,"items"=>$prod]);
        }
        return json_encode($arr);
    }
}