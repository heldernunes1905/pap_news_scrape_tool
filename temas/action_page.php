<?php

include '../functionDB1.php';

//Retrieve the string, which was sent via the POST parameter "user"
$user = $_GET['tema'];
$tematicas = $_GET['novo'];
$fonte = $_GET['fonte'];
$id = $_GET['id'];
$temas = $_GET['temas'];

//Decode the JSON string and convert it into a PHP associative array.
$decoded = json_decode($user, true);
$decoded = implode(",", $decoded);
$decoded = explode(",",$decoded);

$deco = json_decode($tematicas, true);
$deco = implode(",", $deco);
$deco = explode(",",$deco);
$result=count($decoded);
for($j=0;$j<$result;$j++){
    meter_noticias($decoded[$j],$deco[$j]);
}
echo "<script>alert('Editados com sucesso!!'); window.location='../index.php?fonte=$fonte&id=$id&temas=$temas'</script>";

