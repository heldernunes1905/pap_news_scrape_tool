<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

</script>
<?php
include '../../functionDB1.php';
$title = $_GET['title'];
$date = date("Y-m-d H:i:s");
$old_date = $_GET['date'];
$resumo = $_GET['resumo'];
$text = $_COOKIE['text'];
$temas=$_GET['tematicas'];
$imgdiv = $_GET['img'];
$imgdiv = str_replace("|",";",$imgdiv);
$imgdiv = str_replace("barras","/",$imgdiv);
$imgdiv = str_replace("ponto_virg",";",$imgdiv);
$imgdiv = str_replace("cardinal","#",$imgdiv);
$imgdiv = str_replace("outros","&",$imgdiv);
$imgdiv = str_replace("menor_img","<img",$imgdiv);
$imgdiv = str_replace("maior_img",">",$imgdiv);
$title = str_replace("peliculas","#039;",$title);
$title = str_replace("outros","&",$title);
$id = $_GET['id'];
$ave = $_COOKIE['ave'];
$highlight = $_COOKIE['highlight'];
$favoratibilidade = $_COOKIE['favoratibilidade'];
$fonte=$_GET['fonte'];
$user=$_GET['user_name'];

update($title,$date,$text,$imgdiv,$resumo,$id,$user,$old_date,$ave,$highlight,$favoratibilidade);
echo "<script> window.location='../../temas/temas_texto.php?fonte=$fonte&id=$id&tematicas=$temas'</script>";
echo "<script>alert('Publicado com sucesso!!'); window.location='../../index.php?fonte=$fonte'</script>";
?>