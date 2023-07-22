<?php
include '../../functionDB1.php';

$id=$_GET['id'];
$fonte=$_GET['fonte'];
$id = explode(",", $id);
print_r($id);
foreach($id as $ida){
    checked($ida);
}
echo "<script>window.location='../../index.php?fonte=$fonte'</script>";



