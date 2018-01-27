<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 06.01.2018
 * Time: 12:37
 */
class TaskDBHandler{
    function start($action,$json){
        require("SQLConnector.php");
        $connector = new SQLConnector();
        $conn = $connector->getConnection();
        require_once("Tools.php");
        $tools = new Tools();
        if(!$tools -> chkRole(4)) {
            return json_encode(array("error"=>"no Permisson"));
        }
        $data = null;
        switch($action){
            case "getTaskList":
                $data = $this->getTaskList($conn);
                break;
            case "save":
                $data = $this->save($conn,$json);
                break;
            case "delete":
                $data = $this->deleteTask($conn,$json);
                break;
            case "activate":
                $data = $this->activateTask($conn,$json);
                break;
            default :
                $data = json_encode(array("error"=>"unknown task Action"));

        }
        mysqli_close($conn);
        return $data;
    }
    function getTaskList($conn){
        require_once("Tools.php");
        $tools = new Tools();
        $sql = "SELECT t.*,u.firstname AS ufirstname,u.name AS uname FROM task t LEFT JOIN user u on u.id = t.creator ORDER BY t.title;";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            $date = $obj->lastdo;
            $obj->lastdo = $tools->toDateFormat($date);
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }
    function save($conn,$json){
        if($json['id']==-1){
            return $this->createTask($conn,$json);
        }else{
            return $this->updateTask($conn,$json);
        }
    }
    function createTask($conn,$json){
        require_once("Tools.php");
        $tools = new Tools();
        $title = $json["title"];
        $description = $json["description"];
        $price = $json["price"];
        $standard = $json["standard"];
        $active = $json["active"];
        if (!$this->validate($title, $description, $price)) {
            return json_encode(array("error" => "Validation Error on create Task"));
        }
        $user = $tools->getCurrentUser();
        $sql = "INSERT INTO task (`title`,`description`,`creator`,`price`,`standard`,`active`) VALUES(?,?,?,?,?,?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssidss', $title, $description, intval($user),doubleval( $price), $standard, $active);
        $stmt->execute();
        $stmt->close();
        $itemId = $conn->insert_id;
        return json_encode(array("create" => true, "id" => $itemId));
    }

    function activateTask($conn,$json){
        $sql = "UPDATE task SET active='1' WHERE id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i',$json["id"]);
        $stmt->execute();
        $stmt->close();
        return json_encode(array("update"=>true));
    }

    function updateTask($conn,$json){
        $title = $json["title"];
        $description = $json["description"];
        $price = $json["price"];
        $standard = $json["standard"];
        $active = $json["active"];
        if($this->validate($title,$description,$price) == false){
            return json_encode(array("error"=>"Validation Error on update Task"));
        }
        $sql = "UPDATE task SET title=?,description=?,price=?,standard=?,active=? WHERE id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdssi',$title,$description,doubleval($price),$standard,$active,$json["id"]);
        $stmt->execute();
        $stmt->close();
        return json_encode(array("update"=>true));
    }
    function validate($title,$description,$price){
        if( $title == null || strlen($title) < 3){
            return false;
        }
        if( $description == null || strlen($description) < 3){
            return false;
        }
        if($price === null || strlen($price) < 1){
            echo("price: ".$price . " is null");
            return false;
        }
        return true;
    }

    function deleteTask($conn,$json){
        $id = $json["id"];
        $stmt = $conn->prepare("DELETE FROM task WHERE id=?;");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array("delete"=>true));
    }
}