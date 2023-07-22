<?php

include '../functionDB1.php';

//Retrieve the string, which was sent via the POST parameter "user"
$user = $_GET['user'];
$fonte = $_GET['fonte'];
$id = $_GET['id'];
$temas = $_GET['temas'];

//Decode the JSON string and convert it into a PHP associative array.
$decoded = json_decode($user, true);
$decoded = implode(",", $decoded);

$decoded = explode(",",$decoded);
foreach($decoded as $value){
    deletetemas($value);
}
echo "<script>alert('Eliminados com sucesso!!'); window.location='../index.php?fonte=$fonte&id=$id&temas=$temas'</script>";
?>