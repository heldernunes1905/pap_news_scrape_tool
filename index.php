<?php 
include 'login.php';
include 'functionDB1.php';
include 'header.php';

?>

<html>
<head>
		<link rel="stylesheet" type="text/css" href="css/site.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="css/site.css">
<style>
html, body { height: 100%; padding: 0; margin: 0; }
.div   { float:left;}
#div1 { width: 15%; height: 95% }
#div2 { width: 30%; height: 95% }
#div3 { width: 40%; height: 95% }
#div4 { width: 15%; height: 95% }

      		/* width */
            ::-webkit-scrollbar {
              width: 10px;
            }
            
            /* Track */
            ::-webkit-scrollbar-track {
              background: #f1f1f1; 
            }
             
            /* Handle */
            ::-webkit-scrollbar-thumb {
              background: red; 
            }
            
            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
              background: #555; 
            }

#myInput {
  box-sizing: border-box;
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  border: none;
  border-bottom: 1px solid #ddd;
}
#myInputado {
  box-sizing: border-box;
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  border: none;
  border-bottom: 1px solid #ddd;
}
#inputado {
  box-sizing: border-box;
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  border: none;
  border-bottom: 1px solid #ddd;
}


#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
    
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
<script type="text/javascript">
document.cookie = "avia=2";
document.cookie = "ave=2";
document.cookie = "favorito=1";
document.cookie = "favoratibilidade=1";
document.cookie = "highlight=nao realcar";
    $(document).ready(function(){
    	  $("#myInputado").on("keyup", function() {
    	    var value = $(this).val().toLowerCase();
    	    $("#myTabela tr").filter(function() {
    	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    	    });
    	  });
    	});
        /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}
