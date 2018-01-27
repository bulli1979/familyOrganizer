<?php
/**
 * Created by PhpStorm.
 * User: Mirko Eberlein
 * Date: 26.09.2017
 * Time: 21:49
 */
class UserDBHandler{
    function start($action,$json){
        require("SQLConnector.php");
        $connector = new SQLConnector();
        $conn = $connector->getConnection();
        $data = null;
        switch($action){
            case "getAll" :
                $data = $this->getAllUser($conn);
                break;
            case "logIn" :
                $data = $this->logIn($conn,$json);
                break;
            case "chkLogin" :
                $data = $this->chkLogin();
                break;
            case "logOut" :
                $data = $this->logOut();
                break;
            case "save" :
                $data = $this->createOrUpdateUser($conn,$json);
                break;
            case "delete":
                $data = $this->deleteUser($conn,$json);
                break;
            case "getRoles":
                $data = $this->getRoles($conn);
                break;
            default:
                return json_encode(array("error"=>"unknown User Action"));
        }
        mysqli_close($conn);
        return $data;

    }

    function getRoles($conn){
        $sql = "SELECT id,title FROM role";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }
    function logOut(){
        $_SESSION = array();
        return json_encode(array("logOut"=>session_destroy ()));
    }
    function getAllUser($conn){
        require_once("Tools.php");
        $tools = new Tools();
        if(!$tools -> chkRole(1)) {
            return "[]";
        }
        $sql = "SELECT u.id,u.firstname,u.name,u.username,u.birthday,u.email, (Select GROUP_CONCAT(role_id) from user_has_role ur where ur.user_id = u.id) as roles FROM user u;";
        $result = mysqli_query($conn,$sql);
        $arr = array();
        while ($obj = $result->fetch_object()) {
            $r = explode(",",$obj->roles);
            $obj->roles = $r;
            $obj->birthday = $tools->toDateFormat($obj->birthday);
            array_push($arr,$obj);
        }
        return json_encode($arr);
    }
    function logIn($conn,$json){
        $data = null;
        require_once("Tools.php");
        $tools = new Tools();
        $username = $json['username'];
        $pw = $json['password'];
        $stmt = $conn->prepare("SELECT u.id,u.firstname,u.name,u.username,u.birthday,u.email,u.password,(Select GROUP_CONCAT(role_id) from user_has_role ur where ur.user_id = u.id) as roles FROM user u WHERE u.username =? ;");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $rId=null;
        $rFirstName=null;
        $rName=null;
        $rBirthday=null;
        $rEmail=null;
        $rPassword=null;
        $rRoles = null;
        $rUsername = null;
        $stmt->bind_result($rId, $rFirstName, $rName,$rUsername,$rBirthday,$rEmail,$rPassword,$rRoles);
        $stmt->fetch();
        if($this->chkHash($pw,$rPassword)){
            $roles = explode (",",$rRoles);

            $data= json_encode(array('id'=>$rId,'firstname'=>$rFirstName,'name'=>$rName,'birthday'=>$tools->toDateFormat($rBirthday),'email'=>$rEmail,'username'=>$rUsername,'roles'=>$roles));
            $_SESSION["user"] = $rId;
            $_SESSION["loggedIn"]=true;
            $_SESSION["data"]=$data;
        }else{
            return json_encode(array("logIn"=>false));
        }
        $stmt->close();
        return $data;
    }
    function chkLogin(){
        if(isset($_SESSION['loggedIn'])){
            return $_SESSION['data'];
        }
        return json_encode(array("logIn"=>false));
    }

    function createOrUpdateUser($conn,$json){
        if($json['id']==-1){
            return $this->createUser($conn,$json);
        }else{
            return $this->updateUser($conn,$json);
        }
    }
    function createUser($conn,$json){
        require_once("Tools.php");
        $tools = new Tools();
        if(!$tools -> chkRole(1)) {
            return json_encode(array("create"=>false,"error"=>"no Permission"));
        }
        $user = $json['username'];
        $pw = $json['password'];
        $hash = $this->getHash($pw);
        $firstName = $json['firstname'];
        $name = $json['name'];
        $email = $json['email'];
        $birthday = $json['birthday'];
        $birthday = $tools->getSqlDate($birthday);
        if(!$this->validateUser($firstName,$name,$email,$pw,$user)){
            return json_encode(array("validation Error"=>false));
        }
        $roles = $json['roles'];

        $stmt = $conn->prepare("INSERT INTO user (`password`,`firstname`,`name`,`birthday`,`email`,`username`) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param('ssssss',$hash,$firstName,$name,$birthday,$email,$user);
        $stmt->execute();
        $stmt->close();
        $last_id = $conn->insert_id;
        $this->setUserRoles($conn,$roles,$last_id);
        return json_encode(array("create"=>true,"id"=>$last_id));
    }
    function validateUser($firstName,$name,$email,$pw,$userName){
        if(strlen($firstName) <3 ){
            return false;
        }
        if(strlen($name) <3 ){
            return false;
        }
        if(strlen($email) <3 ){
            return false;
        }
        if(strlen($userName) <3 ){
            return false;
        }
        if(strlen($pw) < 3 ){
            return false;
        }
        return true;
    }
    function updateUser($conn,$json){
        $id = $json['id'];
        require_once("Tools.php");
        $tools = new Tools();
        if(!$tools -> chkRole(1) && !$tools -> isCurrentUser($id)) {
            return json_encode(array("update"=>false));
        }
        $user = $json['username'];
        $pw = $json['password'];

        $firstName = $json['firstname'];
        $name = $json['name'];
        $email = $json['email'];
        $birthday = $json['birthday'];
        $birthday = $tools->getSqlDate($birthday);
        $roles = $json['roles'];
        $stmt = null;
        if(strlen($pw)>0){
            $pw=$this->getHash($pw);
            $stmt = $conn->prepare("UPDATE user u set password=?,u.firstname=?,u.name=?,u.birthday=?,u.email=?,u.username=? WHERE u.id = ?");
            $stmt->bind_param('ssssssi',$pw,$firstName,$name,$birthday,$email,$user,$id);

        }else{
            $stmt = $conn->prepare("UPDATE user u set u.firstname=?,u.name=?,u.birthday=?,u.email=?,u.username=? WHERE u.id = ?");
            $stmt->bind_param('sssssi',$firstName,$name,$birthday,$email,$user,$id);
        }
        $stmt->execute();
        $stmt->close();
        if($tools -> chkRole(1)){
            $this->setUserRoles($conn,$roles,$id);
        }
        return json_encode(array("save"=>true));
    }

    function setUserRoles($conn,$roles,$id){
        $conn->query("DELETE FROM user_has_role WHERE user_id = ".$id);
        foreach ($roles as $role){
            $conn->query("INSERT INTO user_has_role (`user_id`,`role_id`) VALUES (".$id.",".$role.");");
        }
    }
    function deleteUser($conn,$json){
        require_once("Tools.php");
        $tools = new Tools();
        if(!$tools -> chkRole(1)) {
            return json_encode(array("delete"=>false));
        }
        $id = $json['id'];
        $stmt = $conn->prepare("DELETE FROM user WHERE id=?;");
        $stmt2 = $conn->prepare("DELETE FROM user_has_role WHERE user_id=?;");
        $stmt2->bind_param('i',$id);
        $stmt2->execute();
        $stmt2->close();
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array("delete"=>true));
    }
    function getHash($toHash){
        $options = [
            'cost' => 12,
        ];
        return password_hash($toHash, PASSWORD_BCRYPT, $options);
    }
    function chkHash($pw,$hash){
        return password_verify($pw,$hash);
    }
}