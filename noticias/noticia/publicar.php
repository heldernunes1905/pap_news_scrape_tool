<?php

$id=$_GET['id'];
$fonte=$_GET['fonte'];
$user=$_GET['user_name'];
$date = date("Y-m-d H:i:s");
$old_date = $_COOKIE['old_data'];

//delete($id,$user,$date,$old_date);
//echo "<script>alert('Publicado com sucesso!!'); window.location='index.php?fonte=$fonte'</script>";
//tennho que por o user para saber qual publicou