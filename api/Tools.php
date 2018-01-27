<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 27.09.2017
 * Time: 21:07
 */
class Tools{
    function chkRole($role){
        if(isset($_SESSION['loggedIn'])){
            if($_SESSION['loggedIn'] == 1){
                $data = json_decode($_SESSION['data'],true);
                if(in_array($role,$data["roles"])){
                    return true;
                }
            }
        }
        return false;
    }
    function isCurrentUser($id){
        if(isset( $_SESSION["user"]) &&  $_SESSION["user"]==$id){
            return true;
        }
        return false;
    }
    function getSqlDate($date){
        if($date==""){
            return null;
        }else{
            try {
                $parts = preg_split("/\./",$date);
                return $parts[2] . "-" . $parts[1] . "-" . $parts[0];
            }catch(Exception $e){
                return null;
            }

        }
    }
    function toDateFormat($date){
        if($date==null || $date==""){
            return null;
        }else{
            try {
                $parts = preg_split("/-/",$date);
                $size = count($parts);
                if($size== 3){
                 return $parts[2] . "." . $parts[1] . "." . $parts[0];
                }else if($size == 3){
                    return $parts[2] . "." . $parts[1] . "." . $parts[0]." ".$parts[3];
                }
            }catch(Exception $e){
                return null;
            }
        }
    }

    function getCurrentUser(){
        if(isset( $_SESSION["user"]) &&  $_SESSION["user"]){
            return $_SESSION["user"];
        }else{
            return null;
        }

    }
}