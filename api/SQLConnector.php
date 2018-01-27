<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 26.09.2017
 * Time: 21:45
 */
class SQLConnector{
    function getConnection(){
        //TODO eigene DB Daten einsetzen
        $link = mysqli_connect('localhost', 'root', 'root', 'familyorganizer');
        mysqli_set_charset($link,'utf8');
        return $link;
    }
}