<?php
include '../functionDB1.php';

$user = $_GET['tname'];
$fonte = $_GET['fonte'];
$id = $_GET['id'];
$temas = $_GET['temas'];

insertem($user);
echo "<script>alert('Criado com sucesso!!'); window.location='../index.php?fonte=$fonte&id=$id&temas=$temas'</script>";

?>