function myFunction1() {
  document.getElementById("myDropdown1").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
    </script>
</head>
<body>

<div id="div1" class="div" style="overflow-y: scroll;">
<h1>Source</h1>
<!--<div class="dropdown">

  <button onclick="myFunction()" class="dropbtn"><i class="fas fa-search"></i></button>
  <div id="myDropdown" class="dropdown-content">-->
  <input id="myInputado" type="text" placeholder="Search...">
  <!--</div>
</div>-->

<?php 

$fontes=getfontes();
$selected_val = $_COOKIE['estado'];
$selected_user = $_COOKIE['user'];
$selected_tema2 = $_COOKIE['tematica'];
$selected_tema1 = explode(",",$_COOKIE['tematica']);
$selected_data1 = $_COOKIE['data1'];
$selected_data2 = $_COOKIE['data2'];
$font = $_COOKIE['fonte'];
$selected_avi = $_COOKIE['avia'];
$selected_favorito = $_COOKIE['favorito'];
$selected_highlight = $_COOKIE['highlight'];
$todas = $font;
$nada = array();
if($todas == 0){
    
$i=1;
$font = explode(",",$font);
if($todas == 0){
    for($k = 1;$k<43;$k++){
        $nada[$k] = $k;
    }
}
foreach($selected_tema1 as $selected_tema3){
    
?>

<?php while( $row = mysqli_fetch_array( $fontes)){  
if(isset($_POST['submit'])){?>
    <script type="text/javascript">
    	var estado ="<?php echo $selected_val = $_POST['estado'];?>";
        var user = "<?php echo $selected_user = $_POST['user'];?>";
        var tema = "<?php echo $selected_tema = $_COOKIE['tematica'];?>";
        document.cookie="estado="+estado;
        document.cookie="user="+user;
        document.cookie="tematica="+tema;
    </script>
    
<?php }

if($selected_val === "publicado" && $selected_user === "a" || $selected_val === "publicado" && $selected_user === "s"){
    
    if($selected_avi === '0' && $selected_favorito === '0' && $selected_highlight === '0'){
        $lista = get_jmnum_pub($nada[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2);
    }else if($selected_avi === '0' && $selected_favorito === '0' || $selected_avi === '1' && $selected_favorito === '0' || $selected_avi === '2' && $selected_favorito === '0' || $selected_avi === '3' && $selected_favorito === '0'){
        if($selected_highlight === '0'){

            $lista = get_user_publ($nada[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_avi);
        }else{
            //echo $selected_tema3;
            $lista = get_user_publ1($nada[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_highlight);
        }
    }else if($selected_avi === '0' && $selected_highlight === '0' || $selected_avi === '1' && $selected_highlight === '0' || $selected_avi === '2' && $selected_highlight === '0' || $selected_avi === '3' && $selected_highlight === '0'){
        if($selected_avi === '0'){
            $lista = get_user_publ2($nada[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito);
        }else{
            $lista = get_user_publ7($nada[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito,$selected_avi);
        }
    }else{
        
        if($selected_avi === '0'){
            $lista = get_user_publ4($nada[$i],$selected_user,$selected_tema1,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight);
        }else{
            $lista = get_user_publ3($nada[$i],$selected_user,$selected_tema1,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight,$selected_avi);
        }
    }
    
}else if($selected_val === "nao_publicado"){
    $lista = get_jmnum_npub($nada[$i],$selected_data1,$selected_data2);
    
}else if($selected_val === "publicado" && $selected_tema2 === "1"){
    $lista = get_jmnum_public($nada[$i],$selected_data1,$selected_data2,$selected_avi);
}else if($selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "0" && $selected_highlight === "0"){
    $lista = get_news_avi($nada[$i],$selected_tema,$selected_data1,$selected_data2);
}else if($selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "nao favoravel" || $selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "favoravel"){
if($selected_highlight === "0"){  
        
        $lista = get_news_avi_fav($nada[$i],$selected_tema2,$selected_data1,$selected_data2,$selected_favorito);
    }else{
        $lista = get_news_avi_fav6($nada[$i],$selected_tema2,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight);
    }
}else if($selected_val === "publicado" && $selected_avi === "0"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "0" && $selected_highlight === "realcar"){
   /*echo 'fasfasfas123123123';*/ $lista = get_news_avi_fav2($nada[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_highlight);
}else if($selected_val === "publicado" && $selected_avi === "1"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "1" && $selected_highlight === "realcar"){
    
    if($selected_favorito === "0"){ 
        $lista = get_news_avi_fav3($nada[$i],$selected_tema2,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
    }else{
        /*echo 'fasfasfas';*/
        $lista = get_news_avi_fav12($nada[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
    }
}else if($selected_val === "publicado" && $selected_avi === "2"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "2" && $selected_highlight === "realcar"){
    if($selected_favorito === "0"){
          
        $lista = get_news_avi_fav3($nada[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
    }else{        //echo 'fasfasfas';
        
        $lista = get_news_avi_fav44($nada[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
    }
}else if($selected_val === "publicado" && $selected_avi === "3"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "3" && $selected_highlight === "realcar"){
    if($selected_favorito === "0"){  
        $lista = get_news_avi_fav3($nada[$i],$selected_tema2,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
        
    }else{
        $lista = get_news_avi_fav4($nada[$i],$selected_tema2,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
    }
}else if($selected_val === "publicado" && $selected_highlight === "0" ){
    if($selected_favorito === "0"){
        
        $lista = get_news_avi_fav50($nada[$i],$selected_tema2,$selected_data1,$selected_data2,$selected_avi,$selected_favorito);
    }else{
        echo $selected_avi;
        $lista = get_news_avi_fav5($nada[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_favorito);
    }
    
}else if($selected_val === "publicado" && $selected_favorito === "0"){
    $lista = get_news_avi_fav1($nada[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi);
}else if($selected_val === "publicado"){
    
    $lista = get_news_tema($nada[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
}
$temas_choose = temas_choose($nada[$i]);
while( $row = mysqli_fetch_array( $temas_choose)){  
$nada1 = $row[0];
}

?>
<table id="table">
<tbody id="myTabela">
    <tr><td style="border:none"><a href="index.php?fonte=<?php echo $nada1;?>"><?php echo $nada1;?><?php echo '<span  style="color:#f0f;">('.$lista.')</span>'?></a></td></tr>
    </tbody>
    </table>
<?php 

$i+=1;
if($i>=count($nada)){
   break;
}
}
}
}else{
    
$i=0;
$font = explode(",",$font);
while( $row = mysqli_fetch_array( $fontes)){  
    if(isset($_POST['submit'])){?>
        <script type="text/javascript">
            var estado ="<?php echo $selected_val = $_POST['estado'];?>";
            var user = "<?php echo $selected_user = $_POST['user'];?>";
            var tema = "<?php echo $selected_tema = $_COOKIE['tematica'];?>"; 
            document.cookie="estado="+estado;
            document.cookie="user="+user;
            document.cookie="tematica="+tema;
        </script> <?php 
 }
 
    if($selected_val === "publicado" && $selected_user === "a" || $selected_val === "publicado" && $selected_user === "s"){
        if($selected_avi === '0' && $selected_favorito === '0' && $selected_highlight === '0'){
            $lista = get_jmnum_pub($font[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2);
        }else if($selected_avi === '0' && $selected_favorito === '0' || $selected_avi === '1' && $selected_favorito === '0' || $selected_avi === '2' && $selected_favorito === '0' || $selected_avi === '3' && $selected_favorito === '0'){
            if($selected_highlight === '0'){
                $lista = get_user_publ($font[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_avi);
            }else{
                $lista = get_user_publ1($font[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_highlight);
            }
            
        }else if($selected_avi === '0' && $selected_highlight === '0' || $selected_avi === '1' && $selected_highlight === '0' || $selected_avi === '2' && $selected_highlight === '0' || $selected_avi === '3' && $selected_highlight === '0'){
            $lista = get_user_publ2($font[$i],$selected_user,$selected_tema,$selected_data1,$selected_data2,$selected_favorito);
        }else{
            if($selected_avi === '0'){
                $lista = get_user_publ4($font[$i],$selected_user,$selected_tema1,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight);
            }else{
                //echo 'fasfasf';
                $lista = get_user_publ3($font[$i],$selected_user,$selected_tema1,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight,$selected_avi);
            }
        }
    }else if($selected_val === "nao_publicado"){
        $lista = get_jmnum_npub($font[$i],$selected_data1,$selected_data2);
    }else if($selected_val === "publicado" && $selected_tema === "1"){
        $lista = get_jmnum_public($font[$i],$selected_data1,$selected_data2,$selected_avi);
    }else if($selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "0" && $selected_highlight === "0"){
        $lista = get_news_avi($font[$i],$selected_tema,$selected_data1,$selected_data2);
    }else if($selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "nao favoravel" || $selected_val === "publicado" && $selected_avi === "0" && $selected_favorito === "favoravel"){
        if($selected_highlight === "0"){
            $lista = get_news_avi_fav($font[$i],$selected_tema,$selected_data1,$selected_data2,$selected_favorito);
        }else{
            $lista = get_news_avi_fav6($font[$i],$selected_tema,$selected_data1,$selected_data2,$selected_favorito,$selected_highlight);
        }
    }else if($selected_val === "publicado" && $selected_avi === "0"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "0" && $selected_highlight === "realcar"){
        echo 'asfafas';$lista = get_news_avi_fav2($font[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_highlight,$selected_avi);
    }else if($selected_val === "publicado" && $selected_avi === "1"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "1" && $selected_highlight === "realcar"){
        if($selected_favorito === "0"){  
            
            $lista = get_news_avi_fav3($font[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
        }else{
            $lista = get_news_avi_fav4_one($font[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
        }
    }else if($selected_val === "publicado" && $selected_avi === "2"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "2" && $selected_highlight === "realcar"){
        if($selected_favorito === "0"){  
            
            $lista = get_news_avi_fav3($font[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
        }else{
             $lista = get_news_avi_fav4_one($font[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
        }
    }else if($selected_val === "publicado" && $selected_avi === "3"  && $selected_highlight === "nao realcar" || $selected_val === "publicado" && $selected_avi === "3" && $selected_highlight === "realcar"){
        if($selected_favorito === "0"){  
             $lista = get_news_avi_fav3($font[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight);
        }else{
           $lista = get_news_avi_fav4_one($font[$i],$selected_tema1,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
        }
    }else if($selected_val === "publicado" && $selected_highlight === "0" ){
         $lista = get_news_avi_fav5($font[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_favorito);
    }else if($selected_val === "publicado" && $selected_favorito === "0"){
         $lista = get_news_avi_fav1($font[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi);
    }else if($selected_val === "publicado"){
      $lista = get_news_tema($font[$i],$selected_tema,$selected_data1,$selected_data2,$selected_avi,$selected_highlight,$selected_favorito);
    }
    $temas_choose = temas_choose($font[$i]);
    while( $row = mysqli_fetch_array( $temas_choose)){  
        $nada1 = $row[0];
        }
    ?>
    <table id="table">
<tbody id="myTabela">
    <tr><td style="border:none"><a href="index.php?fonte=<?php echo $nada1;?>"><?php echo $nada1;?><?php echo '<span  style="color:#f0f;">('.$lista.')</span> '?></a></td></tr>
    </tbody>
    </table>
    <?php 
    
    $i+=1;
    if($i>=count($font)){
       break;
    }
}
}
?>
</div>
<div id="div2" class="div" style="overflow-y: scroll;">
<?php 
if (isset($_GET['fonte'])) {
    include './noticias/jm.php';
}

?>
</div>
<div id="div3" class="div" style="overflow-y: scroll;">
<?php  
if (isset($_GET['id']) && isset($_GET['editar'])==0) {
    include './noticias/noticia/ver.php';
}
if (isset($_GET['editar'])) {
    include './noticias/noticia/editar.php';
}

if (isset($_GET['despublicar'])) {
    include './noticias/noticia/despublicar.php';
}
if (isset($_GET['publicar'])) {
    include './noticias/noticia/publicar.php';
}
if (isset($_GET['apagar'])) {
    include './noticias/noticia/apagar.php';
}

?>
</div>
<div id="div4" class="div" style="overflow-y: scroll;">
<?php 
if (isset($_GET['temas'])) {
    include './temas/tematicas.php';
}
?>
</div>

	
</body>
<script>
function showDiv() {
	   document.getElementById('div2').style.display = "block";
}

function showDiv1() {
	   document.getElementById('div2').style.display = "block";
}
</script>
</html>
