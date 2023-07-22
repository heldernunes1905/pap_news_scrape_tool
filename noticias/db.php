<?php
$serverName = "localhost\SQLEXPRESS"; 
$uid = "";   
$pwd = "";  
$databaseName = "simple"; 

$connectionInfo = array( "UID"=>$uid,                            
                        "PWD"=>$pwd,                            
                        "Database"=>$databaseName); 

/* Connect using SQL Server Authentication. */  

$conn = mysqli_connect( $serverName, $connectionInfo);  
function get(){
    global $conn;
    $tsql = "SELECT * FROM fontes";  

    /* Execute the query. */  

    $stmt = mysqli_query( $conn, $tsql);  

    /* Iterate through the result set printing a row of data upon each iteration.*/ 
    return $stmt; 
}


?>