<?php
include '../functionDB1.php';

$user = $_GET['id'];
$fonte = $_GET['fonte'];
$id = $_GET['id'];
$temas = $_GET['tematicas'];
$date = date("Y-m-d H:i:s");
$old_date = $_COOKIE['old_data'];

$decoded = json_decode($temas, true);
$decoded = implode(",", $decoded);
insert_tema_not($decoded,$id,$date,$old_date);
echo "<script>window.location='../index.php?fonte=$fonte&id=$id&temas=0'</script>";

?>
