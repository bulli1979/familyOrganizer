<?php
/**
 * Created by PhpStorm.
 * User: Mirko Eberlein
 * Date: 26.09.2017
 * Time: 21:21
 */
class PostHandler{
    function start($json){
        switch($json['content']){
            case "user" :
                require_once("DBUser.php");
                $handler = new UserDBHandler();
                return $handler -> start($json['action'],$json);
                break;
            case "shopping" :
                require_once("DBShopping.php");
                $handler = new ShoppingDBHandler();
                return $handler -> start($json['action'],$json);
                break;
            case "doShopping" :
                require_once("DBDoShopping.php");
                $handler = new DoShoppingDBHandler();
                return $handler -> start($json['action'],$json);
                break;
            case "task" :
                require_once("DBTask.php");
                $handler = new TaskDBHandler();
                return $handler -> start($json['action'],$json);
                break;
            case "doTask" :
                require_once("DBDoTask.php");
                $handler = new DoTaskDBHandler();
                return $handler -> start($json['action'],$json);
                break;
            default :
                return json_encode(array("error"=>"unknown post content".$json['content']));
        }
    }
}