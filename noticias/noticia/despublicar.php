<?php
include_once '../../functionDB1.php';
$id=$_GET['id'];
$fonte=$_GET['fonte'];
checked1($id);
echo "<script>window.location='../../index.php?fonte=$fonte'</script>";



