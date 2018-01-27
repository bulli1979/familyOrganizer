<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 06.01.2018
 * Time: 12:37
 */
class DoTaskDBHandler{
    function start($action,$json){
        session_start();
        require("SQLConnector.php");
        $connector = new SQLConnector();
        $conn = $connector->getConnection();
        require_once("Tools.php");
        $tools = new Tools();
        if(!$tools -> chkRole(5)) {
            return json_encode(array("error"=>"no Permisson"));
        }
        $data = null;
        switch($action){
            case "getTaskList":
                $data = $this->getTaskList($conn);
                break;
            case "doTask":
                $data = $this->doTask($conn,$json,$tools);
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
        $sql = "SELECT t.* FROM task t WHERE t.active = '1' ORDER BY t.title;";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            $date = $obj->lastdo;
            $obj->shoppingdate = $tools->toDateFormat($date);
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }

    function doTask($conn,$json,$tools){
        $user = $tools->getCurrentUser();
        $mysql_date_now = date("Y-m-d H:i:s");
        $sql = "UPDATE task SET active='0', lastdo=? WHERE id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si',$mysql_date_now,$json["id"]);
        $stmt->execute();
        $stmt->close();
        $insertSQL = "INSERT INTO user_do_task (user_id,task_id,`date`) VALUES(?,?,?);";
        $stmt2 = $conn->prepare($insertSQL);
        $stmt2->bind_param('iis',intval($user),intval($json["id"]),$mysql_date_now);
        $stmt2->execute();
        $stmt2->close();
        return json_encode(array("update"=>true));
    }
}