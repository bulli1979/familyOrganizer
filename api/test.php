<?php
        require("SQLConnector.php");
        $connector = new SQLConnector();
        $conn = $connector->getConnection();
        echo("unit " . strval(chkUnit($conn,"Stück")));


function chkUnit($conn,$unit){
    $SQLGet = "SELECT id from unit WHERE title = ?;";
    $stmt = $conn->prepare($SQLGet);
    $stmt->bind_param('s',$unit);
    $stmt->execute();
    $unitId = null;
    $stmt->bind_result($unitId);
    $stmt->fetch();
    $stmt->close();
    return $unitId;
}
//echo($tools->getSqlDate($date ));
