<?php

include './functionDB1.php';

$id = $_GET['id'];


//Decode the JSON string and convert it into a PHP associative array.
$decoded = json_decode($id, true);
$decoded = implode(",", $decoded);

$decoded = explode(",",$decoded);
foreach($decoded as $value){
    delete_rel($value);
}

echo "<script>window.location='index.php'</script>";
?>